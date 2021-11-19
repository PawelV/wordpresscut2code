<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$f_color = (isset($settings['bab_background_diagonals_color'])) ? $settings['bab_background_diagonals_color'] : '#66cc33';
$s_color = (isset($settings['bab_background_diagonals_color_s'])) ? $settings['bab_background_diagonals_color_s'] : '#0099ff';
?>
<div class="bab-diagonals-cont bab-elementor">
    <div class="bab-diagonals-lines bab-trigger-el" data-first="<?php echo esc_attr($f_color); ?>" data-second="<?php echo esc_attr($s_color); ?>">
        <div class="bab-diagonals"></div>
        <div class="bab-diagonals bab-bg2"></div>
        <div class="bab-diagonals bab-bg3"></div>
    </div>
</div>