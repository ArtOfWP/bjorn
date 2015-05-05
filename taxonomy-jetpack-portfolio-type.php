<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bjorn
 */

get_header(); ?>
<div class="hero <?php echo bjorn_additional_class(); ?>">
    <?php if ( have_posts() ) : ?>

        <div class="hero-wrapper">
            <h1 class="page-title">
                <?php $o=get_queried_object(); esc_html_e($o->name) ?>
            </h1>
            <?php
            // Show an optional term description.
            $term_description = term_description();
            if ( ! empty( $term_description ) ) :
                printf( '<div class="taxonomy-description">%s</div>', $term_description );
            endif;
            ?>
        </div>

    <?php else : ?>

        <div class="title-wrapper">
            <h1 class="page-title"><?php _e( 'Nothing Found', 'edin' ); ?></h1>
        </div>

    <?php endif; ?>
</div><!-- .hero -->

<div class="content-wrapper clear">

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php if ( have_posts() ) : ?>

                <div class="portfolio-wrapper">

                    <?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'content', 'portfolio' ); ?>

                    <?php endwhile; ?>

                </div><!-- .portfolio-wrapper -->

            <?php else : ?>

                <?php get_template_part( 'content', 'none' ); ?>

            <?php endif; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
