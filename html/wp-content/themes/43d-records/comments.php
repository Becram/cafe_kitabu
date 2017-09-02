<?php
/**
 * User: sunouchi
 * Date: 2015/11/09
 * Time: 18:08
 *
 * @package 43d-records
 */

if (post_password_required()) {
  return;
}
?>

<div id="comments" class="comments-area">

  <?php if (have_comments()) : ?>
    <h3 id="comments">
      <?php
      printf(_nx('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', '43d-records'),
        number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>');
      ?>
    </h3>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav id="comment-nav-above" class="comment-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php _e('Comment navigation', '43d-records'); ?></h1>

        <p class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', '43d-records')); ?></p>

        <p class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', '43d-records')); ?></p>
      </nav><!-- #comment-nav-above -->
    <?php endif; // check for comment navigation ?>

    <ol class="commentlist">
      <?php
      wp_list_comments(array(
        'style' => 'ol',
        'short_ping' => true,
        'avatar_size' => 56,
      ));
      ?>
    </ol><!-- .comment-list -->

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav id="comment-nav-below" class="comment-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php _e('Comment navigation', '43d-records'); ?></h1>

        <p class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', '43d-records')); ?></p>
        <p class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', '43d-records')); ?></p>
      </nav><!-- #comment-nav-below -->
    <?php endif; // check for comment navigation ?>

  <?php endif; // have_comments() ?>

  <?php
  // If comments are closed and there are comments, let's leave a little note, shall we?
  if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
    ?>
    <p class="no-comments"><?php _e('Comments are closed.', '43d-records'); ?></p>
  <?php endif; ?>

  <?php comment_form(); ?>

</div><!-- .comments-area -->
