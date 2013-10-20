<?php get_header();?>
	<div id="primary">
		<div id="postlist">
			<?php $args = array(
					'ignore_sticky_posts' => 1,
				);
				$posts = query_posts($args); ?>
			<?php if(have_posts()):while (have_posts()) : the_post();?>
				<div id="post-<?php the_ID(); ?>" <?php post_class();?>>
					<div class="post-header">
						<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php if(is_sticky()){echo("<span style=\"color:red\">[置顶]</span>");} the_title();?></a></h2>
					</div>
					<div class="post-meta clearfix">
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
		</div>
		<div id="pagenavi"><?php pagenavi();?></div>
	</div>
<?php if(!IsMobile) get_sidebar(); ?>
<?php get_footer(); ?>