<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$gradient_speed = (isset($settings['bab_background_gradient_speed']['size'])) ? $settings['bab_background_gradient_speed']['size'] : '5';
?>
<div class="bab-gradient bab-elementor bab-trigger-el">
    <div class="bab-gradient-controlls" data-speed="<?php echo esc_attr($gradient_speed); ?>"></div>
</div>