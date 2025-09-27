<?php
/**
 * Footer Template
 *
 * Schließt die Haupt-Layout-Container und lädt den Footer-Inhalt.
 * Diese Datei wird am Ende jeder Seite geladen und schließt das
 * von header.php geöffnete HTML-Grundgerüst.
 *
 * Struktur:
 * - Schließt #content Container (geöffnet in header.php)
 * - Zeigt BMFSFJ Logo/Sponsor-Information
 * - Lädt footer-content Template Part mit Navigation und Newsletter
 * - Schließt #page Container (geöffnet in header.php)
 * - Lädt WordPress Footer Scripts und schließt HTML
 *
 * Partner-Template: header.php
 * Lädt Template Part: template-parts/layout/footer-content.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package d64
 */
?>
	</div><!-- #content -->
	
	<!-- BMFSFJ Sponsor/Partner Logo Section -->
	<div class="border-y border-lila-500/30 max-w-5xl mx-auto mt-16 md:mt-20">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/images/BMFSFJ.jpg" 
		     class="max-w-sm w-full mt-2"
		     alt="<?php esc_attr_e('BMFSFJ Logo', 'd64'); ?>">
	</div>
	
	<?php 
	// Footer-Inhalt laden (Navigation, Newsletter, etc.)
	get_template_part( 'template-parts/layout/footer', 'content' ); 
	?>
</div><!-- #page -->

<?php 
// WordPress Footer Hook - Lädt Scripts, Admin Bar, etc.
wp_footer(); 
?>
</body>
</html>