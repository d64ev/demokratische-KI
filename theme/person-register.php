<?php
/**
 * Person Register Page Template
 *
 * Zeigt eine Übersichtsseite mit ausgewählten Personen an.
 * Personen werden über ACF Relationship Field 'personen' ausgewählt.
 *
 * Verwendung:
 * - Seite erstellen und "Person Register Page" als Template auswählen
 * - Hero-Section über ACF konfigurieren (optional)
 * - Personen über ACF Relationship Field 'personen' auswählen
 * - Überschrift über ACF 'uberschrift' anpassen (optional)
 *
 * Features:
 * - Hero Section mit ACF-Inhalten
 * - Grid-Layout für Personen-Kacheln (responsive)
 * - Flexible Überschrift (ACF oder Fallback)
 * - Wiederverwendbare Template Parts
 *
 * Template Parts:
 * - components/hero.php (Hero Section)
 * - components/section-header.php (Überschriften)
 * - components/person-tile.php (Personen-Kacheln)
 *
 * @package d64
 */
/* Template Name: Person Register Page */
get_header();
?>
<section id="primary">
	<main id="main" class="max-w-[1200px] m-auto">
		<!-- Hero Section -->
		<?php get_template_part('template-parts/components/hero'); ?>
		
		<!-- Personen Section -->
		<?php
		// Überschrift aus ACF oder Fallback
		$uberschrift = get_field('uberschrift');
		if ($uberschrift) {
			$headline = $uberschrift;
		} else {
			$headline = __('Personen', 'd64');
		}
		
		// Personen aus ACF Relationship Field laden
		$personen = get_field('personen');
		wp_reset_postdata();
		
		// Section Header Argumente
		$argsHeader = [
			'tag' => 'h2',
			'text' => $headline,
		];
		?>
		
		<?php if ($personen): ?>
			<section id="personen-preview" class="py-10 px-4">
				<!-- Section Header -->
				<?php get_template_part('template-parts/components/section-header', null, $argsHeader); ?>
				
				<!-- Personen Grid -->
				<div class="grid gap-4 md:grid-cols-3">
					<?php 
					foreach ($personen as $post) : 
						setup_postdata($post);
					?>
						<!-- Personen-Kachel Container -->
						<div class="">
							<?php get_template_part('template-parts/components/person-tile'); ?>
						</div>
					<?php 
					endforeach; 
					wp_reset_postdata(); 
					?>
				</div>
			</section>
		<?php endif; ?>
		<!-- End Personen Section -->
	</main>
</section>
<?php get_footer(); ?>