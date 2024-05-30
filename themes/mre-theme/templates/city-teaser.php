<?php

if ( $args['city'] ) {
    $city = $args['city'];
} else {
	return;
}

?>


<article class="card">

	<div class="card-image">

		<a href="<?php echo get_permalink($city->ID) ?>">

			<img src="<?php echo get_the_post_thumbnail_url($city->ID, 'full'); ?>" class="card-img-top" alt="">

		</a>

	</div>

	<div class="card-body">

		<a href="<?php echo get_permalink($city->ID) ?>" class="card-text text-dark"><?php echo $city->post_title; ?></a>

	</div>

</article>