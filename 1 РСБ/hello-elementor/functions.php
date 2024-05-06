<?php
// Не работал редирект на https(Испарвлено)
// update_option( 'siteurl', 'http://z919910j.beget.tech' );
// update_option( 'home', 'http://z919910j.beget.tech' );
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.8.1' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
*/

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
*/
function hello_register_customizer_functions() {
	if ( is_customize_preview() ) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_register_customizer_functions' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		$post = get_queried_object();

		if ( is_singular() && ! empty( $post->post_excerpt ) ) {
			echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
		}
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

/**
 * Override loop template and show quantities next to add to cart buttons
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );

// Дополнительные кнопки на страницу товара "Добавить в корзину", "+-"
function quantity_inputs_for_woocommerce_loop_add_to_cart_link($html, $product) {
    global $product;
    
    if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
		$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';        
        $html .= '
        <div class="quantity">
			<button class="quantity__minus" type="button">-</button>
			<label class="screen-reader-text" for="quantity_' . $product->get_id() . '">' . esc_html( $product->get_title() ) . '</label>
			<input type="number" id="quantity_' . $product->get_id() . '" class="input-text qty text" name="quantity" value="1" aria-label="Количество товара" size="4" min="1" max="10" step="1" placeholder="" inputmode="numeric" autocomplete="off">
			<button class="quantity__plus" type="button">+</button>
        </div>';
		$html .= '<button type="submit" class="button alt">' . esc_html( $product->add_to_cart_text() ) . '</button>';        
        $html .= '</form>';
    }
	return $html;
}

//
// function woocommerce_output_product_data_tabs() {
 
// 	// не забудьте про этот фильтр-хук, при помощи него вкладки и добавляются
// 	$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
 
// 	if ( empty( $product_tabs ) ) {
// 		return;
// 	}
 
// 	echo '<div class="woocommerce-tabs wc-tabs-wrapper">';
 
// 	// цикл для каждой вкладки
// 	foreach ( $product_tabs as $key => $product_tab ) {
 
// 		echo '<div id="tab-tab-additional_information' . esc_attr( $key ) . '">';
 
// 		// callback – функция для вывода содержимого вкладки
// 		if ( isset( $product_tab[ 'callback' ] ) ) {
// 			call_user_func( $product_tab[ 'callback' ], $key, $product_tab );
// 		}
 
// 		echo '</div>';
// 	}
// 	echo '</div>';
 
// }

// Дополнительные кнопки на страницу товара "Купить","Добавить в корзину", "+-"
function add_custom_button() {
    global $product;
    
    if ( $product->is_in_stock() ) {
        echo '
        <form class="cart cart-product" action="' . esc_url( $product->add_to_cart_url() ) . '" method="post" enctype="multipart/form-data">	
            <div class="quantity">
				<button class="quantity__minus" type="button">-</button>
                <label class="screen-reader-text" for="quantity_' . $product->get_id() . '">' . esc_html( $product->get_title() ) . '</label>
                <input type="number" id="quantity_' . $product->get_id() . '" class="input-text qty text" name="quantity" value="1" aria-label="Количество товара" size="4" min="1" max="10" step="1" placeholder="" inputmode="numeric" autocomplete="off">
				<button class="quantity__plus" type="button">+</button>
            </div>        
			<button type="submit" name="add-to-cart" value="' . $product->get_id() . '" class="single_add_to_cart_button buy button alt">Купить</button>
            <button type="submit" name="add-to-cart" value="' . $product->get_id() . '" class="single_add_to_cart_button button alt">Добавить в корзину</button>		
        </form> ';	
		// Затычка временная
		echo '
		<table class="woocommerce-product-attributes shop_attributes">
			<th class="woocommerce-product-attributes-item__label">Бренд</th>
			<td class="woocommerce-product-attributes-item__value"><p>Tantos</p>
			
		</tr>
			<th class="woocommerce-product-attributes-item__label">Функционал</th>
			<td class="woocommerce-product-attributes-item__value"><p>Вызывная видеопанель</p>
		</td>
				</tr>
				<th class="woocommerce-product-attributes-item__label">Единица измерения</th>
				<td class="woocommerce-product-attributes-item__value">шт</td>
		</td>
				</tr>
				<th class="woocommerce-product-attributes-item__label">Вес</th>
				<td class="woocommerce-product-attributes-item__value">0,420 кг</td>
		</td>
		</tr>
				<th class="woocommerce-product-attributes-item__label">Объём</th>
				<td class="woocommerce-product-attributes-item__value">0,00132 м3</td>
		</td>
			</tbody></table>
		';
    }
}  

// Подключение скриптов. 
function my_theme_scripts () {
	//Переназначения стрелок у инпут намбер.
	wp_enqueue_script('plus-minus', get_template_directory_uri(). '/assets/js/plus-minus.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script( 'plus-minus');
	wp_enqueue_script('popup-link', get_template_directory_uri(). '/assets/js/popup-link.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script( 'popup-link');
	wp_enqueue_script('show-filter', get_template_directory_uri(). '/assets/js/show-filter.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script( 'show-filter');
	wp_enqueue_script( 'custom-script', get_template_directory_uri(). '/assets/js/custom-script.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'custom-script');
}

//Открытие попапов
function open_popup_profile() {
	// Подключение скрипта
	wp_enqueue_script( 'custom-script', get_template_directory_uri(). '/assets/js/custom-script.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'custom-script');
  
	// Передача значения is_user_logged_in в скрипт JavaScript
	wp_localize_script( 'custom-script', 'userLoggedIn', array(
	  'loggedIn' => is_user_logged_in(),
	));
  }

add_action( 'wp_enqueue_scripts', 'open_popup_profile');

//Вызов функции open_popup_profile
open_popup_profile();

// Меняем стандартные название вкладок на свои на странице товара
add_filter( 'woocommerce_product_description_tab_title', 'change_product_description_tab_title', 10, 1 );
function change_product_description_tab_title( $title ) {
    return 'Описание товара';
}

add_filter( 'woocommerce_product_additional_information_tab_title', 'change_product_additional_information_tab_title', 10, 1 );
function change_product_additional_information_tab_title( $title ) {
    return 'Характеристики';
}

// Изменяем символ в breadcrump
function custom_change_breadcrumb_separator($defaults) {
    $defaults['delimiter'] = ' — '; // Замените '»' на символ, который вы хотите использовать
    return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'custom_change_breadcrumb_separator');

//Сниппет автомат. обновления товаров в корзине
function cart_update_qty_script() {
    if (is_cart()) :
    ?>
    <script>
        jQuery('div.woocommerce').on('change', '.qty', function(){
            jQuery("[name='update_cart']").trigger("click"); 
        });
    </script>
    <?php
    endif;
}

add_action( 'wp_footer', 'cart_update_qty_script' );

// Добавление id страницы в админке для удобства
function true_id($args) {
	$args['post_page_id'] = 'ID';
	return $args;
}
add_filter('manage_pages_columns', 'true_id', 5);
add_filter('manage_posts_columns', 'true_id', 5);

function true_custom($column, $id){
	if($column === 'post_page_id') {
		echo $id;
	}
} 
add_action('manage_pages_custom_column', 'true_custom', 5, 2);
add_action('manage_posts_custom_column', 'true_custom', 5, 2);

// Убираем лишнюю хлебную крошку "Главная
add_filter('woocommerce_get_breadcrumb', 'remove_breadcrumb_home');

function remove_breadcrumb_home( $breadcrumb )
{
    array_shift($breadcrumb);
    return $breadcrumb;
}

//Шорткод для вывода рекомендуемых 
function custom_woocommerce_after_single_product() {
    // Prevent recursive loop
    if (did_action('woocommerce_after_single_product')) {
        return;
    }

    ob_start();

    // Execute the action hook
    do_action( 'woocommerce_after_single_product' );

    // Get the output and clean the output buffer
    $output = ob_get_clean();

    return $output;
}
add_shortcode( 'woocommerce_summary', 'custom_woocommerce_after_single_product' );

//2 Меню для авторизованных и неавторизованных посетителей
// function my_wp_nav_menu_args( $args = '' ) {
// 	if( is_user_logged_in() ) { 
// 		$args['menu'] = 'logged-in';
// 	} else { 
// 		$args['menu'] = 'logged-out';
// 	} 
// 		return $args;
// }

// add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );




 

   





	
