<?php

$of_is_seo = get_option( 'of_is_seo' );

if( '' == $of_is_seo || 'true' == $of_is_seo )
	add_action('init', 'yh_themeCustomFieldInit');

function yh_themeCustomFieldInit() { $t = new yh_themeCustomField(); }
class yh_themeCustomField {
	function get_meta_fields() {
		if(!empty($this->meta_fields)) {
			return $this->meta_fields;
		}
		global $post;
		$type = $post->post_type;
		if(!empty($_GET['post_type'])) {
			$type = $_GET['post_type'];
		}
		$default_meta = array(
		);
		switch($type) {
			default:
				$custom_meta = array(
					'seo_title'=>array(
						'title'=>'Title',
						'std'=>'',
						'type'=>'textarea'
					),
					'seo_desc'=>array(
						'title'=>'Descriptions',
						'std'=>'',
						'type'=>'textarea'
					),
					'seo_keywords'=>array(
						'title'=>'Keywords',
						'type'=>'textarea'
					)																	
				);
				break;
		}
		$meta_fields = array_merge($default_meta,$custom_meta);
		// $new_arr = array();
		// $availableLanguages = '';
		// if(function_exists('qtrans_getAvailableLanguages'))
		// {
		// 	$availableLanguages = qtrans_getAvailableLanguages('enabled_languages');
		// }
		// if(is_array($meta_fields))
		// foreach( $meta_fields as $key=>$val )
		// {
		// 	if(isset($availableLanguages) && is_array($availableLanguages))
		// 	foreach( $availableLanguages as $lang_key )
		// 	{
		// 		$t = $val;
		// 		$t['title'] = $val['title'].' ('.$lang_key.')';
		// 		$new_arr[$key.'_'.$lang_key] = $t;
		// 	}
		// 	else{
		// 		$new_arr[$key] = $val;
		// 	}
		// }
		// $meta_fields = $new_arr;
		$this->meta_fields = $meta_fields;
		return $this->meta_fields;
	}

	function meta_box()
	{
		global $post;
		
		$arr = $this->get_meta_fields();
		if(is_array($arr))
		foreach( $arr as $key=>$val )
		{
			switch($val['type'])
			{
				case 'image':
					$src = get_post_meta($post->ID, $key, $single=1);
	?>
					<p class="img">
						<strong><?php echo $val['title']?></strong><br />
						<input class="upload_image" type="text" size="36" style="width:80%" name="<?php echo $key?>" value="<?php if(!empty($src)) echo $src; else echo $val['std']; ?>" />
						<input class="upload_image_button" type="button" value="Upload" />
						<!--<br />-->
						<?php //if(!empty($src)) echo '<img src="'.$src.'" height="100" />'; ?>
					</p>
	<?php 
					break;
				case 'input':
					$text = get_post_meta($post->ID, $key, $single=1);
	?>
					<p class="text">
						<strong><?php echo $val['title']?></strong><br />
						<input class="text multilanguage-input" type="text" size="36" style="width:80%" name="<?php echo $key?>" value="<?php if(!empty($text)) echo $text; else echo $val['std']?>" />
					</p>
	<?php 
					break;
				case 'textarea':
					$text = get_post_meta($post->ID, $key, $single=1);
	?>
					<p class="textarea" >
						<strong><?php echo $val['title']?></strong><br />
						<textarea class="multilanguage-input" style="width:100%" name="<?php echo $key?>"><?php if(!empty($text)) echo $text; else echo $val['std']; ?></textarea>
					</p>
	<?php 
					break;
				case 'head':
					$text = get_post_meta($post->ID, $key, $single=1);
	?>
					<p style="color: #257EA8; font-weight: bold; font-size: 16px;border-bottom: 2px dotted #257EA8; width: 80%;">
						<?php echo $val['title']?>
					</p>
	<?php 
					break;
				
				default:
					break;
			}
		}
	?>
<script type="text/javascript">
		// conflict with custom meta
//<![CDATA[
//jQuery(function($){
//	var formfield;
//
//	$('.upload_image_button').click(function() {
//		$('html').addClass('Image');
//		formfield = $('.upload_image',$(this).parent()).attr('name');
//		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
//		return false;
//	});
//
//	// user inserts file into post. only run custom if user started process using the above process
//	// window.send_to_editor(html) is how wp would normally handle the received data
//
//	window.original_send_to_editor = window.send_to_editor;
//	window.send_to_editor = function(html){
//		if (formfield) {
//			fileurl = $('img',html).attr('src');
//			$('.upload_image[name="'+formfield+'"]').val(fileurl);
//			tb_remove();
//			$('html').removeClass('Image');
//		} else {
//			window.original_send_to_editor(html);
//		}
//	};
//});
//]]>
</script>

	<?php 
	}
	function admin_init()
	{
		$type = 'post';
		add_meta_box($type."-meta", "SEO Options", array(&$this, "meta_box"), $type, "side", "low");

		$type = 'page';
		add_meta_box($type."-meta", "SEO Options", array(&$this, "meta_box"), $type, "side", "low");

		$args = array(
		  'public'   => true,
		  '_builtin' => false
		); 

		$custom_post_types = get_post_types($args, 'objects');
		if(!empty($custom_post_types))
		{
			foreach ($custom_post_types as $key => $custom_post_type) 
			{
				add_meta_box($custom_post_type->name."-meta", "SEO Options", array(&$this, "meta_box"), $custom_post_type->name, "side", "low");
			}
		}

		add_action('admin_print_scripts', array(&$this,'my_admin_scripts'));
		add_action('admin_print_styles', array(&$this,'my_admin_styles'));
	}
	
	function my_admin_scripts() 
	{
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}

	function my_admin_styles() 
	{
		wp_enqueue_style('thickbox');
	}

	function __construct()
	{
		// Admin interface init
		add_action("admin_init", array(&$this, "admin_init"));
		
		// Insert post hook
		add_action("wp_insert_post", array(&$this, "wp_insert_post"), 10, 2);
	}
	
	// When a post is inserted or updated
	function wp_insert_post($post_id, $post = null)
	{
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return $post_id;
		
		$arr = $this->get_meta_fields();
		// Loop through the POST data
		foreach ($arr as $key=>$val)
		{
			$value = @$_POST[$key];
			if (empty($value))
			{
				delete_post_meta($post_id, $key);
				continue;
			}

			// If value is a string it should be unique
			if (!is_array($value))
			{
				// Update meta
				if (!update_post_meta($post_id, $key, $value))
				{
					// Or add the meta data
					add_post_meta($post_id, $key, $value);
				}
			}
			else
			{
				// If passed along is an array, we should remove all previous data
				delete_post_meta($post_id, $key);
				
				// Loop through the array adding new values to the post meta as different entries with the same name
				foreach ($value as $entry)
				{
					add_post_meta($post_id, $key, $entry);
				}
			}
		}
	}
}
