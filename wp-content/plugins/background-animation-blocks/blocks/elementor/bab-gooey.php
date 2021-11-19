<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$color = (isset($settings['bab_gooey_color'])) ? $settings['bab_gooey_color'] : '#ffffff';
$height = (isset($settings['bab_gooey_height']['size'])) ? $settings['bab_gooey_height']['size'] : '5';
?>
<div class="bab-gooey-cont bab-elementor">
    <div class="bab-gooey bab-trigger-el" data-height="<?php echo esc_attr($height); ?>" data-color="<?php echo esc_attr($color); ?>"></div>
    <div class="bab-gooey-cont-footer"></div>
    <svg class="bab-gooey-filter">
        <defs>
            <filter id="bab_blob">
            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="blob"></feColorMatrix>
            <feComposite in="SourceGraphic" in2="blob" operator="atop"></feComposite>
            </filter>
        </defs>
    </svg>
</div>