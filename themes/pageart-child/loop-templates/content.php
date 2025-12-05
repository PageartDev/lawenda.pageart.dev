<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>

<div class="col-sm-6 col-md-4">
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

        <div class="entry-image">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <?php echo get_the_post_thumbnail($post->ID, 'large'); ?>
            </a>
        </div>

        <div class="entry-header">
            <?php if ('post' === get_post_type()) : ?>
                <div class="entry-header__meta">
                    <div class="entry-meta">
                        <?php understrap_posted_on(); ?>
                    </div><!-- .entry-meta -->
                </div>
            <?php endif; ?>


            <div class="entry-header__title">
                <?php
                the_title(
                        sprintf('<p class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
                        '</a></h2>'
                );
                ?>
            </div>

            <div class="entry-readmore mt-2">
                <a class="btn-link" href="<?php echo esc_url(get_permalink()); ?>">
                    Czytaj więcej
                </a>
            </div>


        </div>

    </article><!-- #post-<?php the_ID(); ?> -->
</div>
