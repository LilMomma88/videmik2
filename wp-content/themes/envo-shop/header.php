<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>

        <link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri() ?>/css/custom.css?id=<?= time() ?>">
    </head>
    <body id="blog" <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <div class="page-wrap">
            <?php get_template_part('template-parts/template-part', 'topnav'); ?>
            <?php get_template_part('template-parts/template-part', 'head'); ?>
