<?php
/**
 * Presse Page Template
 *
 * Spezielle Seiten-Template für Presse-/Medien-Informationen.
 * Kombiniert Hero-Section, Ansprechpartner und Tab-basierte Inhalte.
 *
 * Verwendung:
 * - Seite erstellen und "Presse Page" als Template auswählen
 * - Hero-Section über ACF konfigurieren
 * - Ansprechpartner über ACF Relationship Field 'ansprechpartner' auswählen
 * - Tab-Inhalte über ACF Repeater Field 'tab' erstellen
 *
 * Layout-Struktur:
 * - Desktop: 2-spaltig (Content + Sidebar mit Ansprechpartner)
 * - Mobile: Gestapelt (Hero → Ansprechpartner → Tabs)
 * - Ansprechpartner erscheint doppelt: Mobile oben, Desktop in Sidebar
 *
 * ACF Felder:
 * - 'ansprechpartner' (Relationship) - Verknüpfung zu Personen-Posts
 * - 'tab' (Repeater) - Tab-basierte Inhalte mit Label + Content
 *
 * Template Parts:
 * - components/hero.php (Hero Section)
 * - components/person-tile.php (Ansprechpartner)
 * - components/tabs.php (Tab-Navigation und Inhalte)
 *
 * @package d64
 */
/* Template Name: Presse Page */
get_header();

// Ansprechpartner aus ACF Relationship Field laden
$ansprechpartner = get_field('ansprechpartner');
?>
<section id="primary">
	<main id="main" class="max-w-[1200px] m-auto pb-20">
		<!-- Grid Container: Content (links) + Sidebar (rechts) -->
		<div class="lg:grid lg:grid-cols-[1fr_352px] gap-4 lg:px-4 xl:px-0">
			
			<!-- Haupt-Content Spalte -->
			<div class="">
				<!-- Hero Section -->
				<div class="">
					<?php get_template_part('template-parts/components/hero'); ?>
				</div>
				
				<!-- Ansprechpartner Section - Mobile (nur auf kleinen Bildschirmen sichtbar) -->
				<?php if ($ansprechpartner) : ?>
					<section class="lg:hidden block pb-10 pt-10 sm:pt-0 lg:max-w-[320px] m-auto max-w-3xl px-4">
						<h2 class="text-lg sm:text-xl italic m-auto font-medium pb-8">
							<?php esc_html_e('Ansprechperson', 'd64'); ?>
						</h2>
						<div>
							<?php 
							foreach ($ansprechpartner as $post) : 
								setup_postdata($post);
							?>
								<?php get_template_part('template-parts/components/person-tile'); ?>
							<?php 
							endforeach; 
							wp_reset_postdata(); 
							?>
						</div>
					</section>
				<?php endif; ?>
				
				<!-- Tabs Section -->
				<div class="bg-transparent lg:bg-d64blue-50 lg:rounded-xl">
					<?php if (get_field('tab')) : ?>
						<?php get_template_part('template-parts/components/tabs'); ?>
					<?php endif; ?>
				</div>
			</div>
			
			<!-- Sidebar Spalte - Desktop Ansprechpartner -->
			<?php if ($ansprechpartner) : ?>
				<div class="">
					<section class="hidden lg:block mt-10 pt-4 rounded-xl sm:mt-20 sm:max-w-[320px] lg:bg-d64blue-50">
						<h2 class="text-lg sm:text-xl italic m-auto font-medium pl-4">
							<?php esc_html_e('Ansprechperson', 'd64'); ?>
						</h2>
						<div>
							<?php 
							foreach ($ansprechpartner as $post) : 
								setup_postdata($post);
							?>
								<?php get_template_part('template-parts/components/person-tile'); ?>
							<?php 
							endforeach; 
							wp_reset_postdata(); 
							?>
						</div>
					</section>
				</div>
			<?php endif; ?>
		</div>
	</main>
</section>
<?php get_footer(); ?>