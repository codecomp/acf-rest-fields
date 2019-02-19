<?php
/**
 * Add fields for admin options page
 *
 * @link       https://github.com/codecomp/acf-rest-fields
 * @since      1.0.0
 *
 * @package    Acf_Rest_Fields
 * @subpackage Acf_Rest_Fields/admin/partials
 */
?>

<form action='options.php' method='post'>

    <h2>ACF REST Fields</h2>

    <?php
    settings_fields( 'acf-rest-fields' );
    do_settings_sections( 'acf-rest-fields' );
    submit_button();
    ?>

</form>
