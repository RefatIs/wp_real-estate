<?php 

if ( $args['property'] ) {
    $property = $args['property'];
} else {
	return;
}

$address = get_post_meta($property->ID, 'address', true);
$area = get_post_meta($property->ID, 'area', true);
$living_area = get_post_meta($property->ID, 'living_area', true);
$floor = get_post_meta($property->ID, 'floor', true);
$price = get_post_meta($property->ID, 'price', true);

?>

			
<article class="card">

	<?php get_template_part( 'templates/property', 'carousel', array('id' => $property->ID) ); ?>

	<div class="card-body">

		<a href="<?php echo get_permalink($property->ID) ?>" class="card-text text-dark"><?php echo $property->post_title; ?></a>

		<div class="mt-3">
			<div class="d-flex justify-content-between mb-2">
				<?php echo $address ?>
			</div>
			<div class="d-flex justify-content-between">
				<span class="font-weight-light">Площадь (м²)</span><span><?php echo $area ?></span>
			</div>
			<div class="d-flex justify-content-between">
				<span class="font-weight-light">Жил. площадь (м²)</span><span><?php echo $living_area ?></span>
			</div>
			<div class="d-flex justify-content-between">
				<span class="font-weight-light">Этаж</span><span><?php echo $floor ?></span>
			</div>
			<div class="d-flex justify-content-between">
				<span></span><span class="font-weight-bold"><?php echo $price ?>₽</span>
			</div>
		</div>

	</div>

</article>