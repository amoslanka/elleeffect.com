<?php
/*
Template Name: Quick Post
Description: Publish posts straight from a page on your site.  No need to go to your WordPress dashboard.  This is a Prologue/Twitter-style post system.
Note: This template is under active development and may change drastically in the future.
@reference http://prologuetheme.org
*/

if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'post') :

	if(!is_user_logged_in())
		auth_redirect();

	if(!current_user_can('publish_posts')) :
		wp_redirect($_SERVER['REQUEST_URI']);
		exit;
	endif;

	check_admin_referer('new-post');

	if(!$_POST['post-title']) :

		$error = __('You must enter a post title.','hybrid');

	elseif(!$_POST['post-content']) :

		$error = __('You must write something.','hybrid');

	else :

		$published = wp_insert_post(array(
			'post_author' => $current_user->user_id,
			'post_title' => strip_tags($_POST['post-title']),
			'post_content' => $_POST['post-content'],
			'tags_input' => $_POST['tags'],
			'post_status' => 'publish',
			'post_type' => 'post',
		));

	endif;

endif;

get_header();

if(current_user_can('publish_posts')) : ?>

	<div class="post-box">

		<?php if($error) : ?>
			<p class="error">
				<?php echo $error; ?>
			</p>
		<?php endif; ?>

		<form id="new-post" method="post" action="<?php the_permalink(); ?>">
			<p class="form-title">
				<label for="post-title"><?php _e('Title','hybrid'); ?></label>
				<input type="text" class="text-input" name="post-title" id="post-title" <?php if($_POST['post-title'] && !$published) echo 'value="' . stripslashes(htmlentities($_POST['post-title'], ENT_QUOTES)) . '"'; ?> />
			</p>

			<p class="form-textarea">
				<label for="post-content"><?php _e('Write','hybrid'); ?></label>
				<textarea name="post-content" id="post-content" rows="3" cols="50"><?php if($_POST['post-content'] && !$published) echo stripslashes(htmlentities($_POST['post-content'], ENT_QUOTES)); ?></textarea>
			</p>

			<p class="form-tags">
				<label for="tags"><?php _e('Tags','hybrid'); ?></label>
				<input type="text" class="text-input" name="tags" id="tags" <?php if($_POST['tags'] && !$published) echo 'value="' . stripslashes(htmlentities($_POST['tags'], ENT_QUOTES)) . '"'; ?> />
			</p>

			<p class="form-submit">
				<input class="submit button" name="submit" type="submit" id="submit" value="<?php _e('Publish','hybrid'); ?>" />
				<input class="reset button" name="reset" type="reset" id="reset" value="<?php _e('Reset','hybrid'); ?>" />
			</p>

			<div class="form-hidden">
				<input type="hidden" name="action" value="post" />
				<?php wp_nonce_field('new-post'); ?>
			</div>
		</form>
	</div>

<?php else : ?>

	<p class="warning">
		<?php printf(__('You must be <a href="%1$s" title="Log in">logged in</a> with appropriate user capabilities to publish posts.','hybrid'), hybrid_template_in_use('log-in.php')); ?>
	</p>

<?php endif; ?>

<?php
	$posts_wanted = get_option('posts_per_page');
	$wp_query = new WP_Query();
	$wp_query->query("posts_per_page=$posts_wanted&paged=$paged");
?>

<?php if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h2 class="post-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h2>'); ?>

		<p class="byline">
			<span class="text"><?php _e('By','hybrid'); ?></span> 
			<span class="author vcard"><?php the_author_posts_link(); ?></span> <span class="text"><?php _e('on','hybrid'); ?></span> 
			<abbr class="published time date" title="<?php the_time(__('F jS, Y, g:i a (P - e)','hybrid')); ?>"><?php the_time(__('F j, Y','hybrid')); ?></abbr> 
			<?php edit_post_link(__('Edit','hybrid'), ' <span class="separator">|</span> <span class="edit">', '</span> '); ?>
		</p>

		<div class="entry entry-content">
			<?php the_content(__('Continue reading','hybrid') . ' ' . the_title('"', '"', false)); ?>
			<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>
		</div>

		<p class="post-meta-data">
			<span class="categories"><span class="text"><?php _e('Posted in','hybrid'); ?></span> <?php the_category(', ') ?></span> 
			<?php the_tags('<span class="tags"> <span class="separator">|</span> <span class="text">' . __('Tagged','hybrid') . '</span> ', ', ', '</span>'); ?> 
			<?php if(comments_open()) : ?><span class="separator">|</span><?php endif; ?> <?php comments_popup_link(__('Leave a comment','hybrid'), __('1 Comment','hybrid'), __('% Comments','hybrid'), 'comments-link', false); ?> 
		</p>

	</div>

	<?php endwhile; ?>

	<?php hybrid_after_page(); // After page hook ?>

<?php else: ?>

	<p clas="no-data"><?php _e('Sorry, no page matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>