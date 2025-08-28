<?php 
if (!is_user_logged_in()) { auth_redirect(); exit; }
/* Template Name: Admin Tool (SPA) */
get_header('admin');
require get_theme_file_path('resources/views/layouts/admin.blade.php');
get_footer();