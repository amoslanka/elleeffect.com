					<div class="postinfo">
						<ul>
							<li class="author" title="posted by"><?php the_author_link(); ?></li>
							<li class="date" title="posted on"><?php the_time('m.d.y') ?></li>
							<li class="category-info" title="category"><?php the_category(', '); ?><?php if(function_exists("the_tags")) the_tags(', ', ', ', ''); ?></li>
							<li class="comment-number" title="comments"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></li>

							<li class="edit-info"><?php edit_post_link('Edit', ' &#124; ', ''); ?></li>
						</ul>
					</div>

					<div class="clear"></div>