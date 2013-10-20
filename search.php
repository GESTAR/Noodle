<?php get_header();?>
	<div id="primary">
	<?php if (have_posts()) : while (have_posts()) : the_post();?>
		<div id="postlist">
			<div id="post-<?php the_ID(); ?>" <?php post_class();?>>
				<div class="post-header">
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title();?></a></h2>
				</div>
				<div class="post-meta clearfix">
					<span class="post-date"><?php the_time('Y-m-d') ?>&#160;&#183;&#160;</span>
					<span class="post-category"><?php the_category(' '); ?>&#160;&#183;&#160;</span>
					<span class="post-view"><?php if(function_exists('the_views')) the_views();print_r(" views")?>&#160;&#183;&#160;</span>
					<span class="post-reply"><?php comments_popup_link('Leave a reply', '1 reply', '% replies'); ?></span>
				</div>
				<div class="post-body clearfix">
					<div class="post-content"><?php the_content(''); ?></div>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
		<div id="pagenavi"><?php pagenavi();?></div>
	<?php else: ?>
		<div class="post">
			<p>未能找到相关文章，或许可以尝试以下标签</p>
			<div class="entry">
				<?php wp_tag_cloud('smallest=9&largest=22&unit=pt&number=200&format=flat&orderby=name&order=ASC');?>
			</div>
		</div>
	<?php endif; ?>	
	</div>
<?php if(!IsMobile) get_sidebar(); ?>
<?php get_footer(); ?>