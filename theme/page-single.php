<?php
/**
 * Page Single Template
 *
 * Custom Page Template das das Single-Post-Layout für Seiten wiederverwendet.
 * Erstellt für Kunden-Anforderung: Blog-Template-Design auch für spezielle Seiten.
 *
 * Verwendung:
 * - Seite erstellen und "Page Single" als Template auswählen
 * - Seite wird mit dem gleichen Layout wie Blog-Posts dargestellt
 * - Nutzt content-single.php Template Part für konsistentes Design
 *
 * Features:
 * - Gleiche Darstellung wie Blog-Posts (Hero, Meta, Content)
 * - Responsive Layout und Typography
 * - Share-Buttons und Kommentare (falls aktiviert)
 * - SEO-optimierte Struktur
 *
 * Template Part: template-parts/content/content-single.php
 * Basis: single.php Layout-Struktur
 *
 * @package d64
 */
/* Template Name: Page Single */
get_header();
?>
	<section id="primary">
		<main id="main">
			<?php
			// WordPress Loop starten
			while ( have_posts() ) :
				the_post();
				
				// Single-Post Template Part laden (wiederverwendet für Seiten)
				get_template_part( 'template-parts/content/content', 'single' );
				
			// Loop beenden
			endwhile;
			?>
		</main><!-- #main -->
	</section><!-- #primary -->
<?php
get_footer();