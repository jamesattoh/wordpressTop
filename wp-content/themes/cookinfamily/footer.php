<?php
/**
 * Template pour le pied de page du site
 * Récupère les options configurées dans l'administration
 */

// Récupération des informations de contact depuis les options WordPress
$phone_number = get_option('cookinfamily_settings_field_phone_number');
$email = get_option('cookinfamily_settings_field_email');
?>

<!-- Footer avec mise en page Bootstrap -->
<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <!-- Copyright avec année dynamique et nom du site traduisible -->
    <p class="col-md-4 mb-0 text-muted">
        © <?php echo date('Y') . ' ' . __('CookInFamily', 'cookinfamily'); ?>
    </p>
    
    <!-- Informations de contact avec décalage pour centrage -->
    <p class="offset-md-4 col-md-4 mb-0 text-end text-muted">
        <?php echo $email . ' / ' . $phone_number; ?>
    </p>
</footer>

<!-- Fermeture du conteneur principal ouvert dans header.php -->
</div>

<!-- Inclusion de Bootstrap JS depuis CDN -->
<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" 
    crossorigin="anonymous">
</script>

<!-- Hook WordPress pour les scripts en pied de page -->
<?php wp_footer(); ?>

</body>
</html>