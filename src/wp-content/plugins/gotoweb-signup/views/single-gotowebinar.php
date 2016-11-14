<?php
get_header();
global $gotoweb;
$webinar_meta = $gotoweb->format_webinar_meta( get_the_ID() );

$has_logo_img = ( isset($webinar_meta['logo']) && strlen(trim($webinar_meta['logo'])) > 0 );
?>
<div class="gotowebinar">
	<div class="wrapper header">
		<div class="container">
			<?php if( $has_logo_img ) {?>
				<img src="<?php echo $webinar_meta['logo'];?>"/>
			<?php } ?>
		</div>
	</div>
	<div class="wrapper featured-image" style="background: url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>) 0 0 no-repeat;">

	</div>
	<div class="wrapper content">
		<div class="container">
			<div class="row">
				<div class="col col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<h1><?php the_title();?></h1>
					<?php echo wpautop($post->post_content);?>
				</div>
				<div class="col col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<?php echo do_shortcode('[webinar_form id='.get_the_ID().']');?>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper footer">
		<div class="container">
			<div class="row">
				<div class="col col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<img src="<?php echo plugins_url('/images/GoToWebinar_logo_web.png', dirname(__FILE__) );?>" class="gtw-logo"/>
				</div>
				<div class="col col-lg-4 col-md-4 col-sm-4 col-xs-12">
					&copy; <?php echo date('Y');?> | <?php bloginfo('name');?>
				</div>
				<div class="col col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right text-right">
					<a href="http://www.tbkcreative.com" target="_blank" class="tbk">
						<strong>tbk Creative</strong> | Web Design &amp; Social Media Marketing
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
