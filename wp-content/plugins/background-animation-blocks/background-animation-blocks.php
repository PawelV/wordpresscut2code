<?php
/*
   Plugin Name: Background animation blocks
   Description: Powerful Gutenberg & Elementor animated blocks, that makes your website awesome!
   Author: WebArea
   Version: 2.0.0
   Text Domain: bab
   Domain Path: /languages
   License: GPLv2 or later
   License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Class WA_BAB
 */
class WA_BAB {
    /**
     * The single class instance.
     *
     * @var $instance
     */
    private static $instance = null;

    /**
     * Main Instance
     * Ensures only one instance of this class exists in memory at any one time.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
            self::$instance->init();
            self::$instance->init_hooks();
        }
        return self::$instance;
    }

    /**
     * Path to the plugin directory
     *
     * @var $plugin_path
     */
    public $plugin_path;

    /**
     * URL to the plugin directory
     *
     * @var $plugin_url
     */
    public $plugin_url;

    /**
     * Version of the plugin
     *
     * @var $plugin_version
     */
    public $plugin_version;

    private $arr_bab_elementor_output = array();

    /**
     * WA_BAB constructor.
     */
    public function __construct() {
        /* We do nothing here! */
    }

    /**
     * Init
     */
    public function init() {
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url  = plugin_dir_url( __FILE__ );
        $this->plugin_version  = '2.0.0';
    }

    /**
     * Init hooks
     */
    public function init_hooks() {
        add_action( 'enqueue_block_editor_assets', array( $this, 'bab_blocks_scripts' ));
        add_action( 'enqueue_block_assets', array( $this, 'bab_general_scripts' ) );
        add_filter( 'block_categories_all', array( $this, 'bab_block_categories' ), 10, 2);
		load_plugin_textdomain( 'bab', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

        if ( did_action( 'elementor/loaded' ) ) {
            add_action('elementor/frontend/after_enqueue_scripts', array($this, 'bab_enqueue_editor_scripts'), 10);
            add_action('elementor/element/section/section_background_overlay/after_section_end', array($this, 'bab_section_style_controls'),10, 2);
			add_action('elementor/frontend/section/after_render', array($this, 'bab_front_after_render'));
	    	add_action('wp_print_footer_scripts', array($this, 'bab_print_footer_html'));

            // Ajax
            add_action( 'wp_ajax_bab_get_elementor_block', array($this, 'bab_get_elementor_block_func') );
            add_action( 'wp_ajax_nopriv_bab_get_elementor_block', array($this, 'bab_get_elementor_block_func') );
        }
    }

    /**
     * Enqueue general scripts.
     */
    public function bab_general_scripts() {
        wp_enqueue_style('bab-editor-block-css', $this->plugin_url . 'assets/css/main.css', array(), $this->plugin_version);
        wp_register_script('bab-stars', $this->plugin_url . 'assets/js/plugins/stars.js', array(), $this->plugin_version, true);
        wp_register_script('bab-blurred-circles', $this->plugin_url . 'assets/js/plugins/blurred-circles.js', array(), $this->plugin_version, true);
        wp_register_script('bab-bubbles', $this->plugin_url . 'assets/js/plugins/bubbles.js', array(), $this->plugin_version, true);
        wp_register_script('bab-gooey', $this->plugin_url . 'assets/js/plugins/gooey.js', array(), $this->plugin_version, true);
        
        wp_enqueue_script( 'bab-front', $this->plugin_url . 'assets/js/main.js', array('bab-stars', 'bab-blurred-circles', 'bab-bubbles', 'bab-gooey'), $this->plugin_version, true );
    }

    /**
     * Enqueue blocks scripts.
     */
    public function bab_blocks_scripts() {
        $depends = array( 'wp-blocks', 'wp-i18n', 'jquery', 'bab-stars', 'bab-blurred-circles', 'bab-bubbles', 'bab-gooey' );

        if ( wp_script_is( 'wp-edit-widgets' ) ) {
            $depends[] = 'wp-edit-widgets';
        } else {
            $depends[] = 'wp-edit-post';
        }
        wp_enqueue_script('b-editor-block', $this->plugin_url . 'blocks/js/main.js', $depends, $this->plugin_version);
    }

    /**
     * Add block category
     */
    public function bab_block_categories( $categories, $post ) {
        return array_merge(
            $categories,
            array(
                array(
                    'slug' => 'wa-bab-blocks',
                    'title' => esc_html__( 'Background animation blocks', 'bab' ),
                ),
            )
        );
    }

    /**
     * Add tab to elementor section
     */
    public function bab_section_style_controls($objControls, $args){
        $objControls->start_controls_section(
			'bab_background',
			[
				'label' => __( 'Background animation blocks', 'bab' ),
				'tab' => "style",
			]
		);

        $objControls->add_control(
			'bab_background_style',
			[
				'type'      => \Elementor\Controls_Manager::SELECT,
				'label'     => esc_html__( 'Background style', 'bab' ),
                'options'   => [
					'' => esc_html__( 'None', 'bab' ),
					'stars' => esc_html__( 'Stars', 'bab' ),
					'gradient' => esc_html__( 'Gradient', 'bab' ),
					'diagonals' => esc_html__( 'Diagonal lines', 'bab' ),
					'circles' => esc_html__( 'Blurred circles', 'bab' ),
					'bubbles' => esc_html__( 'Bubbles', 'bab' ),
					'gooey' => esc_html__( 'Gooey effect', 'bab' ),
					'paralaxpixel' => esc_html__( 'Parallax pixel', 'bab' ),
					'floatingsquares' => esc_html__( 'Floating squares', 'bab' ),
				],
                'default'   => '',
                'separator' => 'after'
			]
        );

        // Stars
        $objControls->add_control(
			'bab_background_srars_size',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Star size', 'bab' ),
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 2,
						'max'  => 20,
						'step' => 1
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 3
                ],
                'condition'  => [
					'bab_background_style' => 'stars',
				]
			]
		);
        $objControls->add_control(
			'bab_background_srars_min_scale',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Star min scale', 'bab' ),
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0.2,
						'max'  => 1,
						'step' => 0.1
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0.2
                ],
                'condition'  => [
					'bab_background_style' => 'stars',
				]
			]
		);
        $objControls->add_control(
			'bab_background_srars_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Star color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'stars',
				]
			]
		);

        // Gradient
        $objControls->add_control(
			'bab_background_gradient_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'First color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'gradient',
				]
			]
		);
        $objControls->add_control(
			'bab_background_gradient_color_stop',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Location', 'bab' ),
				'size_units' => [ '%' ],
				'default'    => [
					'unit' => '%',
					'size' => 0
                ],
                'render_type' => 'ui',
                'condition'  => [
					'bab_background_style' => 'gradient',
				]
			]
		);
        $objControls->add_control(
			'bab_background_gradient_color_s',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Second color', 'bab' ),
                'default' => '#f2295b',
                'condition'  => [
					'bab_background_style' => 'gradient',
				]
			]
		);
        $objControls->add_control(
			'bab_background_gradient_color_s_stop',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Location', 'bab' ),
				'size_units' => [ '%' ],
				'default'    => [
					'unit' => '%',
					'size' => 100
                ],
                'render_type' => 'ui',
                'condition'  => [
					'bab_background_style' => 'gradient',
				]
			]
		);
        $objControls->add_control(
			'bab_background_gradient_color_angle',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Angle', 'bab' ),
				'size_units' => [ 'deg' ],
				'default'    => [
					'unit' => 'deg',
					'size' => 50
                ],
                'range' => [
                    'deg' => [
                        'step' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .bab-gradient' => 'background: linear-gradient({{SIZE}}{{UNIT}}, {{bab_background_gradient_color.VALUE}} {{bab_background_gradient_color_stop.SIZE}}{{bab_background_gradient_color_stop.UNIT}}, {{bab_background_gradient_color_s.VALUE}} {{bab_background_gradient_color_s_stop.SIZE}}{{bab_background_gradient_color_s_stop.UNIT}})',
                ],
                'condition'  => [
					'bab_background_style' => 'gradient',
				]
			]
		);
        $objControls->add_control(
			'bab_background_gradient_speed',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Animation speed', 'bab' ),
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 20,
						'step' => 1
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 5
                ],
                'condition'  => [
					'bab_background_style' => 'gradient',
				]
			]
		);

        // Diagonal lines
        $objControls->add_control(
			'bab_background_diagonals_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'First color', 'bab' ),
                'default' => '#66cc33',
                'condition'  => [
					'bab_background_style' => 'diagonals',
				]
			]
		);
        $objControls->add_control(
			'bab_background_diagonals_color_s',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Second color', 'bab' ),
                'default' => '#0099ff',
                'condition'  => [
					'bab_background_style' => 'diagonals',
				]
			]
		);

        // Blurred circles
        $objControls->add_control(
			'bab_blurred_circles_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'First color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'circles',
				]
			]
		);
        $objControls->add_control(
			'bab_blurred_circles_color_s',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Second color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'circles',
				]
			]
		);
        $objControls->add_control(
			'bab_blurred_circles_color_t',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Third color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'circles',
				]
			]
		);
        $objControls->add_control(
			'bab_blurred_circles_color_fo',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Fourth color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'circles',
				]
			]
		);

        // Bubbles
        $objControls->add_control(
			'bab_bubbles_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Bubbles color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'bubbles',
				]
			]
		);
        $objControls->add_control(
			'bab_bubbles_count',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Bubble count', 'bab' ),
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 10,
						'max'  => 50,
						'step' => 1
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 20
                ],
                'condition'  => [
					'bab_background_style' => 'bubbles',
				]
			]
		);
        $objControls->add_control(
			'bab_bubbles_speed',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Bubble speed', 'bab' ),
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 5,
						'step' => 0.2
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 1
                ],
                'condition'  => [
					'bab_background_style' => 'bubbles',
				]
			]
		);

        // Gooey effect
        $objControls->add_control(
			'bab_gooey_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Bubbles color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'gooey',
				]
			]
		);
        $objControls->add_control(
			'bab_gooey_height',
			[
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Height', 'bab' ),
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 90,
						'step' => 1
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 5
                ],
                'condition'  => [
					'bab_background_style' => 'gooey',
				]
			]
		);

        // Floating squares
        $objControls->add_control(
			'bab_floatingsquares_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Squares color', 'bab' ),
                'condition'  => [
					'bab_background_style' => 'floatingsquares',
				]
			]
		);

        $objControls->end_controls_section();
    }

    public function bab_front_after_render($objElement){
		$settings = $objElement->get_settings_for_display();

        $background_style = isset($settings['bab_background_style']) ? $settings['bab_background_style'] : '';
        if( !empty($background_style) ) {
            $file = $this->plugin_path . 'blocks/elementor/bab-'.$background_style.'.php';

            $html = '';
            ob_start();
            if( file_exists($file) ) {
                require $file;
            }
            $html .= ob_get_contents();
            ob_end_clean();

            $el_id = isset($objElement->get_raw_data()['id']) ? $objElement->get_raw_data()['id'] : '';

            if($el_id != '') {
                $this->arr_bab_elementor_output[$el_id] = (string) $html;
            }
        }
    }

    public function bab_print_footer_html(){
        if(empty($this->arr_bab_elementor_output))
            return(true);
        
        foreach($this->arr_bab_elementor_output as $el_id => $output){
            ?>
			<div class="bab-background-overlay" data-forid="<?php echo $el_id; ?>" style="display:none;">
                <?php echo $output; ?>
            </div>
            <script type='text/javascript'>
                jQuery(document).ready(function(){
                    
                    var objBG = jQuery(".bab-background-overlay");
                    
                    if(objBG.length == 0)
                        return(false);
                    
                    objBG.each(function(index, bgElement){
                        var objBgElement = jQuery(bgElement);
                        var targetID = objBgElement.data("forid");
                        var objTarget = jQuery("*[data-id=\""+targetID+"\"]");
                        
                        if(objTarget.length == 0)
                            return(true);

                        objBgElement.detach().prependTo(objTarget).show();
                        babInitBackgrounds( objTarget.get(0).querySelectorAll( '.bab-trigger-el' ) );
                    });
                });
            </script>
            <?php
        }
    }

    public function bab_enqueue_editor_scripts() {
        if ( \Elementor\Plugin::instance()->preview->is_preview_mode() ) {
            wp_enqueue_script('bab-admin-elementor', $this->plugin_url . 'blocks/js/elementor-admin.js', array('jquery'), $this->plugin_version, true);
            wp_localize_script( 'bab-admin-elementor', 'bab_ajax',
                array(
                    'url' => admin_url('admin-ajax.php')
                )
            );
        }
    }

	private function sanitize_array( $var ) {
		if ( is_array( $var ) ) {
            return array_map( array($this, 'sanitize_array'), $var );
        } else {
            return is_scalar( $var ) ? sanitize_text_field( stripslashes($var) ) : stripslashes($var);
        }
	}

    public function bab_get_elementor_block_func() {
        $settings = isset( $_POST['settings'] ) ? (array) $_POST['settings'] : array();
        $settings = $this->sanitize_array( $settings );
        $html = '';

        $background_style = isset($settings['bab_background_style']) ? $settings['bab_background_style'] : '';
        if( !empty($background_style) ) {
            $file = $this->plugin_path . 'blocks/elementor/bab-'.$background_style.'.php';
            ob_start();
            if( file_exists($file) ) {
                require $file;
            }
            $html .= ob_get_contents();
            ob_end_clean();
        }

        echo $html;
        wp_die();
    }
}
    
function wa_bab() {
    return WA_BAB::instance();
}
add_action( 'plugins_loaded', 'wa_bab' );