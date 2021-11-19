<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$f_color = (isset($settings['bab_blurred_circles_color'])) ? $settings['bab_blurred_circles_color'] : '#e45a84';
$s_color = (isset($settings['bab_blurred_circles_color_s'])) ? $settings['bab_blurred_circles_color_s'] : '#583c87';
$t_color = (isset($settings['bab_blurred_circles_color_t'])) ? $settings['bab_blurred_circles_color_t'] : '#ffacac';
$fo_color = (isset($settings['bab_blurred_circles_color_fo'])) ? $settings['bab_blurred_circles_color_fo'] : '#a76fc7';
?>
<div class="bab-blurred-circles-cont bab-elementor">
    <div class="bab-blurred-circles bab-trigger-el" data-first="<?php echo esc_attr($f_color); ?>" data-second="<?php echo esc_attr($s_color); ?>" data-third="<?php echo esc_attr($t_color); ?>" data-fourth="<?php echo esc_attr($fo_color); ?>">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>