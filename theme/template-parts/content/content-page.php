<?php
/**
 * Template Part für Page-Anzeige
 *
 * Vereinfachtes Page-Template mit reduzierten Komponenten.
 * Lädt nur die grundlegenden Template Parts für alle Seiten.
 * 
 * Verwendung:
 * - Automatisch für alle WordPress Pages (außer Custom Page Templates)
 * - Minimaler Aufbau mit Hero, Timeline und Scroll-Cols
 * 
 * Features:
 * - Hero Section mit Titel und Content
 * - Chronik/Timeline (conditional via ACF)
 * - Scroll Columns für zusätzliche Inhalte
 * - Gremien Section für spezielle Seiten
 * 
 * ACF-Felder (conditional):
 * - 'timeline' (Repeater) - Chronik-Einträge für Timeline-Component
 * - Hero-Felder (im hero.php Component definiert)
 * - Scroll-Cols-Felder (im scroll-cols.php Component definiert)
 * 
 * Template Parts:
 * - components/hero.php - Hero-Section mit Titel/Content
 * - components/timeline.php - Chronik mit ACF Repeater (conditional)
 * - components/scroll-cols.php - Horizontal scrollbare Spalten
 * - components/gremien.php - Gremien & Bündnisse Übersicht (conditional)
 * 
 * Dependencies:
 * - ACF Plugin (für Timeline und andere conditional fields)
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package d64
 */

// Page-Daten für bessere Performance einmal laden
$page_id = get_the_ID();
$page_slug = get_post_field('post_name', $page_id);

// Page-spezifische Checks
$is_gremien_page = ($page_slug === 'gremien' || is_page('Gremien') || is_page('Gremien & Bündnisse'));

// ACF Timeline-Daten prüfen
$has_timeline = have_rows('timeline');
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="main">

	<!-- Hero Section (Standard für alle Pages) -->
	<?php 
	get_template_part('template-parts/components/hero', null, [
		'context' => 'page',
		'page_id' => $page_id
	]); 
	?>

	<!-- Timeline/Chronik Section (conditional via ACF) -->
	<?php if ($has_timeline) : ?>
		<section class="timeline-section" aria-labelledby="timeline-heading">
			<!-- Hidden heading for screen readers -->
			<h2 id="timeline-heading" class="sr-only">
				<?php esc_html_e('Chronik', 'd64'); ?>
			</h2>
			<?php 
			get_template_part('template-parts/components/timeline', null, [
				'context' => 'page-chronik',
				'page_id' => $page_id
			]); 
			?>
		</section>
	<?php endif; ?>

	<!-- Scroll Columns Section (Standard für alle Pages) -->
	<?php 
	get_template_part('template-parts/components/scroll-cols', null, [
		'context' => 'page',
		'page_id' => $page_id
	]); 
	?>

	<!-- Gremien Section (nur auf Gremien-Seiten) -->
	<?php if ($is_gremien_page) : ?>
		<section class="gremien-section" aria-labelledby="gremien-heading">
			<!-- Hidden heading for screen readers -->
			<h2 id="gremien-heading" class="sr-only">
				<?php esc_html_e('Gremien und Bündnisse', 'd64'); ?>
			</h2>
			<?php 
			get_template_part('template-parts/components/gremien', null, [
				'context' => 'main-page',
				'page_id' => $page_id
			]); 
			?>
		</section>
	<?php endif; ?>

</div><!-- #post-<?php the_ID(); ?> -->