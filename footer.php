
		</div>
		<!-- //END CONTAINER -->

		<footer class="clearfix footer">
			<section class="footer-module footer-module-1">
				<header>
					<h1><?php echo wpautop(options('of_footer_menu_1')); ?></h1>
				</header>
				<?php wp_nav_menu( array( 'menu' => 'Footer Menu 1', 'container' => '') ); ?>
			</section>

			<section class="footer-module footer-module-2">
				<header>
					<h1><?php echo wpautop(options('of_footer_menu_2')); ?></h1>
				</header>
				<?php wp_nav_menu( array( 'menu' => 'Footer Menu 2', 'container' => '') ); ?>
			</section>

			<section class="footer-module footer-module-3">
				<header>
					<h1><?php echo wpautop(options('of_footer_menu_3')); ?></h1>
				</header>
				<?php wp_nav_menu( array( 'menu' => 'Footer Menu 3', 'container' => '') ); ?>
			</section>

			<div class="copyright">
				<p class="inner"><?php options('of_copyright'); ?></p>
			</div>
		</footer>
		<!-- //END FOOTER -->
		
	</div>
	<!-- //END WRAP -->
<?php wp_footer(); ?>
</body>
</html>


