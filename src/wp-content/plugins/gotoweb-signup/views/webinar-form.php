<?php global $gotoweb?>
<div id="webinar-form">
	<?php if(isset($webinar_meta['cta'])&&$webinar_meta['cta'] != ''&&$hide_title == 'no') {?>
		<h2>
			<div class="arrow"></div>
			<?php echo $webinar_meta['cta'];?>
		</h2>
	<?php } ?>
	<?php if(isset($webinar_fields['fields']) && ! empty($webinar_fields['fields'])) { ?>
	<form action="" method="post">
		<?php $gotoweb->display_form_messages();?>
		<input type="hidden" name="return_page" value="<?php echo (isset($webinar_meta['return_url'])&&$webinar_meta['return_url'] != '')?$webinar_meta['return_url']:'';?>" />
		<input type="hidden" name="webinarid" value="<?php echo $webinar_meta['id'];?>" />
		<input type="hidden" name="action" value="webinar_register" />
		<?php foreach($webinar_fields['fields'] as $key => $f) {?>
			<div class="input-container fields field-<?php echo sanitize_title($f['field']);?>">
				<label for="<?php echo $f['field'];?>"><?php echo uncamelize($f['field']);?></label>
				<?php if($f['field'] == 'questionsAndComments') {?>
					<textarea name="<?php echo $f['field'];?>" placeholder="<?php echo uncamelize($f['field']);?>" <?php echo ($f['required'] === true)?'required':'';?> id="<?php echo $f['field'];?>"></textarea>
				<?php } else if(isset($f['answers'])) { ?>
					<select name="fAns[<?php echo $f['field'];?>]" id="<?php echo $f['field'];?>">
							<option value="<?php echo $f['field'];?>"><?php echo uncamelize($f['field']);?></option>
						<?php foreach($f['answers'] as $a) {?>
							<option value="<?php echo $a;?>"><?php echo uncamelize($a);?></option>
						<?php } ?>
					</select>
				<?php } else { ?>
					<input type="text" name="<?php echo $f['field'];?>" placeholder="<?php echo uncamelize($f['field']);?>" <?php echo ($f['required'] === true)?'required':'';?> id="<?php echo $f['field'];?>"/>
					<?php echo ($f['required'] === true)?'<span></span>':'';?>
				<?php } ?>
			</div>
		<?php } ?>
		<?php foreach($webinar_fields['questions'] as $key => $q) {?>
			<div class="input-container questions" id="<?php echo $q['field'];?>">
				<label for="cqAns<?php echo $key;?>"><?php echo $q['question'];?></label>
				<?php if(isset($q['answers'])) { ?>
					<select name="cqAns[<?php echo $key;?>]" id="cqAns<?php echo $key;?>">
						<?php foreach($q['answers'] as $a) {?>
							<option value="<?php echo $a['answerKey'];?>"><?php echo uncamelize($a['answer']);?></option>
						<?php } ?>
					</select>
				<?php } else { ?>
					<textarea name="cqAns[<?php echo $key;?>]" <?php echo ($q['required'] === true)?'required':'';?> id="cqAns<?php echo $key;?>"></textarea>
					<?php echo ($q['required'] === true)?'<span></span>':'';?>
				<?php } ?>
				<input type="hidden" name="cqQuestion[<?php echo $key;?>]" value="<?php echo $q['question'];?>"/>
				<input type="hidden" name="cqType[<?php echo $key;?>]" value="<?php echo isset($q['answers'])?'answerKey':'responseText';?>"/>
				<input type="hidden" name="cqKey[<?php echo $key;?>]" value="<?php echo $q['questionKey'];?>"/>
			</div>
		<?php } ?>
		<div class="clear"></div>
		<?php do_action('before_gtw_submit');?>
		<p>
			<input type="submit" name="submit" value="<?php _e('Register Now') ?>"/>
		</p>
	</form>
	<?php } else {
		echo wpautop(__('There was an error connecting to your Webinar. Please make sure that the Webinar settings are correct.', 'gotowebinar'));
	} ?>
	<div class="highlight"></div>
</div>
<style>
#webinar-form {
	<?php echo (isset($webinar_meta['form_color'])?'background-color: '.$webinar_meta['form_color'].';':'');?>
}
</style>