<?php

/**
 * template name: Главная
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">

				<div class="container">

					<section class="my-5">
						
						<h2 class="mb-4">Города</h2>

						<div class="">

							<?php $cities = get_cities(); ?>

							<div class="cities-grid row">
								
								<?php foreach ($cities as $city) : ?>

									<div class="col-md-4 col-sm-6 col-xs-12 mb-4">
										
										<?php get_template_part( 'templates/city', 'teaser', array('city' => $city) ); ?>

									</div>

								<?php endforeach; ?>

							</div>
							
						</div>

					</section>

					<section class="my-5">
						
						<h2 class="mb-4">Недвижимость</h2>

						<div class="">
						
							<?php $properties = get_properties(); ?>

							<div class="properties-grid row">
								
								<?php foreach ($properties as $property) : ?>

									<div class="col-md-4 col-sm-6 col-xs-12 mb-4">

										<?php get_template_part( 'templates/property', 'teaser', array('property' => $property) ); ?>

									</div>

								<?php endforeach; ?>

							</div>
								
						</div>

					</section>

					<section class="my-5">
						
						<h2 class="mb-4">Разместить объявление</h2>

						<div class="bg-light p-4"><?php echo do_shortcode('[property-upload-form]'); ?></div>

					</section>

				</div>

			</main>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
