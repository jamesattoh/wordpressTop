<?php

/**
 * S1: CRÉATION DU MENU D'ADMINISTRATION
 */

// creation d'une nouvelle page dans le menu d'administration
function cookinfamily_add_admin_pages()
{
    add_menu_page(
        __('Paramètres du thème CookInFamily', 'cookinfamily'),
        __('CookInFamily', 'cookinfamily'),
        'manage_options',
        'cookinfamily-settings', // Ce slug devient l'identifiant unique de la page, mettre le - au lieu de _ pour régler le problème d'affichage de la page
        'cookinfamily_theme_settings',
        'dashicons-editor-code',
        60
    );
}
add_action('admin_menu', 'cookinfamily_add_admin_pages'); // Hook qui ajoute notre fonction au menu d'administration


/**
 * S2: AFFICHAGE DU CONTENU DE LA PAGE
 */

function cookinfamily_theme_settings()
{
    // Affiche le formulaire des paramètres
    echo '<h1>' . esc_html(get_admin_page_title()) . '</h1>'; // esc_html prévient les attaques XSS en convertissant les caractères spéciaux HTML en entités HTML

    echo '<form action="options.php" method="post" name="cookinfamily_settings">';

    echo '<div>';

    settings_fields('cookinfamily_settings_fields'); // en unique paramètre, le nom du groupe du lot de réglages.
    do_settings_sections('cookinfamily-settings'); // on lui passe l’identifiant de la page et elle va afficher les champs associés aux sections
    submit_button(); // c'est le bouton "Engeristrer les modifications"

    echo '</div>';

    echo '</form>';
}


/**
 * S3: ENREGISTREMENT DES PARAMÈTRES
 */

//Initialise les paramètres et sections de la page d'options
function cookinfamily_settings_register()
{
    // 1. Enregistrement du groupe de paramètres
    register_setting( // s'exécute lors du chargement de la page d'admin de WordPress (via le hook admin_init), et sert à déclarer un réglage auprès de WordPress
        'cookinfamily_settings_fields',      // Groupe d'options
        'cookinfamily_settings_fields',      // Option dans la BDD
        'cookinfamily_settings_fields_validate' // Fonction de validation
    );

    // 2. Ajout d'une section de paramètres pour ranger les réglages
    add_settings_section(
        'cookinfamily_settings_section',     // ID unique
        __('Paramètres', 'cookinfamily'),    // Titre
        'cookinfamily_settings_section_introduction', // Callback d'intro
        'cookinfamily-settings'              // Page cible
    );

    // 3. Ajout des champs de formulaire
    add_settings_field(
        'cookinfamily_settings_field_introduction', // ID unique
        __('Introduction', 'cookinfamily'),         // Label
        'cookinfamily_settings_field_introduction_output', // Callback d'affichage
        'cookinfamily-settings',                    // Page cible
        'cookinfamily_settings_section'             // Section cible
    );

    add_settings_field(
        'cookinfamily_settings_field_phone_number', // ID unique
        __('Numéro de téléphone', 'cookinfamily'),         // Label
        'cookinfamily_settings_field_phone_number_output', // Callback d'affichage
        'cookinfamily-settings',                    // Page cible
        'cookinfamily_settings_section'             // Section cible
    );

    add_settings_field(
        'cookinfamily_settings_field_email', // ID unique
        __('Adresse mail', 'cookinfamily'),         // Label
        'cookinfamily_settings_field_email_output', // Callback d'affichage
        'cookinfamily-settings',                    // Page cible
        'cookinfamily_settings_section'             // Section cible
    );
}
add_action('admin_init', 'cookinfamily_settings_register');


/**
 * SECTION 4: FONCTIONS DE CALLBACK
 */

// pour nettoyer et valider les données soumises par le formulaire
function cookinfamily_settings_fields_validate($inputs)
{
    if (!empty($_POST)) {
        if (!empty($_POST['cookinfamily_settings_field_introduction'])) {
            update_option('cookinfamily_settings_field_introduction', $_POST['cookinfamily_settings_field_introduction']);
        }
        if (!empty($_POST['cookinfamily_settings_field_phone_number'])) {
            update_option('cookinfamily_settings_field_phone_number', $_POST['cookinfamily_settings_field_phone_number']);
        }
        if (!empty($_POST['cookinfamily_settings_field_email'])) {
            update_option('cookinfamily_settings_field_email', $_POST['cookinfamily_settings_field_email']);
        }
    }
    return $inputs;
}

// Affiche le texte d'introduction de la section des paramètres
function cookinfamily_settings_section_introduction()
{
    _e('Paramètrez les différentes options de votre thème CookInFamily.', 'cookinfamily'); // _e() est identique à echo __()
}


// Affiche le champ Introduction
function cookinfamily_settings_field_introduction_output()
{
    $value = get_option('cookinfamily_settings_field_introduction');
    echo '<input name="cookinfamily_settings_field_introduction" type="text" value="' . $value . '" />';
}
// Affiche le champ telephone
function cookinfamily_settings_field_phone_number_output()
{
    $value = get_option('cookinfamily_settings_field_phone_number');
    echo '<input name="cookinfamily_settings_field_phone_number" type="text" value="' . $value . '" />';
}
// Affiche le champ email
function cookinfamily_settings_field_email_output()
{
    $value = get_option('cookinfamily_settings_field_email');
    echo '<input name="cookinfamily_settings_field_email" type="text" value="' . $value . '" />';
}


/**
 * Enregistre un nouveau type de contenu personnalisé (Custom Post Type) pour les ingrédients
 * Cette fonction est appelée lors de l'initialisation de WordPress
 */
function cookinfamily_register_custom_post_types()
{
    // Définition des labels (textes) qui apparaîtront dans l'interface d'administration
    $labels_ingredient = array(
        'menu_name'         => __('Ingrédients', 'cookinfamily'),    // Nom dans le menu
        'name_admin_bar'    => __('Ingrédient', 'cookinfamily'),     // Nom dans la barre d'admin
        'add_new_item'      => __('Ajouter un nouvel ingrédient', 'cookinfamily'),  // Texte pour ajouter     
        'new_item'          => __('Nouvel ingrédient', 'cookinfamily'),     // Texte pour nouveau
        'edit_item'         => __('Modifier l\'ingrédient', 'cookinfamily'), // Texte pour modifier
    );

    // Configuration complète du Custom Post Type
    $args_ingredient = array(
        'label'                 => __('Ingrédients', 'cookinfamily'),
        'description'           => __('Ingrédients', 'cookinfamily'),
        'labels'                => $labels_ingredient,    // Utilise les labels définis ci-dessus
        'supports'              => array('title', 'thumbnail', 'excerpt', 'editor'),  // Fonctionnalités supportées
        'hierarchical'          => false,    // false = format post, true = format page
        'public'                => true,     // Visible pour le public
        'show_ui'               => true,     // Affiche interface dans l'admin
        'show_in_menu'          => true,     // Affiche dans le menu admin
        'menu_position'         => 40,       // Position dans le menu (40 = après Comments)
        'show_in_admin_bar'     => true,     // Visible dans la barre d'admin
        'show_in_nav_menus'     => true,     // Peut être utilisé dans les menus
        'can_export'            => true,     // Peut être exporté
        'has_archive'           => true,     // Active les pages d'archives
        'exclude_from_search'   => false,    // Inclus dans la recherche
        'publicly_queryable'    => true,     // Accessible via les requêtes publiques
        'capability_type'       => 'post',   // Utilise les mêmes capacités qu'un post
        'menu_icon'             => 'dashicons-drumstick',  // Icône dans le menu admin
    );

    // Enregistre le Custom Post Type avec WordPress
    register_post_type('cif_ingredient', $args_ingredient);
}
// Hook la fonction à l'initialisation de WordPress avec priorité 11
add_action('init', 'cookinfamily_register_custom_post_types', 11);


/**
 * Enregistre une nouvelle taxonomie pour classer les recettes par type de plat
 * Une taxonomie permet de catégoriser les contenus
 * C'est ce qui s'affiche (déroule verticalement vers le bas) lorsqu'on clique sur un type de contenu dans le menu de gauche du back-office
 */
function cookinfamily_register_taxonomies()
{
    // Définition des labels pour la taxonomie
    $labels = array(
        'name'              => __('Type de plat'),          // Nom général
        'singular_name'     => __('Type de plat'),          // Nom au singulier
        'search_items'      => __('Rechercher un type de plat'),  // Texte de recherche
        'all_items'         => __('Tous les types de plats'),     // Liste tous les items
        'parent_item'       => __('Parent Type de plat'),         // Item parent
        'parent_item_colon' => __('Parent Type de plat:'),        // Item parent avec colon
        'edit_item'         => __('Modifier un type de plat'),    // Modification
        'update_item'       => __('Mettre à jour un type de plat'),  // Mise à jour
        'add_new_item'      => __('Ajouter un nouveau type de plat'), // Ajout
        'new_item_name'     => __('Nouveau type de plat'),        // Nouveau nom
        'menu_name'         => __('Type de plat')                 // Nom dans le menu
    );

    // Configuration de la taxonomie
    $args = array(
        'hierarchical'      => true,         // true = comme les catégories, false = comme les tags
        'labels'            => $labels,       // Utilise les labels définis ci-dessus
        'show_ui'           => true,         // Interface dans l'admin
        'show_admin_column' => true,         // Colonne dans la liste des posts
        'query_var'         => true,         // Peut être requêté
        'show_in_rest'      => true,         // Support de Gutenberg
        'rewrite'           => array('slug' => 'type-de-plat')  // URL pour les archives
    );

    // Enregistre la taxonomie et l'associe au type de contenu 'recettes'
    register_taxonomy('type_de_plat', array('recettes'), $args);



    // Définition des labels pour la taxonomie
    $labels = array(
        'name'              => __('Régime alimentaire'),          // Nom général
        'singular_name'     => __('Régime alimentaire'),          // Nom au singulier
        'search_items'      => __('Rechercher un régime alimentaire'),  // Texte de recherche
        'all_items'         => __('Tous les régimes alimmentaires'),     // Liste tous les items
        'parent_item'       => __('Parent régime alimentaire'),         // Item parent
        'parent_item_colon' => __('Parent régime alimentaire:'),        // Item parent avec colon
        'edit_item'         => __('Modifier un régime alimentaire'),    // Modification
        'update_item'       => __('Mettre à jour un régime alimentaire'),  // Mise à jour
        'add_new_item'      => __('Ajouter un nouveau régime alimentaire'), // Ajout
        'new_item_name'     => __('Nouveau régime alimentaire'),        // Nouveau nom
        'menu_name'         => __('Régime alimentaire')                 // Nom dans le menu
    );

    // Configuration de la taxonomie
    $args = array(
        'hierarchical'      => true,         // true = comme les catégories, false = comme les tags
        'labels'            => $labels,       // Utilise les labels définis ci-dessus
        'show_ui'           => true,         // Interface dans l'admin
        'show_admin_column' => true,         // Colonne dans la liste des posts
        'query_var'         => true,         // Peut être requêté
        'show_in_rest'      => true,         // Support de Gutenberg
        'rewrite'           => array('slug' => 'regime-alimentaire')  // URL pour les archives
    );

    // Enregistre la taxonomie et l'associe au type de contenu 'recettes'
    register_taxonomy('regime-alimentaire', array('recettes'), $args);
}
// Hook la fonction à l'initialisation de WordPress
add_action('init', 'cookinfamily_register_taxonomies');


/**
 * Fonction qui permet de récupérer les recettes via une requête AJAX
 * Cette fonction sera appelée côté front-end via JavaScript
 * 
 * @return void Retourne les données au format JSON
 */
function cookinfamily_request_recettes()
{
    // Paramètres de la requête WP_Query
    $args = array(
        'post_type' => 'recettes',       // Type de contenu personnalisé 'recettes'
        'posts_per_page' => 2            // Nombre de recettes par page
    );

    // Exécution de la requête
    $query = new WP_Query($args);

    // Vérification des résultats
    if ($query->have_posts()) {
        $response = $query;              // Stocke les résultats si des recettes sont trouvées
    } else {
        $response = false;               // Retourne false si aucune recette n'est trouvée
    }

    // Envoi de la réponse au format JSON
    wp_send_json($response);

    // Termine proprement l'exécution du script AJAX
    wp_die();
}

// Enregistre les hooks AJAX pour rendre la fonction accessible depuis le front-end
add_action('wp_ajax_request_recettes', 'cookinfamily_request_recettes');           // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_request_recettes', 'cookinfamily_request_recettes');    // Pour les utilisateurs non connectés

/**
 * Note : Pour appeler cette fonction en AJAX depuis le front-end, utiliser :
 * URL : /wp-admin/admin-ajax.php
 * Data : { action: 'request_recettes' }
 * Method : POST
 */


/**
 * Enregistre et charge les scripts JavaScript nécessaires au thème
 * Cette fonction est appelée lors du chargement des scripts WordPress
 */
function cookinfamily_scripts() {
    // Enregistre et charge le script JavaScript principal du thème
    wp_enqueue_script(
        'cookinfamily',                                              // Identifiant unique du script
        get_stylesheet_directory_uri() . '/assets/js/cookinfamily.js', // Chemin vers le fichier JS
        array('jquery'),                                             // Dépendances (ici jQuery)
        '1.0.0',                                                     // Numéro de version
        true                                                         // Chargement dans le footer
    );

    // Rend l'URL de l'API AJAX WordPress disponible dans JavaScript
    wp_localize_script(
        'cookinfamily',                                             // Identifiant du script cible
        'cookinfamily_js',                                          // Nom de l'objet JavaScript créé
        array('ajax_url' => admin_url('admin-ajax.php'))            // Variables à passer à JavaScript
    );
}

// Enregistre la fonction pour qu'elle soit exécutée pendant le chargement des scripts
add_action('wp_enqueue_scripts', 'cookinfamily_scripts');


/**
 * Enqueue block template skip link
 */
function cookinfamily_enqueue_skip_link() {
    wp_enqueue_block_template_skip_link();
}
add_action('wp_footer', 'cookinfamily_enqueue_skip_link', 1);

// Désactive l'ancienne fonction dépréciée
remove_action('wp_footer', 'the_block_template_skip_link', 1);

