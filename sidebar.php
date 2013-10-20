<div id="sidebar">
	<div class="widget widget-populars">
		<h3>置顶文章</h3>
		<?php mfthemes_sticky(10);?>
	</div>	
	<div class="widget widget-populars">
		<h3>热门文章</h3>
		<?php mfthemes_popular(10);?>
	</div>		
	<div class="widget">
		<h3>最近更新的文章</h3>
		<?php mfthemes_modified(8);?>
	</div>
	<div class="widget" id="sidebarFollow">
		<h3>分类</h3>
		<?php wp_list_categories('title_li='); ?>
	</div>
</div><!-- end #sidebar -->
<script>
(new SidebarFollow()).init({
	element: 'sidebarFollow',
	distanceToTop: 30
});
</script>