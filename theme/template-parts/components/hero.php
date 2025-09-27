<?php
/**
 * Hero Section Component
 *
 * Flexible Hero-Section mit Titel, Content und Call-to-Action Buttons.
 * Unterstützt verschiedene Layouts für Homepage vs andere Seiten.
 * 
 * Features:
 * - Responsive Layout (Mobile vs Desktop)
 * - Conditional Centering für bestimmte Seiten
 * - ACF Hero-Links mit einheitlichen Button-Farben
 * - Spezielle Icon-Bar für Kontakt-Seite
 * - Homepage-spezifisches Layout ohne Titel
 * 
 * ACF Felder:
 * - 'hero_links' (Repeater)
 *   - 'hero_link' (Link) - URL, Titel, Target
 * 
 * Seiten-spezifische Layouts:
 * - Homepage: Kein H1-Titel, spezielle Container-Breite
 * - Kontakt: Zusätzliche Icon-Navigation
 * - Presse/Impressum/etc.: Links-ausgerichteter Content
 * - Standard: Zentrierter Content mit Titel
 * 
 * Dependencies:
 * - ACF Plugin (für hero_links)
 * - template-parts/components/nav-icon-bar.php (für Kontakt-Seite)
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package d64
 */

// Page-Kontext und Layout-Flags bestimmen
$contentNotCentered = false;
if (is_page('Presse') || is_page('Impressum') || is_page('Datenschutz') || is_page('Barrierefreiheit') || is_page('Datenschutzerklärung') || is_front_page()) {
	$contentNotCentered = true;
}
?>

<!-- Hero Section -->
<section class="pb-12 pt-8 sm:py-20 bg-d64blue-50 sm:bg-transparent" 
         id="hero-content" 
         role="banner"
         aria-label="<?php esc_attr_e('Hero-Bereich', 'd64'); ?>">
	
	<div class="flex flex-col gap-8 md:gap-10 px-4 max-w-3xl <?php if (!is_front_page()) echo 'm-auto'; ?>">
		
		<!-- Page Title (außer Homepage) -->
		<?php if (!is_front_page()) : ?>
			<h1 class="text-xl md:text-2xl italic font-medium <?php if (!$contentNotCentered) echo 'sm:text-center align-middle'; ?>">
				<?php the_title(); ?>
			</h1>
		<?php endif; ?>

		<!-- Main Content -->
		<div class="prose prose-strong:text-d64blue-900 prose-h1:font-bold prose-ul:list-inside <?php if (!$contentNotCentered) echo 'sm:text-center'; ?>">
			<?php the_content(); ?>
		</div>

		<!-- Contact Page Icon Navigation -->
		<?php if (is_page('Kontakt')) : ?>
			<div class="flex sm:justify-center" role="navigation" aria-label="<?php esc_attr_e('Social Media Links', 'd64'); ?>">
				<?php get_template_part('template-parts/components/nav-icon-bar'); ?>
			</div>
		<?php endif; ?>

		<!-- Hero Action Buttons (ACF) -->
		<?php if (have_rows('hero_links')) : ?>
			<div class="flex flex-row flex-wrap gap-2 <?php if (!$contentNotCentered) echo 'sm:items-center sm:justify-center'; ?>" 
			     role="group" 
			     aria-label="<?php esc_attr_e('Haupt-Aktionen', 'd64'); ?>">
				<?php 
				while (have_rows('hero_links')) : 
					the_row();
					
					// ACF Link-Feld sicher laden
					$link = get_sub_field('hero_link');
					
					// Validation: Link muss existieren
					if (!$link || empty($link['url']) || empty($link['title'])) {
						continue;
					}
					
					// Link-Daten sicher extrahieren
					$url = esc_url($link['url']);
					$title = esc_html($link['title']);
					$target = !empty($link['target']) ? esc_attr($link['target']) : '_self';
					
					// Button-spezifische ARIA-Attribute
					$aria_label = sprintf(
						__('%s (öffnet %s)', 'd64'), 
						$title,
						$target === '_blank' ? __('in neuem Fenster', 'd64') : __('in aktuellem Fenster', 'd64')
					);
				?>
					<a href="<?php echo $url; ?>"
					   target="<?php echo $target; ?>"
					   <?php echo $target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
					   class="flex px-4 py-[10px] text-base rounded-full font-medium max-w-content bg-d64blue-900 text-white hover:text-d64blue-900 hover:bg-d64blue-500 transition-colors"
					   aria-label="<?php echo esc_attr($aria_label); ?>">
						<?php echo $title; ?>
					</a>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
		
	</div>
</section>