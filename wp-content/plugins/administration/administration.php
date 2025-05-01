<?php

/**
 * Plugin Name: Administration
 * Plugin URI:  
 * Description: Ajoutez une page d'administration pour modifier la couleur de fond de votre site WordPress.
 * Version:     1.0.0
 * Author:      Mr James
 * Author URI:  
 * Text Domain: administration
 */

/**
 * Crée une nouvelle page dans le menu d'administration WordPress
 * Cette fonction est appelée via le hook 'admin_menu'
 * 
 * @return void
 */
function administration_add_admin_page() {
    add_submenu_page(
        'options-general.php',    // Page parent (Réglages)
        'Mes options',           // Titre de la page dans le navigateur
        'Mes réglages',         // Titre dans le menu
        'manage_options',       // Capacité requise pour voir cette page
        'administration',       // Slug de la page
        'administration_page'   // Fonction qui affiche le contenu
    );
}

/**
 * Affiche le contenu de la page d'administration
 * Gère l'affichage du formulaire et la sauvegarde des options
 * 
 * @return void
 */
function administration_page() {
    // Définition des couleurs disponibles avec leurs libellés
    $couleurs_disponibles = array(
        'ffffff' => 'Blanc',
        'f8f9fa' => 'Gris Clair',
        'fff5e6' => 'Beige Doux',
        'e6f3ff' => 'Bleu Ciel',
        'f0fff0' => 'Vert Menthe',
        'fff0f5' => 'Rose Poudré'
    );

    // Traitement du formulaire lors de sa soumission
    if (isset($_POST['submit'])) {
        update_option('couleur_fond_site', $_POST['fond_couleur']);
    }

    // Récupération de la couleur actuellement sélectionnée
    $couleur_actuelle = get_option('couleur_fond_site');
?>
    <!-- Interface utilisateur du formulaire -->
    <div class="wrap">
        <h1>Mes options</h1>
        <form method="post" action="">
            <label for="fond_couleur">Choisissez une couleur : </label>
            <select id="fond_couleur" name="fond_couleur">
                <?php foreach ($couleurs_disponibles as $valeur => $libelle) { ?> <!-- => permettra de lier une clé à sa valeur si on considère le tableau associatif couleurs_disponibles -->
                    <option 
                        value="<?php echo $valeur; ?>" 
                        <?php selected($couleur_actuelle, $valeur); ?>>
                        <?php echo $libelle; ?>
                    </option>
                <?php } ?>
            </select>
            <input 
                type="submit" 
                name="submit" 
                class="button button-primary" 
                value="Enregistrer" 
            />
        </form>
    </div>
<?php
}

// Enregistre la page d'administration dans le menu WordPress
add_action('admin_menu', 'administration_add_admin_page');

/**
 * Ajoute la couleur de fond au site
 * Cette fonction est appelée dans le head de la page
 * 
 * @return void
 */
function ajouter_couleur_fond_site() {
    // Récupère la couleur sélectionnée dans les options
    $couleur_fond = get_option('couleur_fond_site');
?>
    <!-- Injection du style CSS pour la couleur de fond -->
    <style>
        body {
            background-color: #<?php echo esc_attr($couleur_fond); ?>
        }
    </style>
<?php
}

// Ajoute le style CSS dans le head du site
add_action('wp_head', 'ajouter_couleur_fond_site');
