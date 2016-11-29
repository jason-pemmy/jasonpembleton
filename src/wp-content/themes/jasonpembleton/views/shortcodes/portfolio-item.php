<a class="portfolio-item-link" href="<?php echo $url; ?>" target="_blank"/>
    <div class="portfolio-item-container" style="background-color: <?php echo $bg_color; ?>">
        <div class="item-logo-container">
            <img src="<?php echo $image; ?>" />		
        </div>
        <div class="item-detail-overlay-container">
           <div class="overlay-content">
           		<div class="item-heading"><?php echo $heading; ?></div>
				<div class="item-icon-list">
					<?php
						$ary = explode(",",$icon_list);                    
						$arrlength = count($ary);
						$iconStr = "";
						for($x = 0; $x < $arrlength; $x++) {
							$iconStr .= "<div class='icon-container'>";
							$iconStr .= "<span class='".$ary[$x]."' ></span>";
							$iconStr .= "</div>";                        
						}
						echo $iconStr;
					?>
				</div>
				<div class="item-copy"><?php echo $copy; ?></div>
           </div>            
        </div>    
    </div> 
</a> 