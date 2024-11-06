<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">


    <?php wp_head(); ?>
</head>

<body class="bg-primary-bg font-ibm">
    <?php wp_body_open(); ?>
    <?php
    include get_template_directory() . '/src/components/header.php';
    include get_template_directory() . '/src/home.php';
    include get_template_directory() . '/src/components/footer.php';
    ?>
    <script src="<?php echo get_template_directory_uri(); ?>/dist/video-script.min.js" deffer></script>
</body>

</html>