<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$color = (isset($settings['bab_floatingsquares_color'])) ? $settings['bab_floatingsquares_color'] : 'rgba(255, 255, 255, 0.2)';
?>
<div class="bab-floatingsquares-cont bab-elementor">
    <div class="bab-floatingsquares bab-trigger-el" data-color="<?php echo esc_attr($color); ?>">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </div>
</div>