<?php
/**
 * Template for displaying button to view certificate inside course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/certificates/view-button.php.
 *
 * @package LearnPress/Templates/Certificates
 * @author  ThimPress
 * @version 3.0.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * @var LP_Certificate $certificate
 */
if ( ! isset( $certificate ) ) {
	return;
}

$link_cert = $certificate->get_sharable_permalink();
?>

<form name="certificate-form-button" class="form-button" action="<?php echo esc_url( $link_cert ); ?>" method="post">
	<button class="lp-button"><?php esc_html_e( 'Certificate', 'ecademy-toolkit' ); ?></button>
</form>
