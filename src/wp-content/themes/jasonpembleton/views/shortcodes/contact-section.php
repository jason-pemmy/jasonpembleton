<div class="contact-section-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <?php  echo gravity_form( Contact, $display_title = false, $display_description = false, $display_inactive = false, $field_values = null, $ajax = false, $tabindex, $echo = true ); ?>
            </div>
            <div class="col-sm-6">
            	<div class="contact-heading"><?php echo $heading; ?></div>
                <div class="contact-email"><?php echo $email; ?></div>
                <div class="contact-telephone"><?php echo $telephone; ?></div>
                <div class="contact-linkedin"><?php echo $linkedin; ?></div>
			</div>
        </div>        
    </div>	
</div>  
