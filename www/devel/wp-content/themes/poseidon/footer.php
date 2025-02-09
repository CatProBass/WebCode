<?php
/**
 * The template for displaying the footer.
 *
 * Contains all content after the main content area and sidebar
 *
 * @package Poseidon
 */

?>

	</div><!-- #content -->

	<?php do_action( 'poseidon_before_footer' ); ?>

	<div id="footer" class="footer-wrap">

		<footer id="colophon" class="site-footer container clearfix" role="contentinfo">

			<?php do_action( 'poseidon_footer_menu' ); ?>

			<div id="footer-text" class="site-info">
			<div class="floatl">
				&copy; <?php echo date ("Y");?> Catalunya Pro Bass	
				</div>	
			<div class="floatr"><a href="/aviso-legal/">Aviso Legal</a> <a href=" /politica-de-cookies/" target="_blank">Política de Cookies</a>
				</div>
			<div style="clear:both">
				
				</div>
                
                <div class="sponsors">
                <a href="http://www.aebass.com" title="Asociación Española del Black Bass" target="_blank"><img src="/wp-content/uploads/2017/12/logo.png" alt="AEBASS" /></a>
                <a href="http://camping-portmassaluca.es" target="_blank" title="Camping Port Massaluca"><img src="/wp-content/uploads/2017/12/masaluca.png" alt="Camping Por Massaluca" /></a>
                <a href="http://servikayak.com/" title="Servikayak"><img src="/wp-content/uploads/2017/12/logo_servi_OK2.png" alt="ServiKayak" /></a>
                </div>
                
                </div><!-- .site-info -->

		</footer><!-- #colophon -->

	</div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
