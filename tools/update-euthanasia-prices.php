<?php
/** Update only the euthanasia price group in the selected WordPress install. */

$wp_load = getenv('VR_WP_LOAD') ?: 'C:/xampp/htdocs/vetritual-wp/wp-load.php';
if (! is_file($wp_load)) {
    fwrite(STDERR, "WordPress loader not found: {$wp_load}\n");
    exit(1);
}

require_once $wp_load;

$group = get_page_by_path('usyplenie', OBJECT, 'vr_price_group');
if (! $group instanceof WP_Post) {
    fwrite(STDERR, "Euthanasia price group not found.\n");
    exit(1);
}

$rows = array(
    array('label' => 'до 5 кг', 'value' => '3 500–4 000 руб.'),
    array('label' => 'до 10 кг', 'value' => '4 000–5 000 руб.'),
    array('label' => 'до 20 кг', 'value' => '5 000–6 000 руб.'),
    array('label' => 'до 30 кг', 'value' => '6 500–7 000 руб.'),
    array('label' => 'до 40 кг', 'value' => '7 500–8 000 руб.'),
    array('label' => 'до 50 кг', 'value' => '8 500–9 000 руб.'),
    array('label' => 'до 60 кг', 'value' => 'от 9 500–10 000 руб.'),
);

$apply = in_array('--apply', $argv ?? array(), true);
if ($apply) {
    update_post_meta($group->ID, '_vr_price_rows', $rows);
}

echo ($apply ? 'UPDATED' : 'DRY_RUN') . " price_group={$group->ID}\n";
foreach ((array) get_post_meta($group->ID, '_vr_price_rows', true) as $row) {
    echo ($row['label'] ?? '') . ' | ' . ($row['value'] ?? '') . "\n";
}
