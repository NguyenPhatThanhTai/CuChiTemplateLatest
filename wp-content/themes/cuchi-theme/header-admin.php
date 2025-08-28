<?php
/**
 * Custom minimal header for the Booking Admin pages.
 * Keeps all enqueued CSS/JS via wp_head(), but does NOT render the theme's visual header.
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); /* <-- keeps all theme/plugin CSS & JS */ ?>
</head>
<body <?php body_class('admin-tool no-site-header'); ?>>
<?php wp_body_open(); ?>
<!-- (Intentionally no site title/branding here) -->
