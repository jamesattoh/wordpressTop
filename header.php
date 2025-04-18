<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php _e('CookInFamily', 'cookinfamily'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <img class="bi me-2 mb-2" width="137" height="113" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="<?php _e('CookInFamily', 'cookinfamily'); ?>" />
                <span class="fs-5">
                    <?php
                    $introduction = get_option('cookinfamily_settings_field_introduction');

                    echo $introduction;
                    ?>
                </span>
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="/" class="nav-link link-secondary"><?php _e('Accueil', 'cookinfamily'); ?></a></li>
                <li class="nav-item"><a href="https://github.com/OpenClassrooms-Student-Center/8069121-Perfectionnez-vous-sur-WordPress" target="_blank" class="nav-link link-secondary"><?php _e('Cours Wordpress Se Perfectionner', 'cookinfamily'); ?></a></li>
            </ul>
        </header>