<?php

add_action('admin_menu', 'mfthemes_admin_menu');
function mfthemes_admin_menu() {
	add_theme_page('主题设置', '主题设置', 'edit_themes', basename(__FILE__), 'mfthemes_settings_page');
	add_action( 'admin_init', 'mfthemes_settings' );
}


function mfthemes_settings() {
	register_setting( 'mfthemes-settings-group', 'mfthemes_options' );
}

function mfthemes_settings_page() {
	if ( isset($_REQUEST['settings-updated']) ) echo '<div id="message" class="updated fade"><p><strong>主题设置已保存.</strong></p></div>';
	if( 'reset' == isset($_REQUEST['reset']) ) {
		delete_option('mfthemes_options');
		echo '<div id="message" class="updated fade"><p><strong>主题设置已重置!</strong></p></div>';
	}
?>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br></div><h2>主题设置</h2><br>
		<form method="post" action="options.php">
			<?php settings_fields( 'mfthemes-settings-group' ); ?>
			<?php $options = get_option('mfthemes_options'); ?>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label>网站描述</label></th>
						<td>
							<p>用简洁凝练的话对你的网站进行描述</p>
							<p><textarea type="textarea" class="large-text" name="mfthemes_options[description]"><?php echo $options['description']; ?></textarea></p>
						</td>
					</tr>	
					<tr valign="top">
						<th scope="row"><label>网站关键词</label></th>
						<td>
							<p>多个关键词请用英文逗号隔开</p>
							<p><textarea type="textarea" class="large-text" name="mfthemes_options[keywords]"><?php echo $options['keywords']; ?></textarea></p>
						</td>
					</tr>						
				</tbody>
			</table>			
			<div class="mfthemes_submit_form">
				<input type="submit" class="button-primary mfthemes_submit_form_btn" name="save" value="<?php _e('Save Changes') ?>"/>
			</div>
		</form>
		<form method="post">
			<div class="mfthemes_reset_form">
				<input type="submit" name="reset" value="<?php _e('Reset') ?>" class="button-secondary mfthemes_reset_form_btn"/> 重置有风险，操作需谨慎！
				<input type="hidden" name="reset" value="reset" />
			</div>
		</form>
	</div>
<?php }