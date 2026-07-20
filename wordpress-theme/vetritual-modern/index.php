<?php
$route = vr_get_route_info();

if (is_front_page() || is_home() || $route['slug'] === 'home') {
    require get_template_directory() . '/front-page.php';
    return;
}

if (vr_route_is_known($route['slug']) || is_page()) {
    require get_template_directory() . '/page.php';
    return;
}

require get_template_directory() . '/404.php';

