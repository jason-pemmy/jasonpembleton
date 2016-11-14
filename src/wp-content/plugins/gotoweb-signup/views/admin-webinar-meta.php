<?php 
global $gotoweb;
$meta = $gotoweb->format_webinar_meta( get_the_ID() );?>
<h4>Webinar Setup: </h4>
<table class="widefat">
	<tbody>
		<tr>
			<td>
				Webinar ID: 
				<br /><small>(Required)</small>
			</td>
			<td>
				<input type="text" name="webinar[id]" value="<?php echo (isset($meta['id'])?$meta['id']:'');?>"/>
				<a href="<?php echo plugin_dir_url( dirname(__FILE__) );?>images/gotowebinar-id.jpg" class="thickbox">
					<img src="<?php echo plugin_dir_url( dirname(__FILE__) );?>images/question.png"/>
				</a>
			</td>
		</tr>
		<tr>
			<td>Date & Time: </td>
			<td>
				<textarea name="webinar[datetime]" style="width: 90%;"><?php echo (isset($meta['datetime'])?$meta['datetime']:'');?></textarea>
			</td>
		</tr>
		<tr>
			<td>Call to Action: </td>
			<td>
				<textarea name="webinar[cta]" style="width: 90%;"><?php echo (isset($meta['cta'])?$meta['cta']:'');?></textarea>
			</td>
		</tr>
		<tr>
			<td>Thank you Page: </td>
			<td>
				<input type="text" name="webinar[return_url]" value="<?php echo (isset($meta['return_url'])?$meta['return_url']:'');?>" style="width: 400px;"/>
				<br />
				<small>
					*You may leave this field blank to return to the same page. 
					If this field is in use, you will need http:// before the website url.
				</small>
			</td>
		</tr>
		<tr>
			<td>Page Logo: </td>
			<td>
				<?php if (isset($meta['logo'])) {;?>
					<img src="<?php echo $meta['logo'];?>"/><br />
				<?php } ?>
				<input id="upload_image" type="text" size="36" name="webinar[logo]" value="<?php echo (isset($meta['logo'])?$meta['logo']:'');?>"/>
				<input id="upload_image_button" type="button" value="Upload Image" />
			</td>
		</tr>
		<tr>
			<td>Form Colour: </td>
			<td>
				<input type="text" name="webinar[form_color]" value="<?php echo (isset($meta['form_color'])?$meta['form_color']:'');?>" id="form_color"/>
				<div id="colorpicker"></div>
			</td>
		</tr>		
	</tbody>
</table>
<?php if(isset($meta['id'])){?>
	<p>
		<h4>Add to Post/Pages: </h4>
			[webinar_form id=<?php the_ID();?>] <br /> <em>or</em> <br />
			[webinar_form id=<?php the_ID();?> hide_title=yes]
	</p>
<?php } ?>
<?php wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce'); ?>
<script type="text/javascript">
//Set up the color pickers to work with our text input field
jQuery(document).ready(function(){
	"use strict";
	
	//This if statement checks if the color picker widget exists within jQuery UI
	//If it does exist then we initialize the WordPress color picker on our text input field
	if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ){
		jQuery( '#form_color' ).wpColorPicker();
	}
	else {
		//We use farbtastic if the WordPress color picker widget doesn't exist
		jQuery( '#colorpicker' ).farbtastic( '#form_color' );
	}
});
jQuery(document).ready(function() {
	jQuery('#upload_image_button').click(function() {
		formfield = jQuery('#upload_image').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery('#upload_image').val(imgurl);
		tb_remove();
	}
});
</script>
<style>
#webinar_meta_box table td {
	width: 33%;
	vertical-align: top;
}
</style>