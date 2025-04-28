<!doctype html>
<html lang="fr">

<head>
    <!-- Métadonnées essentielles -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Titre du site - utilise la fonction de traduction WordPress -->
    <title><?php _e('CookInFamily', 'cookinfamily'); ?></title>
    
    <!-- Inclusion de Bootstrap depuis CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" 
          crossorigin="anonymous">
    
    <!-- Hook WordPress pour inclure scripts et styles -->
    <?php wp_head(); ?>
</head>

<body>
    <!-- Conteneur principal Bootstrap -->
    <div class="container">
        <!-- En-tête du site avec navigation -->
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <!-- Logo et introduction -->
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <!-- Logo du site - utilise le chemin du thème enfant -->
                <img class="bi me-2 mb-2" 
                     width="137" 
                     height="113" 
                     src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" 
                     alt="<?php _e('CookInFamily', 'cookinfamily'); ?>" />
                
                <!-- Texte d'introduction récupéré des options du site -->
                <span class="fs-5">
                    <?php
                    $introduction = get_option('cookinfamily_settings_field_introduction');
                    echo $introduction;
                    ?>
                </span>
            </a>
            
            <!-- Menu de navigation -->
            <ul class="nav nav-pills">
                <!-- Lien vers l'accueil -->
                <li class="nav-item">
                    <a href="/" class="nav-link link-secondary">
                        <?php _e('Accueil', 'cookinfamily'); ?>
                    </a>
                </li>
                <!-- Lien vers le cours WordPress -->
                <li class="nav-item">
                    <a href="https://github.com/OpenClassrooms-Student-Center/8069121-Perfectionnez-vous-sur-WordPress" 
                       target="_blank" 
                       class="nav-link link-secondary">
                        <?php _e('Cours Wordpress Se Perfectionner', 'cookinfamily'); ?>
                    </a>
                </li>
            </ul>
        </header>