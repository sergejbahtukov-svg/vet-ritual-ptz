<?php
/** Run with wp eval-file, passing the legal-documents directory as the first argument. */
if (! defined('ABSPATH')) { exit; }

$directory = isset($args[0]) ? realpath($args[0]) : false;
if (! $directory || ! is_file($directory . '/manifest.json')) {
    throw new RuntimeException('Legal document manifest is missing.');
}
$manifest = json_decode(file_get_contents($directory . '/manifest.json'), true);
if (! is_array($manifest) || count($manifest) !== 2) {
    throw new RuntimeException('Invalid legal document manifest.');
}
$migration = 'vr_legal_documents_20260918_v1';
if (get_option($migration)) {
    WP_CLI::success('Legal documents already published; editor changes preserved.');
    return;
}
// Validate all inputs before making any changes.
foreach ($manifest as $document) {
    foreach ($document['files'] as $file) {
        $path = $directory . '/' . basename($file['name']);
        if (! is_file($path) || hash_file('sha256', $path) !== $file['sha256']) {
            throw new RuntimeException('Document checksum mismatch: ' . $file['name']);
        }
    }
    if (! is_file($directory . '/' . basename($document['html']))) {
        throw new RuntimeException('Document HTML is missing.');
    }
}
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
$pages = array();
foreach ($manifest as $document) {
    $downloads = array();
    foreach ($document['files'] as $format => $file) {
        $existing = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'meta_key' => '_vr_legal_sha256', 'meta_value' => $file['sha256'], 'numberposts' => 1));
        if ($existing) {
            $attachment_id = $existing[0]->ID;
        } else {
            $temporary = wp_tempnam($file['name']);
            if (! $temporary || ! copy($directory . '/' . $file['name'], $temporary)) {
                throw new RuntimeException('Cannot prepare document upload.');
            }
            $attachment_id = media_handle_sideload(array('name' => $file['name'], 'tmp_name' => $temporary), 0, $document['title'] . ' (' . strtoupper($format) . ')');
            if (is_wp_error($attachment_id)) {
                if (is_file($temporary)) { unlink($temporary); }
                throw new RuntimeException($attachment_id->get_error_message());
            }
            update_post_meta($attachment_id, '_vr_legal_sha256', $file['sha256']);
        }
        $url = wp_get_attachment_url($attachment_id);
        $label = $format === 'pdf' ? 'Открыть PDF' : 'Скачать Word';
        $downloads[] = '<a href="' . esc_url($url) . '"' . ($format === 'pdf' ? ' target="_blank" rel="noopener"' : ' download') . '>' . esc_html($label) . '</a>';
    }
    $content = '<div class="vr-legal-downloads">' . implode("\n", $downloads) . '</div>' . "\n";
    $content .= file_get_contents($directory . '/' . $document['html']);
    $existing = get_page_by_path($document['slug']);
    if ($existing instanceof WP_Post && $existing->post_status === 'publish' && ! get_post_meta($existing->ID, '_vr_legal_document', true)) {
        throw new RuntimeException('Refusing to overwrite an existing published page: ' . $document['slug']);
    }
    $post = array('post_type' => 'page', 'post_status' => 'publish', 'post_name' => $document['slug'], 'post_title' => $document['title'], 'post_content' => wp_slash($content), 'comment_status' => 'closed', 'ping_status' => 'closed');
    if ($existing instanceof WP_Post) { $post['ID'] = $existing->ID; }
    $page_id = wp_insert_post($post, true);
    if (is_wp_error($page_id)) { throw new RuntimeException($page_id->get_error_message()); }
    update_post_meta($page_id, '_wp_page_template', 'page-legal.php');
    update_post_meta($page_id, '_vr_legal_document', '20260918');
    update_post_meta($page_id, '_vr_meta_description', $document['description']);
    if ($document['slug'] === 'privacy-policy') { update_option('wp_page_for_privacy_policy', $page_id); }
    $pages[] = array('id' => $page_id, 'label' => $document['menu_label']);
    WP_CLI::log('Published ' . get_permalink($page_id));
}
$locations = get_theme_mod('nav_menu_locations', array());
$menu_id = isset($locations['footer_legal']) ? (int) $locations['footer_legal'] : 0;
if (! $menu_id) {
    $menu = wp_get_nav_menu_object('Правовые документы');
    $menu_id = $menu ? $menu->term_id : wp_create_nav_menu('Правовые документы');
    if (is_wp_error($menu_id)) { throw new RuntimeException($menu_id->get_error_message()); }
}
$items = wp_get_nav_menu_items($menu_id);
foreach ($pages as $page) {
    $exists = false;
    foreach ($items ?: array() as $item) {
        if ((int) $item->object_id === $page['id'] && $item->object === 'page') { $exists = true; }
    }
    if (! $exists) {
        $result = wp_update_nav_menu_item($menu_id, 0, array('menu-item-title' => $page['label'], 'menu-item-object' => 'page', 'menu-item-object-id' => $page['id'], 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish'));
        if (is_wp_error($result)) { throw new RuntimeException($result->get_error_message()); }
    }
}
$locations['footer_legal'] = (int) $menu_id;
set_theme_mod('nav_menu_locations', $locations);
update_option($migration, gmdate('c'), false);
WP_CLI::success('Published two legal pages and four original files.');
