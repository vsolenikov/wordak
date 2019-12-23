<?php
/**
 * The template for displaying the footer.
 *
 * Contains all content after the main content area and sidebar
 *
 * @package Admiral
 */

?>

	</div><!-- #content -->

	<?php do_action( 'admiral_before_footer' ); ?>

	<div id="footer" class="footer-wrap">
		
		 <div id="footer-widgets">
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-1') ) : ?>
    <?php endif; ?>

    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-2') ) : ?>
    <?php endif; ?>    
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-3') ) : ?>
    <?php endif; ?>
    </div>
    <div style="clear-both"></div>

		<footer id="colophon" class="site-footer container" role="contentinfo">

			<div class="footer-content clearfix">
				<img src="https://admtmr.ru/upload/coats/user/logo%20(1).png" class="footer_img">
				<div id="footer-text" class="site-info">
					<?php //do_action( 'admiral_footer_text' ); ?>
				</div><!-- .site-info -->

				<?php do_action( 'admiral_footer_menu' ); ?>

			</div>

		</footer><!-- #colophon -->

	</div>

</div><!-- #page -->

<?php wp_footer(); ?>

<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

<script>
$('#main-navigation-toggle').click(function() {
  $('section#secondary').toggle();
});
</script>

</body>
</html>
