<?php

/**
 * 
 * Plugin Name: Плагин "Недвижимость"
 * Description: Добавляет новые типы постов и другие функции
 * Version:     1.0.0
 * Author:      RefatIs
 * Author URI:  https://kwork.ru/user/RefatIs
 * 
 */



add_action( 'init', 'mre_add_post_types' );
function mre_add_post_types() {
	register_post_type( 'property',
		array(
			'labels' => array(
				'name' => __( 'Недвижимость' ),
				'singular_name' => __( 'Недвижимость' ),
				'all_items' => __( 'Все объекты недвижимости'),
				'add_new' => 'Добавить объект',
				'add_new_item' => 'Добавление объекта',
				'edit_item' => 'Редактирование объекта',
				'new_item' => 'Новый объект',
				'view_item' => 'Смотреть объект',
			),
			'public' => true,
			'has_archive' => true,
			'exclude_from_search' => false,
			'rewrite' => array('slug' => 'property'),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'menu_position' => 6,
			'menu_icon'           => 'dashicons-building',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'show_in_rest'		  => true,
			'register_meta_box_cb'=> 'property_post_type_metaboxes'
		)
	);
	register_post_type( 'city',
		array(
			'labels' => array(
				'name' => __( 'Города' ),
				'singular_name' => __( 'Город' ),
				'all_items' => __( 'Все города')
			),
			'public' => true,
			'has_archive' => true,
			'exclude_from_search' => false,
			'rewrite' => array('slug' => 'city'),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'menu_position' => 6,
			'menu_icon'           => 'dashicons-location',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'show_in_rest'		  => true,
		)
	);
	register_taxonomy('property_category', 'property', array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'                        => _x( 'Тип недвижимости', 'taxonomy general name' ),
			'singular_name'               => _x( 'Тип недвижимости', 'taxonomy singular name' ),
			'menu_name'                   => __( 'Типы недвижимости' ),
		),
		'show_ui'       => true,
		'query_var'     => true,
		'show_in_rest'  => true,
		'show_admin_column' => true,
		'default_term'	=> array('name' => 'Частный дом'),
	));

	$terms = array('Квартира', 'Офис', 'Гараж');
    foreach ($terms as $term_name) {
        if (!term_exists($term_name, 'property_category')) {
            wp_insert_term(
                $term_name,
                'property_category',
            );
        }
    }
}

function property_post_type_metaboxes() {
  add_meta_box( 'property_details_metabox', 'Детали', 'property_details_metabox_display', null, 'normal', 'high' );
}

function property_details_metabox_display() {
	global $post;
	$post_id = $post->ID; 
	$selected_city = get_post_meta($post_id, 'property_city', true);

	$all_cities = get_cities_list(); ?>

	<div class="property-details-field">
		<p>Город</p>
		<select class="city-select" name="property_city" required>
			<option value="0"></option>
			<?php foreach ($all_cities as $i => $city) : ?>
				<option value="<?php echo $i; ?>" <?php if ($i == $selected_city) echo 'selected'; ?>><?php echo $city; ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<?php 
}

add_action('save_post', 'mre_save_custom_posts' );
function mre_save_custom_posts( $post_id ) {
	global $pagenow;

	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);

	if ( $is_autosave || $is_revision ) {
		return;
	}

	$post = get_post($post_id);

	if ( $post->post_type == 'property' ) {

		if ( isset($_POST['property_city']) ) {
			update_post_meta( $post_id, 'property_city', $_POST['property_city'] );
		}
	}
}

function get_cities_list() {
	$posts = get_posts([
	  	'post_type' => 'city',
	  	'post_status' => 'publish',
	  	'numberposts' => -1,
	  	'orderby' => 'title',
    	'order'   => 'ASC',
	]);

	$cities = array();
	foreach ($posts as $post) {
		$cities[$post->ID] = $post->post_title;
	}

	return $cities;
}
