<?php

/**
 * S1: CRÉATION DU MENU D'ADMINISTRATION
 */

// creation d'une nouvelle page dans le menu d'administration
function cookinfamily_add_admin_pages() {
    add_menu_page(
        __('Paramètres du thème CookInFamily', 'cookinfamily'),
        __('CookInFamily', 'cookinfamily'),
        'manage_options',
        'cookinfamily-settings', // Ce slug devient l'identifiant unique de la page, mettre le - au lieu de _ pour régler le problème d'affichage de la page
        'cookinfamily_theme_settings',
        'dashicons-admin-settings',
        60
    );
}
add_action('admin_menu', 'cookinfamily_add_admin_pages'); // Hook qui ajoute notre fonction au menu d'administration


/**
 * S2: AFFICHAGE DU CONTENU DE LA PAGE
 */

function cookinfamily_theme_settings() {
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
function cookinfamily_settings_register() {
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
function cookinfamily_settings_fields_validate($inputs) {
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
function cookinfamily_settings_section_introduction() {
    _e('Paramètrez les différentes options de votre thème CookInFamily.', 'cookinfamily'); // _e() est identique à echo __()
}


// Affiche le champ Introduction
function cookinfamily_settings_field_introduction_output() {
    $value = get_option('cookinfamily_settings_field_introduction');
    echo '<input name="cookinfamily_settings_field_introduction" type="text" value="' . $value . '" />';
}
// Affiche le champ telephone
function cookinfamily_settings_field_phone_number_output() {
    $value = get_option('cookinfamily_settings_field_phone_number');
    echo '<input name="cookinfamily_settings_field_phone_number" type="text" value="' . $value . '" />';
}
// Affiche le champ email
function cookinfamily_settings_field_email_output() {
    $value = get_option('cookinfamily_settings_field_email');
    echo '<input name="cookinfamily_settings_field_email" type="text" value="' . $value . '" />';
}
