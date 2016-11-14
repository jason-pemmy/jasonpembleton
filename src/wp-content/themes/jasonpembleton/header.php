<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title( '|', true, 'right' );?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
		<?php wp_head(); ?>
		<script>try { Typekit.load({async: true}); } catch (e) { }</script>
	</head>
	<body <?php body_class($post->post_name) ?>>
	<?php do_action('tbk_add_to_top_of_body'); ?>
		<a class="skip-to-content sr-only sr-only-focusable" href="#main">
			<?php _e('Skip to content', 'the-theme'); ?>
		</a>
		<header class="banner navbar navbar-default navbar-static-top" role="banner">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<div class="hamburger">
							<span class="hamburger-bar"></span>
							<span class="hamburger-bar"></span>
							<span class="hamburger-bar"></span>
						</div>
						<span class="btn-text sr-only"><?php _e( 'Menu', 'the-theme' ); ?></span>
					</button>
					<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
						<img class="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo('name');?>">
					</a>
				</div>
				<nav class="navbar-main" role="navigation">
					<?php
					wp_nav_menu( array(
						'container' => false,
						'menu' => 'Main Navigation',
						'menu_class' => 'nav navbar-nav',
						'link_before' => '<span class="menu-item-text">',
						'link_after' => '</span>',
						'walker' => new TBK_Nav_Walker(),
					));
					?>
				</nav>
				<div class="collapse navbar-collapse">
					<nav class="mobile-menu">
						<div class="mobile-menu-inner">
							<button class="btn btn-close-menu" role="button">
								<i class="icon-x"></i>
									<span class="btn-text sr-only">
										<?php _e('Close', 'the-theme');?>
									</span>
							</button>
							<?php
							wp_nav_menu( array(
								'container' => false,
								'menu' => 'Mobile Main Navigation',
								'menu_class' => 'nav navbar-nav navbar-mobile',
								'menu_id' => 'menu-mobile',
								'link_before' => '<span class="menu-item-text">',
								'link_after' => '</span>',
								'walker' => new TBK_Nav_Walker(),
							));
							?>
						</div>
					</nav>
				</div>
			</div>
		</header>
		<main id="main" class="main">