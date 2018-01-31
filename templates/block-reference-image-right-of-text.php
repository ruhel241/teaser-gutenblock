<?php
/**
 * Template Name: Image right of Text
  *
 * Description
 *
 */
?>

<?php if( !is_admin() ): ?>
<div class="wp-block-reference-block">
<?php endif; ?>

    <div class="words">
        <h2><?php the_title() ?></h2>
        <small><a href="<?php the_permalink() ?>">Read More</a></small>
    </div>
    <img src="<?php echo reference_block_get_post_image_url( get_the_ID() ) ?>">
<?php if( !is_admin() ): ?>
</div>
<?php endif; ?>