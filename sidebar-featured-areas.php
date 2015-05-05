<?php
/**
 * The Sidebar containing the footer widget areas.
 *
 * @package Bjorn
 */
?>

<?php if ( is_active_sidebar( 'featured-1' ) || is_active_sidebar( 'featured-2' ) || is_active_sidebar( 'featured-3' ) ) : ?>

	<div id="quaternary" class="featured-page-area" role="complementary">
		<div class="featured-page-wrapper clear">
			<?php if ( is_active_sidebar( 'featured-1' ) ) : ?>
				<div class="featured-page">
					<?php dynamic_sidebar( 'featured-1' ); ?>
				</div><!-- .front-page-widget -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'featured-2' ) ) : ?>
				<div class="featured-page">
					<?php dynamic_sidebar( 'featured-2' ); ?>
				</div><!-- .front-page-widget -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'featured-3' ) ) : ?>
				<div class="featured-page">
					<?php dynamic_sidebar( 'featured-3' ); ?>
				</div><!-- .front-page-widget -->
			<?php endif; ?>
		</div><!-- .front-page-widget-wrapper -->
	</div><!-- #quinary -->

<?php endif; ?>