		</main>
		<footer class="page-footer">
			<div class="container">
				<nav class="nav-footer">
				</nav>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-sm-6">   
						<div class="footer-image-container">
							<img src="<?php echo get_template_directory_uri() ?>/images/footer-image.png" />
						</div>
						<div class="footer-personal-info">
							<span class="footer-heading">Jason Pembleton</span>
							<a class="linkedin-link" href="#"/><span class="icon-linkedin"></span></a>
							<span class="footer-address">753 Garibaldi Ave. London Ontario, Canada</span>
							<div class="footer-tel">
								<span class="icon-phone"></span>
                				<?php the_field('telephone_number', 'option'); ?>
                            </div>
                            <div class="footer-mail">
                                <span class="icon-mail4"></span>
                                <a href="mailto:<?php the_field('email', 'option'); ?>"><?php the_field('email', 'option'); ?></a>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="footer-main-menu">
							<?php
								wp_nav_menu( array(
									'container' => false,
									'menu' => 'FooterMainMenu',
									'menu_class' => 'nav navbar-nav-footer',
									'link_before' => '<span class="menu-item-text">',
									'link_after' => '</span>',
									'walker' => new TBK_Nav_Walker(),
								));
							?>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html> 