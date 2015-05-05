<?php
/**
 * Template Name: Front Page
 *
 * @package Edin
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'hero' ); ?>

	<?php endwhile; ?>

	<?php rewind_posts(); ?>

<?php bjorn_featured_areas(); ?>
<?php get_sidebar( 'front-page' ); ?>
<?php get_footer(); ?>