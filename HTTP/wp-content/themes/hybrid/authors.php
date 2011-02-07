<?php
/*
Template Name: Authors
Description: A page template for listing the authors of your site that have written a post.
*/
?>

<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">

			<?php the_content(); ?>

			<?php $author_ids = hybrid_get_authors('order_by=display_name'); ?>

			<?php foreach($author_ids as $author) : ?>

				<?php $curauth = get_userdata($author->ID); ?>

				<?php if($curauth->user_level > 0 || $curauth->user_login == 'admin') : ?>

					<div class="author-profile author-info vcard">

						<a href="<?php echo get_author_posts_url($curauth->ID); ?>" title="<?php echo $curauth->display_name; ?>">
							<?php echo get_avatar($curauth->user_email, '100', $hybrid_settings['default_avatar']); ?>
						</a>
						<h2 class="author-name fn n">
							<a href="<?php echo get_author_posts_url($curauth->ID); ?>" title="<?php echo $curauth->display_name; ?>"><?php echo $curauth->display_name; ?></a>
						</h2>
						<p class="author-bio">
							<?php echo $curauth->description; ?> <?php echo $curauth->user_role; ?>
						</p>
						<address class="author-email">
							<a href="mailto:<?php echo antispambot($curauth->user_email); ?>" class="email" title="<?php printf(__('Send an email to %1$s','hybrid'), antispambot($curauth->user_email)); ?>"><?php printf(__('Email %1$s','hybrid'),$curauth->display_name); ?></a>
						</address>

					</div>

				<?php endif; ?>

			<?php endforeach; ?>

			<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>

		</div>

		<?php edit_post_link(__('Edit','hybrid'), '<p class="post-meta-data"><span class="edit">', '</span></p>'); ?>

	</div>

	<?php hybrid_after_page(); // After page hook ?>

	<?php comments_template('', true); ?>

	<?php endwhile; ?>

<?php else: ?>

	<p class="no-data"><?php _e('Sorry, no page matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>