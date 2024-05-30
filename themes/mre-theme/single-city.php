<?php


// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">

				<div class="container">

					<section class="card mb-3">

						<div class="row g-0">
						
							<div class="col-md-4">
						
								<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" class="img-fluid rounded-start" alt="">
						
							</div>
						
							<div class="col-md-8">
						
								<div class="card-body">
						
									<h1 class="card-title"><?php echo get_the_title(); ?></h1>
						
									<p class=""><?php echo get_the_content(); ?></p>
						
								</div>
						
							</div>
						
						</div>
					
					</section>

					<section class="my-5">

						<h2 class="mb-4">Объекты недвижимости</h2>

						<div class="">
						
							<?php $properties = get_properties(get_the_ID()); ?>

							<?php if ($properties) : ?>

								<div class="properties-grid row">
									
									<?php foreach ($properties as $property) : ?>

										<div class="col-md-4 col-sm-6 col-xs-12 mb-4">

											<?php get_template_part( 'templates/property', 'teaser', array('property' => $property) ); ?>

										</div>

									<?php endforeach; ?>

								</div>

							<?php else : ?>

								<div class="">В данный момент нет объявлений о продаже недвижимости.</div>

							<?php endif; ?>
								
						</div>

					</section>

				</div>

			</main>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
