<?php

function mre_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('mre-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), '1.0');

	wp_enqueue_script( 'mre-script', get_stylesheet_directory_uri() . '/js/script.js', array(), '1.0', true );
	wp_localize_script( 'mre-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'mre_enqueue_styles');


function get_cities() {
	$cities = get_posts([
	  	'post_type' => 'city',
	  	'post_status' => 'publish',
	  	'numberposts' => -1,
	    'order' => 'ASC',
	    'orderby' => 'ID'
	]);

	return $cities;
}

function get_properties($city_id = false) {
	$args = array(
        'post_type' => 'property',
	  	'post_status' => 'publish',
	  	'numberposts' => -1,
    );

	if ($city_id) {
		$args['meta_query'] = array(
            array(
                'key' => 'property_city',
                'value' => $city_id,
                'compare' => '='
            )
        );
	}

	$properties = get_posts($args);

	return $properties;
}

function get_property_types() {
	$property_categories = get_terms(array(
	    'taxonomy' => 'property_category',
	    'hide_empty' => false,
	    'order' => 'ASC',
	    'orderby' => 'ID'
	));

	return $property_categories;
}


function property_upload_form() {
	$cities = get_cities();
	$types = get_property_types();

    ob_start();
    ?>
    <form id="property-upload-form" method="post" enctype="multipart/form-data">
    	<div class="row">
    		<div class="col-12">
    			<div class="form-group">
		    		<label for="prop_title">Название</label>
		    		<input type="text" class="form-control" name="prop_title" required>
		    	</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-12">
    			<div class="form-group">
		    		<label for="prop_address">Адрес</label>
		    		<input type="text" class="form-control" name="prop_address" required>
		    	</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-6 col-sm-12">
    			<div class="form-group">
		    		<label for="prop_city">Город</label>
		    		<select class="form-control" name="prop_city" required>
		    			<?php foreach ($cities as $city) : ?>
		    				<option value="<?php echo $city->ID; ?>"><?php echo $city->post_title; ?></option>
		    			<?php endforeach; ?>
		    		</select>
		    	</div>
    		</div>
    		<div class="col-md-6 col-sm-12">
    			<div class="form-group">
		    		<label for="prop_type">Тип</label>
		    		<select class="form-control" name="prop_type">
		    			<?php foreach ($types as $type) : ?>
		    				<option value="<?php echo $type->name; ?>"><?php echo $type->name; ?></option>
		    			<?php endforeach; ?>
		    		</select>
		    		</select>
		    	</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-6 col-sm-12">
    			<div class="form-group">
		    		<label for="prop_area">Площадь</label>
		    		<input type="text" class="form-control" name="prop_area" >
		    	</div>
    		</div>
    		<div class="col-md-6 col-sm-12">
    			<div class="form-group">
		    		<label for="prop_living_area">Жил. площадь</label>
		    		<input type="text" class="form-control" name="prop_living_area" >
		    	</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-6 col-sm-12">
    			<div class="form-group">
		    		<label for="prop_floor">Этаж</label>
		    		<input type="text" class="form-control" name="prop_floor" >
		    	</div>
    		</div>
    		<div class="col-md-6 col-sm-12">
    			<div class="form-group">
		    		<label for="prop_price">Стоимость</label>
		    		<input type="text" class="form-control" name="prop_price" >
		    	</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-12">
    			<div class="form-group">
		    		<label for="prop_price">Фотографии</label>
		    		<input type="file" class="form-control-file" name="prop_images[]" accept="image/png, image/jpeg, image/webp" multiple required />
		    	</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-12">
    			<div class="form-group">
		    		<label for="prop_text">Описание</label>
		    		<textarea class="form-control" name="prop_text" rows="3"></textarea>
		    	</div>
    		</div>
    	</div>
    	<div class="row mt-3">
    		<div class="col-12">
    			<div class="form-group">
    				<input type="submit" class="btn btn-primary" name="submit_property" value="Отправить" />
    			</div>
    		</div>
    	</div>
    	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('form_upload_nonce'); ?>">
    </form>
    <div id="upload-results"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('property-upload-form', 'property_upload_form');


function upload_property() {
    //check_ajax_referer('form_upload_nonce', 'nonce');
    $title = sanitize_text_field($_POST['prop_title']);
    $address = sanitize_text_field($_POST['prop_address']);
    $area = sanitize_text_field($_POST['prop_area']);
    $living_area = sanitize_text_field($_POST['prop_living_area']);
    $floor = sanitize_text_field($_POST['prop_floor']);
    $price = sanitize_text_field($_POST['prop_price']);
    $text = sanitize_text_field($_POST['prop_text']);
    $city = $_POST['prop_city'];
    $type = $_POST['prop_type'];
    $images = ($_FILES['prop_images']) ? $_FILES['prop_images'] : array();
    $gallery = handle_image_upload($images);

    $post_data = array(
        'post_title'    => $title,
        'post_content'  => $text,
        'post_status'   => 'publish',
        'post_type'     => 'property'
    );

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        wp_send_json_error('Error');
        return;
    }

    wp_set_object_terms($post_id, $type, 'property_category');

    update_field('address', $address, $post_id);
    update_field('area', $area, $post_id);
    update_field('living_area', $living_area, $post_id);
    update_field('floor', $floor, $post_id);
    update_field('price', $price, $post_id);
    update_field('gallery', $gallery, $post_id);
    update_field('property_city', $city, $post_id);
    
    wp_send_json('Success');
}
add_action('wp_ajax_upload_property', 'upload_property');
add_action('wp_ajax_nopriv_upload_property', 'upload_property');

function handle_image_upload($uploaded_files) {
	$attachment_ids = array();
    foreach ($uploaded_files['name'] as $key => $value) {
        if ($uploaded_files['name'][$key]) {
            $file = array(
                'name' => $uploaded_files['name'][$key],
                'type' => $uploaded_files['type'][$key],
                'tmp_name' => $uploaded_files['tmp_name'][$key],
                'error' => $uploaded_files['error'][$key],
                'size' => $uploaded_files['size'][$key]
            );

            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($file, $upload_overrides);

            if ($movefile && !isset($movefile['error'])) {
		        $filename = $movefile['file'];
		        $attachment = array(
		            'post_mime_type' => $movefile['type'],
		            'post_title' => sanitize_file_name(basename($filename)),
		            'post_content' => '',
		            'post_status' => 'inherit'
		        );
		        $attach_id = wp_insert_attachment($attachment, $filename);
		        require_once(ABSPATH . 'wp-admin/includes/image.php');
		        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
		        wp_update_attachment_metadata($attach_id, $attach_data);

		        $attachment_ids[] = $attach_id;
		    }
        }
    }

    return implode(',', $attachment_ids);
}