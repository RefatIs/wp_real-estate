<?php
/**
 * The template for displaying all single posts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );

$id = get_the_ID();

$address = get_post_meta($id, 'address', true);
$area = get_post_meta($id, 'area', true);
$living_area = get_post_meta($id, 'living_area', true);
$floor = get_post_meta($id, 'floor', true);
$price = get_post_meta($id, 'price', true);

?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">

				<div class="container">

					<section class="card mb-3">

						<div class="row g-0">
						
							<div class="col-md-6">
						
								<?php get_template_part( 'templates/property', 'carousel', array('id' => $id) ); ?>
						
							</div>
						
							<div class="col-md-6">
						
								<div class="card-body">
						
									<h2 class="card-title"><?php echo get_the_title(); ?></h2>
						
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
						
							</div>
						
						</div>
					
					</section>

					<section class="my-5">
						
						<h2 class="mb-4">Описание</h2>

						<p class=""><?php echo get_the_content(); ?></p>

					</section>

				</div>

			</main>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
