<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<?php mfthemes_meta();?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="header">
	<div class="container clearfix">
		<!--<h2 class="logo"><a href="<?php bloginfo('url');?>" title="<?php bloginfo('name'); ?>" rel="home"><?php bloginfo('name'); ?></a></h2>-->
		<?php if( IsMobile ){?><div id="mobile-menu"></div><?php }?>
		<?php wp_nav_menu(array( 'theme_location'=>'primary','container_class' => 'header-menu')); ?>
		<?php if( !IsMobile ){?>
			<form method="get" class="search-form" action="<?php bloginfo('url');?>">
				<input type="text" name="s" class="search-input" size="15"/>
				<input type="submit" alt="search" class="search-submit">
			</form>
		<?php }else{?>
			<script type="text/javascript">
				var _id = function(_){
						return document.getElementById(_)
					};
					
				_id("mobile-menu").onclick = function(){
					if( _id("header").className == "selected" ){
						_id("header").className = ""
					}else{
						_id("header").className = "selected"
					}
				}
			</script>
		<?php }?>
	</div>
</div><!-- #header -->
<div id="content">
	<div class="container clearfix">