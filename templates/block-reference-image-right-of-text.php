<?php
/**
 * Template Name: Image right of Text
  *
 * Description
 *
 */
$limit = 55;
?>

<?php if( !is_admin() ): 
$limit = 14;    
    ?>
<div class="wp-block-teaser-reference-block">
<?php endif; ?>

    <div class="words">
        <h2><?php the_title() ?></h2>
        <p><?php echo reference_block_get_the_excerpt( get_the_ID(), $limit ) ?></p>
        <small><a href="<?php the_permalink() ?>">Read More</a></small>
    </div>
    <img src="<?php echo reference_block_get_post_image_url( get_the_ID(), $limit ) ?>">
<?php if( !is_admin() ): ?>
</div>
<?php endif; ?>