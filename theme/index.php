<?php
/**
 * Haupt-Template Datei
 *
 * Das generischste Template in einem WordPress Theme und eine der zwei
 * erforderlichen Dateien für ein Theme (die andere ist style.css).
 * Wird verwendet um eine Seite anzuzeigen, wenn nichts spezifischeres passt.
 * Z.B. stellt es die Startseite zusammen, wenn keine `home.php` existiert.
 *
 * Template Hierarchy:
 * - Fallback für alle Seiten ohne spezifisches Template
 * - Zeigt Posts-Loop oder "Keine Inhalte" Meldung
 * - Lädt Template Parts für modularen Aufbau
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package d64
 */
get_header();
?>
	<section id="primary">
		<main id="main">
			<?php
			if ( have_posts() ) {
				// Blog-Startseite Header (falls nicht Front Page)
				if ( is_home() && ! is_front_page() ) : ?>
					<header class="entry-header">
						<h1 class="entry-title"><?php single_post_title(); ?></h1>
					</header><!-- .entry-header -->
				<?php
				endif;
				
				// Posts Loop - lädt Template Parts für jeden Post
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content/content' );
				}
				
				// Posts Navigation (auskommentiert)
				// d64_the_posts_navigation();
				
			} else {
				// Keine Posts gefunden - lädt "content-none" Template Part
				get_template_part( 'template-parts/content/content', 'none' );
			}
			?>
		</main><!-- #main -->
	</section><!-- #primary -->
<?php
get_footer();