<?php 

if ( $args['id'] ) {
    $p_id = $args['id'];
} else {
	return;
}

$gallery = acf_photo_gallery('gallery', $p_id);

?>

<div id="carouselProperty<?php echo $p_id; ?>" class="carousel slide" data-ride="carousel" data-interval="false">
	<ol class="carousel-indicators">
		<?php foreach ($gallery as $key => $image) : ?>
			<li data-target="#carouselProperty<?php echo $p_id; ?>" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0) ? 'active' : ''; ?>"></li>
		<?php endforeach; ?>
	</ol>
	<div class="carousel-inner">
		<?php foreach ($gallery as $key => $image) : ?>
			<div class="carousel-item <?php echo ($key == 0) ? 'active' : ''; ?>">
				<img src="<?php echo $image['full_image_url'] ?>" class="d-block w-100" alt="">
			</div>
		<?php endforeach; ?>
	</div>
	<button class="carousel-control-prev" type="button" data-target="#carouselProperty<?php echo $p_id; ?>" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</button>
	<button class="carousel-control-next" type="button" data-target="#carouselProperty<?php echo $p_id; ?>" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</button>
</div>