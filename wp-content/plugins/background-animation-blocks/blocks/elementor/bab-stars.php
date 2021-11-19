<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$star_size = (isset($settings['bab_background_srars_size']['size'])) ? $settings['bab_background_srars_size']['size'] : '3';
$star_scale = (isset($settings['bab_background_srars_min_scale']['size'])) ? $settings['bab_background_srars_min_scale']['size'] : '0.2';
$star_color = (isset($settings['bab_background_srars_color'])) ? $settings['bab_background_srars_color'] : '#000';
?>
<div class="bab-stars-cont bab-elementor">
	<canvas class="bab-stars bab-trigger-el" data-size="<?php echo esc_attr($star_size); ?>" data-scale="<?php echo esc_attr($star_scale); ?>" data-color="<?php echo esc_attr($star_color); ?>"></canvas>
</div>