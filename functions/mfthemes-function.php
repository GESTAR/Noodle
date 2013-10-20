<?php
/**
 * LovePhoto core theme functions
 *
 *
 * @package LovePhoto
 * @author Mufeng
 * @url http://mufeng.me
 */

	define('IsMobile', wp_is_mobile());
	
	define("TPLDIR", get_bloginfo('template_directory'));
 
	// Theme functions
	if( is_admin() ) :
		get_template_part('functions/mfthemes-admin');
	else :
		get_template_part('functions/mfthemes-meta');
		get_template_part('functions/mfthemes-action');
	endif;
	// Add rss feed 
	add_theme_support( 'automatic-feed-links' );

	// Register wordpress menu
	if ( function_exists('register_nav_menus') ) {
		register_nav_menus(array('primary' => 'nav'));
	}

	// Enqueue style-file, if it exists.
	add_action('wp_enqueue_scripts', 'mfthemes_script');
	function mfthemes_script() {
		if( !IsMobile ){
			wp_enqueue_style('style', TPLDIR . '/style.css', array(), '1.2', 'screen');
			wp_enqueue_script( 'sidebar-follow', TPLDIR . '/script/sidebar-follow.js', array(), '1.0', false);
		}else{
			wp_enqueue_style('mobile', TPLDIR . '/mobile.css', array(), '1.0', 'screen');
			wp_enqueue_script( 'mobile', TPLDIR . '/script/mobile.js', array(), '1.0.0', false);
		}
				
		if ( is_singular() || is_page()){
			wp_enqueue_script( 'jquery1.8.2', TPLDIR . '/script/jquery.min.js', array(), '1.8.2', false);
			
			if( is_page('archives') ){
				wp_enqueue_style( 'archives', TPLDIR . '/script/archives.css', array(), '1.0.0', 'screen');
				wp_enqueue_script( 'archives', TPLDIR . '/script/archives.js', array(), '1.0.0', false);
			}else{
				global $post;
				$postid = $post->ID;
				$ajaxurl = home_url("/");
				
				wp_enqueue_script( 'single', TPLDIR . '/script/single.js', array(), '1.0.2', false);
				
				wp_localize_script( 'single', 'mufeng', 
					array(
						"postid" => $postid,
						"ajaxurl" => $ajaxurl
				));
			}
		}
	}
	
	// Pagenavi of archive and index part
	function pagenavi( $p = 5 ) {
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return;
		if ( empty( $paged ) ) $paged = 1;
		if ( $paged > 1 ) p_link( $paged - 1, '« Previous', '« Previous' );
		if ( $paged > $p + 2 ) echo '<span class="page-numbers">...</span>';
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo '<span class="page-numbers">...</span>';
		if ( $paged < $max_page ) p_link( $paged + 1,'Next »', 'Next »' );
	}

	function p_link( $i, $title = '', $linktype = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
		echo "<a class='page-numbers' href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a> ";
	}
	
	function mfthemes_modified($number=10){?>
		<ul class="list">
			<?php $args = array(
					'orderby' => 'modified',
					'ignore_sticky_posts' => 1,
					'post_type' => 'post',
					'post_status' => 'publish',
					'showposts' => $number
				);
				$index = 0;
				$posts = query_posts($args); ?>
			<?php while(have_posts()) : the_post(); ?>
			<li><p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
			<p>更新时间：<span><?php echo time_since(abs(strtotime($posts[$index]->post_modified_gmt)));?></span></p></li>
			<?php $index++; endwhile;wp_reset_query() ?>
		</ul>	
	<?php }
	
	function mfthemes_sticky($number=10){?>
		<ul class="list">
			<?php $args = array(
       				 	'numberposts' => $posts_num,
       				 	'post__in' => get_option('sticky_posts'),
        				'orderby' => 'modified'
				);
				$posts = query_posts($args); ?>
			<?php while(have_posts()) : the_post(); ?>
			<li class="widget-popular"><p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a><span>[<?php if(function_exists('the_views')) the_views();?>]</span></p></li>
			<?php endwhile;wp_reset_query() ?>
		</ul>	
	<?php }	
	
	function mfthemes_popular($number=10){?>
		<ul class="list">
			<?php $args = array(
					'paged' => 1,
					'meta_key' => 'views',
					'orderby' => 'meta_value_num',
					'ignore_sticky_posts' => 1,
					'post_type' => 'post',
					'post_status' => 'publish',
					'showposts' => $number
				);
				$posts = query_posts($args); ?>
			<?php while(have_posts()) : the_post(); ?>
			<li class="widget-popular"><p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a><span>[<?php if(function_exists('the_views')) the_views();?>]</span></p></li>
			<?php endwhile;wp_reset_query() ?>
		</ul>	
	<?php }	

	function time_since($older_date,$comment_date = false) {
		$chunks = array(
			array(86400 , '天前'),
			array(3600 , '小时前'),
			array(60 , '分钟前'),
			array(1 , '秒前'),
		);
		$newer_date = time();
		$since = abs($newer_date - $older_date);
		if($since < 2592000){
			for ($i = 0, $j = count($chunks); $i < $j; $i++){
				$seconds = $chunks[$i][0];
				$name = $chunks[$i][1];
				if (($count = floor($since / $seconds)) != 0) break;
			}
			$output = $count.$name;
		}else{
			$output = !$comment_date ? (date('Y-m-j G:i', $older_date)) : (date('Y-m-j', $older_date));
		}
		return $output;
	}

	// Theme init
	//add_filter('get_avatar', 'my_avatar');
	function my_avatar($avatar) {
		if(strpos($avatar, 'gravatar')){
			$tmp = strpos($avatar, 'http'); 
			$g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp); 
			$tmp = strpos($g, 'avatar/') + 7; 
			$f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp); 
			$w = get_bloginfo('wpurl'); 
			$e = ABSPATH .'avatar/'. $f .'.jpg'; 
			$t = 1209600;
			if ( !is_file($e) || (time() - filemtime($e)) > $t ) {
				@copy(htmlspecialchars_decode($g), $e); 
			} else $avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.jpg')); 
			if (filesize($e) < 500) @copy($w.'/avatar/default.jpg', $e); 
		}
		return $avatar; 
	}

	function comment_mail_notify($comment_id) {
		$comment = get_comment($comment_id);
		$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
		$spam_confirmed = $comment->comment_approved;
		
		$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";	
		
		if (($parent_id != '') && ($spam_confirmed != 'spam')) {
			$to = trim(get_comment($parent_id)->comment_author_email);
			$subject = '你在 [' . get_option("blogname") . '] 的留言有了新回复';
			$message = '
				<div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px; border-radius:5px;">
				<p><strong>' . trim(get_comment($parent_id)->comment_author) . ', 你好!</strong></p>
				<p><strong>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言为:</strong><br />'
				. trim(get_comment($parent_id)->comment_content) . '</p>
				<p><strong>' . trim($comment->comment_author) . ' 给你的回复是:</strong><br />'
				. trim($comment->comment_content) . '<br /></p>
				<p>你可以点击此链接 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看完整内容</a></p><br />
				<p>欢迎再次来访<a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
				<p>(此邮件为系统自动发送，请勿直接回复.)</p>
				</div>';

			wp_mail( $to, $subject, $message, $headers );
		}
	}
	add_action('comment_post', 'comment_mail_notify');
	
	// MF_coment part
	function mfthemes_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		global $commentcount;
		if(!$commentcount) {
		   $page = ( !empty($in_comment_loop) ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;
		   $cpp = get_option('comments_per_page');
		   $commentcount = $cpp * $page;
		}
		if(!$comment->comment_parent){
		?>
		   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment-body">
					<div class="comment-avatar"><?php echo get_avatar( $comment, $size = '50'); ?></div>
						<span class="comment-floor">
							<?php 
								++$commentcount;
								switch($commentcount){
									case 1:
										print_r("沙发");
										break;
									case 2:	
										print_r("板凳");
										break;	
									case 3:	
										print_r("地板");
										break;		
									default:
										printf(__('%s楼'), $commentcount);
								}
							?>
						</span>					
					<div class="comment-data">
						<span class="comment-span"><?php printf(__('%s'), get_comment_author_link()) ?></span>
						<span class="comment-span comment-date"><?php echo time_since(abs(strtotime($comment->comment_date_gmt . "GMT")), true);?></span>
					</div>
					<div class="comment-text"><?php comment_text() ?></div>
					<div class="comment-reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('回复')))) ?></div>
				</div>
		<?php }else{?>
		   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment-body comment-children-body">
					<div class="comment-avatar"><?php echo get_avatar( $comment, $size = '30'); ?></div>
					<span class="comment-floor"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('回复')))) ?></span>					
					<div class="comment-data">
						<span class="comment-span">
							<?php $parent_id = $comment->comment_parent; $comment_parent = get_comment($parent_id); printf(__('%s'), get_comment_author_link()) ?>
						</span>
						<span class="comment-span comment-date"><?php echo time_since(abs(strtotime($comment->comment_date_gmt . "GMT")), true);?></span>
					</div>
					<div class="comment-text">
						<span class="comment-to"><a href="<?php echo "#comment-".$parent_id;?>" title="<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $comment_parent->comment_content)), 0, 100,"..."); ?>">@<?php echo $comment_parent->comment_author;?></a>：</span>
						<?php echo get_comment_text(); ?>
					</div>
				</div>	
		<?php }
	}
?>