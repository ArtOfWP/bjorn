<?php
/**
 * @package Bjorn
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( '' != get_the_post_thumbnail() ) : ?>
        <div class="portfolio-thumbnail">
            <?php the_post_thumbnail( 'bjorn-portfolio-featured-image' ); ?>
        </div><!-- .portfolio-thumbnail -->
    <?php endif; ?>

    <header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta">
			<?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta">', _x(', ', 'Used between list items, there is a space after the comma.', 'bjorn' ), '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_term_list( $post->ID, 'jetpack-portfolio-tag', '', __( ', ', 'bjorn' ) );
        if ( $tags_list ) :
            ?>
            <span class="tags-links"><?php printf( __( 'Tagged %1$s', 'bjorn' ), $tags_list ); ?></span>
        <?php endif; ?>

        <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
            <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'bjorn' ), __( '1 Comment', 'bjorn' ), __( '% Comments', 'bjorn' ) ); ?></span>
        <?php endif; ?>

        <?php edit_post_link( __( 'Edit', 'bjorn' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post-## -->
