<?php
/**
 * Header Template
 *
 * Dieses Template zeigt das `head` Element und alles bis zum
 * `#content` Element an. Stellt die HTML-Grundstruktur bereit
 * und lädt die Header-Navigation.
 *
 * Struktur:
 * - HTML5 Doctype und Language Attributes
 * - Meta Tags für Charset und Viewport
 * - WordPress Head Hook für Styles/Scripts
 * - Body Tag mit WordPress Classes
 * - Skip-to-Content Link für Accessibility
 * - Header Navigation über Template Part
 * - Öffnet #content Container (geschlossen in footer.php)
 *
 * Partner-Template: footer.php
 * Lädt Template Part: template-parts/layout/header-content.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package d64
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- Tailwind Grid Helper - Stellt CSS Grid Klassen bereit -->
	<div class="grid grid-cols-5"></div>
	
	<?php wp_body_open(); ?>
	
	<div id="page" class="relative">
		<!-- Skip-to-Content Link für Screen Reader -->
		<a href="#content" class="sr-only"><?php esc_html_e( 'Skip to content', 'd64' ); ?></a>
		
		<!-- Header Navigation Container -->
		<div class="z-20">
			<?php get_template_part( 'template-parts/layout/header', 'content' ); ?>
		</div>
		
		<!-- Haupt-Content Container - wird in footer.php geschlossen -->
		<div id="content" class="z-10">