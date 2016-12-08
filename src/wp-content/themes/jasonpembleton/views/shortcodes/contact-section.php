<div class="contact-section-container">
    <div class="contact-heading"><h5><?php echo $heading; ?></h5></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-sm-6 contact-info">            	
                <div class="contact-email"><?php echo $email; ?></div>
                <div class="contact-telephone"><?php echo $telephone; ?></div>
                <div class="contact-linkedin"><?php echo $linkedin; ?></div>
			</div>
            <div class="col-sm-12 col-md-6 form-wrapper">
                <?php  echo gravity_form( Contact, $display_title = false, $display_description = false, $display_inactive = false, $field_values = null, $ajax = false, $tabindex, $echo = true ); ?>
            </div>            
        </div>        
    </div>	
</div>   
