<?php
$phone_number = get_option('cookinfamily_settings_field_phone_number');
$email = get_option('cookinfamily_settings_field_email');
?>

<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-muted">© <?php echo date('Y') . ' ' . __('CookInFamily', 'cookinfamily'); ?></p>
    <p class="offset-md-4 col-md-4 mb-0 text-end text-muted"><?php echo $email . ' / ' . $phone_number; ?></p>
</footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>