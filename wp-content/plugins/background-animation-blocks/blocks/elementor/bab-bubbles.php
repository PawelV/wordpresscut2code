<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$color = (isset($settings['bab_bubbles_color'])) ? $settings['bab_bubbles_color'] : '#1A09FF';
$count = (isset($settings['bab_bubbles_count']['size'])) ? $settings['bab_bubbles_count']['size'] : '20';
$speed = (isset($settings['bab_bubbles_speed']['size'])) ? $settings['bab_bubbles_speed']['size'] : '1';
?>
<div class="bab-bubbles-cont bab-elementor">
    <canvas class="bab-bubbles bab-trigger-el" data-count="<?php echo esc_attr($count); ?>" data-color="<?php echo esc_attr($color); ?>" data-speed="<?php echo esc_attr($speed); ?>"></canvas>
</div>