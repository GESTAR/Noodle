<?php get_header(); ?>
<div id="primary">
	<?php if(have_posts()):while (have_posts()) : the_post();?>
		<div id="post-<?php the_ID(); ?>" <?php post_class();?>>
			<div class="post-header">
				<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title();?></a></h2>
			</div>
			<div class="post-meta">
				<span class="post-date"><?php the_time('Y-m-d') ?>&#160;&#183;&#160;</span>
				<span class="post-category"><?php the_category(' '); ?>&#160;&#183;&#160;</span>
				<span class="post-view"><?php if(function_exists('the_views')) the_views();?>&#160;&#183;&#160;</span>
				<span class="post-reply"><?php comments_popup_link('Leave a reply', '1 reply', '% replies'); ?></span>
			</div>
			<div class="post-body clearfix">
				<div class="post-content"><?php the_content(''); ?></div>
			</div>
		</div>
	<?php endwhile; endif;?>
	<div class="near-posts">
		<div>
			上一篇：<?php  if (get_next_post()) {next_post_link('%link');} else {echo "已是最新文章！";}; ?>
		</div>
		<div>
			下一篇：<?php  if (get_previous_post()) {previous_post_link('%link');} else {echo "已是最后一篇文章！";}; ?>
		</div>
	</div>
	<?php comments_template(); ?>
</div><!-- #primary -->
<?php if(!IsMobile) get_sidebar(); ?>
<?php get_footer(); ?>