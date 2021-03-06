<?php
/**
 * eCademy functions and definitions
 * @package eCademy
 */

/**
 * Shorthand contents for theme assets url
 */
define('ECADEMY_VERSION', time());
define('ECADEMY_THEME_URI', get_template_directory_uri());
define('ECADEMY_THEME_DIR', get_template_directory());
define('ECADEMY_IMG',ECADEMY_THEME_URI . '/assets/img');
define('ECADEMY_CSS',ECADEMY_THEME_URI . '/assets/css');
define('ECADEMY_JS',ECADEMY_THEME_URI . '/assets/js');
if( !defined('ECADEMY_FRAMEWORK_VAR') ) define('ECADEMY_FRAMEWORK_VAR', 'ecademy_opt');
 
	
wp_register_script('jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js', false, null);
wp_register_script('jquerymodal', '//cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', false, null);
wp_register_style('jquerystyle', '//cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', false, null);
wp_register_style('jqueryupdate', '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', false, null);


wp_enqueue_script('jquery');
wp_enqueue_script('jquerymodal');
wp_enqueue_style('jquerystyle');
add_action( 'jqueryupdate', 'loadmyjquery' );
 

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if ( ! function_exists( 'ecademy_setup' ) ) :

	function ecademy_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'ecademy', ECADEMY_THEME_DIR. '/languages' );
		$locale		 = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Theme support WooCommerce
		add_theme_support( 'woocommerce' );

		// Add support for LearnPress
		if ( class_exists( 'LearnPress' ) ) {
        	add_filter( 'learn-press/override-templates', function(){ return true; } );
		}

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Add theme support yost seo plugin breadcrumbs
		add_theme_support( 'yoast-seo-breadcrumbs' );

		// eCademy image size
		add_image_size( 'ecademy_default_thumb', 750, 500, true );
		add_image_size( 'ecademy_advisor_thumb_one', 545, 820, true );
		add_image_size( 'ecademy_advisor_thumb_two', 590, 570, true );
		add_image_size( 'ecademy_blog_thumb', 900, 500, true );
		add_image_size( 'ecademy_400x400', 400, 400, true );
		add_image_size( 'ecademy_810x545', 810, 545, true );

		// Switch default core markup for search form, comment form, and comments
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

	}
endif;
add_action( 'after_setup_theme', 'ecademy_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function ecademy_content_width() {
	// This variable is intended to be overruled from themes.
	$GLOBALS['content_width'] = apply_filters( 'ecademy_content_width', 640 );
}
add_action( 'after_setup_theme', 'ecademy_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'ecademy_scripts' ) ) :

	function ecademy_scripts() {
        global $ecademy_opt; 
		$is_cursor      = !empty($ecademy_opt['is_cursor']) ? $ecademy_opt['is_cursor'] : '';
		if( isset( $ecademy_opt['enable_lazyloader'] ) ):
			$is_lazyloader = $ecademy_opt['enable_lazyloader'];
		else:
			$is_lazyloader = true;
		endif;

		wp_enqueue_style( 'ecademy-style', get_stylesheet_uri() );
		wp_style_add_data( 'ecademy-style', 'rtl', 'replace' );

		wp_enqueue_style( 'vendor', 				ECADEMY_CSS . '/vendor.min.css', null, ECADEMY_VERSION );
		// Video CSS
		if( is_singular('lp_course') ):
			wp_enqueue_style( 'video', 				ECADEMY_CSS . '/video.min.css', null, ECADEMY_VERSION );
		endif;

		// WooCommerce CSS
		if ( class_exists( 'WooCommerce' ) ):
			wp_enqueue_style( 'ecademy-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css');
		endif;
		wp_enqueue_style( 'ecademy-main-style', 	ECADEMY_CSS . '/style.css', null, ECADEMY_VERSION );
		wp_enqueue_style( 'ecademy-responsive', 	ECADEMY_CSS . '/responsive.css', null, ECADEMY_VERSION );

		// RTL CSS
		if( ecademy_rtl() == true ):
			wp_enqueue_style( 'ecademy-rtl', get_template_directory_uri() . '/style-rtl.css' );
		endif;

		//SBS CSS
		wp_enqueue_style( 'sbs-css', get_template_directory_uri() . '/assets/css/sbs.css' );
		


		wp_enqueue_script( 'vendor', 		ECADEMY_JS . '/vendor.min.js', array('jquery'), ECADEMY_VERSION );

		// Smartify JS
		if( $is_lazyloader == true ):
			wp_enqueue_script( 'jquery-smartify', ECADEMY_JS . '/jquery.smartify.js', array('jquery'), ECADEMY_VERSION );
			wp_enqueue_script( 'ecademy-smartify', ECADEMY_JS . '/ecademy-smartify.js', array('jquery'), ECADEMY_VERSION );
		endif;

		// Video JS
		if( is_singular('lp_course') ):
			wp_enqueue_style( 'videojs', 			ECADEMY_JS . '/videojs.min.js', null, ECADEMY_VERSION );
		endif;
		wp_enqueue_script( 'jquery-cookie', 		ECADEMY_JS . '/jquery.cookie.min.js', array('jquery'), ECADEMY_VERSION );
        if( $is_cursor == '1' ):
            wp_enqueue_script( 'ecademy-cursor', 		ECADEMY_JS . '/cursor.min.js', array('jquery'), ECADEMY_VERSION );
        endif;
		
		wp_enqueue_script( 'ecademy-main', 			ECADEMY_JS . '/main.js', array('jquery'), ECADEMY_VERSION );
		wp_enqueue_script( 'jquery-rut',get_template_directory_uri().'/assets/js/jquery-rut/jquery.rut.js', array('jquery','ecademy-main'), ECADEMY_VERSION );

		wp_deregister_style( 'wpems-fronted-css' );
		wp_deregister_style( 'wpems-owl-carousel-css' );
		wp_deregister_script( 'wpems-owl-carousel-js' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
endif;
add_action( 'wp_enqueue_scripts', 'ecademy_scripts' );

if ( ! function_exists( 'ecademy_fonts' ) ) {
	function ecademy_fonts() {
		wp_enqueue_style( 'ecademy-fonts', "//fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;0,900;1,600;1,700;1,800;1,900&display=swap", '', '1.0.0', 'screen' );
	}
}
add_action( 'wp_enqueue_scripts', 'ecademy_fonts' );

/**
 * Custom template tags for this theme.
 */
require ECADEMY_THEME_DIR. '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require ECADEMY_THEME_DIR. '/inc/template-functions.php';

/**
 * Acf meta
 */
require ECADEMY_THEME_DIR. '/inc/acf.php';

/**
 * Customizer additions.
 */
require ECADEMY_THEME_DIR. '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require ECADEMY_THEME_DIR. '/inc/jetpack.php';
}

/**
 * Load bootstrap navwalker
 */
require ECADEMY_THEME_DIR. '/inc/bootstrap-navwalker.php';

/**
 * Load theme widgets
 */
require ECADEMY_THEME_DIR. '/inc/widget.php';

/**
 * Custom style
 */
require ECADEMY_THEME_DIR. '/inc/custom-style.php';

/**
 * Social link
 */
require ECADEMY_THEME_DIR. '/inc/social-link.php';

/**
 * Recommended plugin
 */
require ECADEMY_THEME_DIR. '/lib/recommended-plugin.php';

/**
 * Theme Demos
 */
$pcs = trim( get_option( 'ecademy_purchase_code_status' ) );
if ( $pcs == 'valid' ) {
	require ECADEMY_THEME_DIR. '/inc/theme-demos.php';
}

/**
 * Custom functions for LearnPress
 */
if ( class_exists( 'LearnPress' ) ) {
	require ECADEMY_THEME_DIR. '/inc/learnpress.php';
}

// Load WooCommerce compatibility file.
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * eCademy Menus
 */
if ( ! function_exists( 'ecademy_register_menus' ) ) :
	function ecademy_register_menus(){
		register_nav_menus(
			array(
				'primary' 		=> esc_html__('Primary Menu', 'ecademy'),
				'footer-menu' 	=> esc_html__( 'Footer Menu', 'ecademy' ),

			)
		);
	}
endif;
add_action('init', 'ecademy_register_menus');

/**
 * Filter the categories archive widget to add a span around post count
 */
if ( ! function_exists( 'ecademy_cat_count_span' ) ) {
	function ecademy_cat_count_span( $links ) {
		$links = str_replace( '</a> (', '</a><span class="post-count">(', $links );
		$links = str_replace( ')', ')</span>', $links );
		return $links;
	}
}
add_filter( 'wp_list_categories', 'ecademy_cat_count_span' );

/**
 * Filter the archives widget to add a span around post count
 */
if ( ! function_exists( 'ecademy_archive_count_span' ) ) {
	function ecademy_archive_count_span( $links ) {
		$links = str_replace( '</a>&nbsp;(', '</a><span class="post-count">(', $links );
		$links = str_replace( ')', ')</span>', $links );
		return $links;
	}
}
add_filter( 'get_archives_link', 'ecademy_archive_count_span' );

/**
 * Excerpt more text
 */
if ( ! function_exists( 'ecademy_excerpt_more' ) ) :
	function ecademy_excerpt_more( $more ) {
		return ' ';
	}
endif;
add_filter('excerpt_more', 'ecademy_excerpt_more');

/**
 * Remove pages from search result
 */
if ( ! function_exists( 'ecademy_remove_pages_from_search' ) ) :
    function ecademy_remove_pages_from_search() {
		global $ecademy_opt;
		global $wp_post_types;

		if( isset( $ecademy_opt['ecademy_search_page'] ) ):
			if( $ecademy_opt['ecademy_search_page'] != true ):
				$wp_post_types['page']->exclude_from_search = true;
			else:
				$wp_post_types['page']->exclude_from_search = false;
			endif;
		else:
			$wp_post_types['page']->exclude_from_search = false;
		endif;
		if ( post_type_exists( 'events' ) ) {
			// exclude from search results
			$wp_post_types['events']->exclude_from_search = true;
		}
		if ( post_type_exists( 'products' ) ) {
			// exclude from search results
			$wp_post_types['products']->exclude_from_search = true;
		}
	}
endif;
add_action('init', 'ecademy_remove_pages_from_search');

/**
 * If page edited by elementor
 */
if ( ! function_exists( 'ecademy_is_elementor' ) ) :
	function ecademy_is_elementor(){
		if ( function_exists( 'elementor_load_plugin_textdomain' ) ):
			global $post;
			if( $post != '' ):
				return \Elementor\Plugin::$instance->db->is_built_with_elementor($post->ID);
			endif;
		endif;
	}
endif;

/**
 * Classes
 */
require get_template_directory() . '/inc/classes/eCademy_base.php';
require get_template_directory() . '/inc/classes/eCademy_rt.php';
require get_template_directory() . '/inc/classes/eCademy_admin_page.php';
require get_template_directory() . '/inc/admin/dashboard/eCademy_admin_dashboard.php';

/**
 * Admin dashboard style and scripts
 */
add_action( 'admin_enqueue_scripts', function() {
    global $pagenow;
    wp_enqueue_script( 'ecademy-admin', ECADEMY_JS.'/ecademy-admin.js', array('jquery'), '1.0.0', true );
    if ( $pagenow == 'admin.php' ) {
		wp_enqueue_style( 'ecademy-admin-dashboard', ECADEMY_CSS.'/admin-dashboard.min.css' );
    }
});

/**
 * Redirect after theme activation
 */
add_action( 'after_switch_theme', function() {
    if ( isset( $_GET['activated'] ) ) {
		wp_safe_redirect( admin_url('admin.php?page=ecademy') );
		update_option( 'ecademy_purchase_code_status', '', 'yes' );
		update_option( 'ecademy_purchase_code', '', 'yes' );
        exit;
	}
	update_option('notice_dismissed', '0');
});

/**
 * Notice dismiss handle
 */
add_action( 'admin_init', function() {
    if ( isset($_GET['dismissed']) && $_GET['dismissed'] == 1 ) {
        update_option('notice_dismissed', '1');
    }
    if ( isset($_GET['plugin_dismissed']) && $_GET['plugin_dismissed'] == 1 ) {
        update_option('plugin_notice_dismissed', '1');
    }
});

add_action( 'admin_notices', 'ecademy_admin_notice' );

function ecademy_admin_notice() {
	$out = '<div class="notice notice-warning is-dismissible ecademy-plugin-purchase-notice"><p>'.esc_html( 'Note: Please make sure you are installing any one LMS plugin (LearnPress, LearnDash or Tutor LMS) which one you need. After importing demo data you need to register the theme again.' ).'</p></div>';
	if ( get_option('plugin_notice_dismissed') ) {
		return;
	}
	echo wp_kses_post($out);
}

/**
 * Check a plugin activate
 */
function et_plugin_active( $plugin ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( $plugin ) ) {
		return true;
	}
	return false;
}

add_action( 'admin_menu', 'ecademy_remove_theme_settings', 999 );
function ecademy_remove_theme_settings() {
    remove_submenu_page( 'themes.php', 'fw-settings' );
}

/**
 * Inc
 */
include_once get_template_directory() . '/inc/init.php';

/**
 * Correo de Usuario - Soporte
 */
include_once get_template_directory() . '/inc/soporteUsuario.php';


/**
 * vacio el carro al salir del checkout
 */
add_filter( 'woocommerce_add_cart_item_data', 'woo_custom_add_to_cart' );

function woo_custom_add_to_cart( $cart_item_data ) {

    global $woocommerce;
    $woocommerce->cart->empty_cart();

    // Do nothing with the data and return
    return $cart_item_data;
}

//Redireccionar logout
function ps_redirect_after_logout(){
	
	wp_logout_url($_SERVER['REQUEST_URI']);
	wp_redirect( 'https://sbsdigital.cl/usuario/');
	
	exit();
}
add_action( 'wp_logout','ps_redirect_after_logout');

//Codigo de Analitycs
function my_analitycs(){
	?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-X7CX9HSQ5G"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-X7CX9HSQ5G');
	</script>

	<?php
}

add_action('wp_head','my_analitycs',20);


add_shortcode('edit_account', 'display_myaccount_edit_account');
function display_myaccount_edit_account()
{
    return WC_Shortcode_My_Account::edit_account();
}



function my_custom_my_account_menu_items( $items ) {
    $items = array(
        'dashboard'         => __( 'Dashboard', 'woocommerce' ),
        'orders'            => __( 'Pagos', 'woocommerce' ),
      //  'downloads'       => __( 'Downloads', 'woocommerce' ),
     //   'edit-address'    => __( 'Addresses', 'woocommerce' ),
        //'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
        '../usuario-editar/'      => __( 'Editar perfil', 'http://localhost:8888/sbs/public/usuario-editar/' ),
       // 'refunds-returns'      => 'Refunds & Returns', 
        'customer-logout'   => __( 'Salir', 'woocommerce' ), 
    ); 
  
    return $items;
}

add_filter( 'woocommerce_account_menu_items', 'my_custom_my_account_menu_items' );

/*Function de  registros*/
/*Activo AJAX para custom login*/
function loadmyjquery() {
    wp_enqueue_script( 'js', get_theme_file_uri( '/assets/js/formularios.js'), array('jquery') );

    wp_localize_script( 'js', 'ajax_var', array(
        'url'    => admin_url( 'admin-ajax.php' ),
        'nonce'  => wp_create_nonce( 'my-ajax-nonce' ),
        'action' => 'event-list'
    ) );
}
add_action( 'wp_footer', 'loadmyjquery' );



function my_event_list_cb() {
    // Check for nonce security
    $nonce = sanitize_text_field( $_POST['nonce'] );
$usuario =  sanitize_text_field( $_POST['user'] ); 
$password= sanitize_text_field( $_POST['password'] );
	
 if ( ! wp_verify_nonce( $nonce, 'my-ajax-nonce' )) {
        echo 'ok';
 }
		$userdata = get_user_by( 'login', $usuario );
		$clue ="NExT@8y@=azqdBJ";
		$passdb = $userdata->user_pass ;	
		$varmd5 = md5($clue+$password) ;
		$passmd5 =  md5($clue+$passdb);

		if ($varmd5 === $passmd5 ){	
			if ( $userdata ) {
				wp_set_current_user( $userdata->ID, $userdata->data->user_login );
				wp_set_auth_cookie( $userdata->ID );
				echo 'ok';      wp_die();
			} 
			else{
			$creds = array();
			$creds['user_login'] = $usuario;
			$creds['user_password'] = $password;
			$creds['remember'] = true;
			$user = wp_signon( $creds, false );
			echo 'ok';wp_die(); }
}	
		
		else{echo 'error....>'.$passdb.'pass....>'.$password;wp_die();}		
    }
add_action( 'wp_ajax_nopriv_event-list', 'my_event_list_cb' );
add_action( 'wp_ajax_event-list', 'my_event_list_cb' );

function my_event_update() {
$user_id = $_POST["id"] ;
 $name = $_POST["account_first_name"] ;
 $last =  $_POST["account_last_name"] ;
 $display = $_POST["account_display_name"] ;
 $email=  $_POST["account_email"] ;

 $user_data = wp_update_user( array( 'ID' => $user_id, 
'user_email' => $email,
'first_name' => $name,
'last_name' => $last,
'display_name'=> $display) );
if ($user_data){
	echo $user_data;
}
        wp_die();
     
}
add_action( 'wp_ajax_nopriv_update_data', 'my_event_update' );
add_action( 'wp_ajax_update_data', 'my_event_update' );


function my_update_form3() {
	$user_id = $_POST["id"] ;
	$descripcion =$_POST["descripcion"];
	$experiencia =$_POST["experiencia"];
	$estudios =$_POST["estudios"];
	$matific =$_POST["matific"];
	$glifting =$_POST["glifting"];

	$updated = update_user_meta( $user_id, 'experiencia', $experiencia);
	$updated = update_user_meta( $user_id, 'descripcion', $descripcion);
	$updated = update_user_meta( $user_id, 'estudios', $estudios);
	$updated = update_user_meta( $user_id, 'matific', $matific);
	$updated = update_user_meta( $user_id, 'glifting', $glifting);
 
	if(!$updated ){
		$add = add_user_meta( $user_id, 'experiencia', $experiencia);
		$add = add_user_meta( $user_id, 'descripcion', $descripcion);
		$add = add_user_meta( $user_id, 'estudios', $estudios);
		$add = add_user_meta( $user_id, 'matific', $matific);
		$add = add_user_meta( $user_id, 'glifting', $glifting);

		echo  $add  ;  
	 }else{
		 echo $updated;
	 }
			wp_die();
		 
	}
	add_action( 'wp_ajax_nopriv_update_form3', 'my_update_form3' );
	add_action( 'wp_ajax_update_form3', 'my_update_form3' );


	function my_update_form4() {
		$user_id = $_POST["id"] ;
		$field_especializa =$_POST["field_especializa"];
		$field_idioma =$_POST["field_idioma"]; 
		$field_nivel =$_POST["field_nivel"];
		$matific =$_POST["matific"];
		$glifting =$_POST["glifting"]; 
	 echo $_SERVER['POST'];

		
				wp_die();
			 
		}
		add_action( 'wp_ajax_nopriv_update_form4', 'my_update_form3' );
		add_action( 'wp_ajax_update_form4', 'my_update_form3' );

		
function my_update_form5() {
	$user_id = $_POST["id"] ;
	$tarifa =$_POST["tarifa"];
	$total = ($tarifa  + ($tarifa /100*20));

	$updated = update_user_meta( $user_id, 'tarifa', $tarifa);
	$updated = update_user_meta( $user_id, 'tarifapublico', $total);
 if(!$updated ){
	$add = add_user_meta( $user_id, 'tarifa', $tarifa);
	$add = add_user_meta( $user_id, 'tarifapublico', $total);
	echo  $add  ;  
 }else{
	 echo $updated;
 }


			wp_die();
		 
	}
	add_action( 'wp_ajax_nopriv_update_form5', 'my_update_form5' );
	add_action( 'wp_ajax_update_form5', 'my_update_form5' );

