<?php
/**
 * Single Post Template
 *
 * Template für die Anzeige einzelner Blog-Posts und anderer Post-Types.
 * Lädt den content-single Template Part, der die eigentliche Darstellung übernimmt.
 *
 * Besonderheit: Für Post ID 20806 wird zusätzlich der KI-Wertekompass angezeigt.
 *
 * Verwendung:
 * - Automatisch von WordPress für alle einzelnen Posts verwendet
 * - URL-Schema: example.com/post-name/
 * - Unterstützt alle Post-Types (posts, custom post types)
 *
 * Template Parts:
 * - template-parts/content/content-single.php (Haupt-Layout)
 * - template-parts/components/section-header.php (KI-Wertekompass Header)
 *
 * Features:
 * - WordPress Loop mit Post-Daten
 * - Automatische Schema.org Integration durch Template Part
 * - Spezielle KI-Wertekompass Sektion für bestimmten Post
 * - Interaktive Slider-Funktionalität
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @package d64
 */

get_header();
?>

	<section id="primary">
		<main id="main">

			<?php
			/* WordPress Loop starten */
			while ( have_posts() ) :
				the_post();
				
				// Template Part für einzelne Posts laden
				get_template_part( 'template-parts/content/content', 'single' );

			// Loop beenden
			endwhile;
			?>

		</main><!-- #main -->
	</section><!-- #primary -->
	 
	<!-- Spezielle KI-Wertekompass Section für Post ID 20806 -->
	<?php if (get_the_ID() == 20806) : ?>
		<section id="ki-wertekompass" class="py-6 px-4 sm:pt-12 lg:pt-16 max-w-screen-md mx-auto">
			
			<!-- Section Header -->
			<?php 
			$argsHeader = [
				'tag' => 'h2',
				'text' => __('KI-Wertekompass', 'd64'),
			];
			get_template_part('template-parts/components/section-header', null, $argsHeader);
			?>
			
			<!-- Slider Container -->
			<div id="slider-container" class="max-w-5xl lg:mx-auto px-4 py-6 border border-lila-500 sm:px-6 sm:py-12">
				<div class="space-y-6">
					
					<!-- Slider 1: Sicherheit vs Offenheit -->
					<div class="slider-row grid grid-rows-[auto,1fr] grid-cols-2 sm:grid-rows-1 sm:grid-cols-[1fr,3fr,1fr] md:grid-cols-[1fr,2.5fr,1fr] sm:gap-4 sm:items-center">
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-1 flex sm:items-center sm:justify-self-end sm:text-end"><?php esc_html_e('Sicherheit', 'd64'); ?></span>
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-2 flex max-sm:justify-self-end sm:col-start-3 sm:items-center"><?php esc_html_e('Offenheit', 'd64'); ?></span>
						<div class="relative row-start-2 col-start-1 col-span-2 w-full max-sm:mt-2 sm:row-start-1 sm:col-start-2 sm:col-span-1">
							<div class="h-8 bg-lila-500/15 rounded-full">
								<div class="slider-thumb" style="left: 50%"></div>
							</div>
							<input type="range" class="absolute inset-0 w-full h-8 opacity-0 cursor-pointer" value="50">
						</div>
					</div>

					<!-- Slider 2: Konservativ vs Explorativ -->
					<div class="slider-row grid grid-rows-[auto,1fr] grid-cols-2 sm:grid-rows-1 sm:grid-cols-[1fr,3fr,1fr] md:grid-cols-[1fr,2.5fr,1fr] sm:gap-4 sm:items-center">
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-1 flex sm:items-center sm:justify-self-end sm:text-end"><?php esc_html_e('Konservativ', 'd64'); ?></span>
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-2 flex max-sm:justify-self-end sm:col-start-3 sm:items-center"><?php esc_html_e('Explorativ', 'd64'); ?></span>
						<div class="relative row-start-2 col-start-1 col-span-2 w-full max-sm:mt-2 sm:row-start-1 sm:col-start-2 sm:col-span-1">
							<div class="h-8 bg-lila-500/15 rounded-full">
								<div class="slider-thumb" style="left: 50%"></div>
							</div>
							<input type="range" class="absolute inset-0 w-full h-8 opacity-0 cursor-pointer" value="50">
						</div>
					</div>

					<!-- Slider 3: Präzision vs Imagination -->
					<div class="slider-row grid grid-rows-[auto,1fr] grid-cols-2 sm:grid-rows-1 sm:grid-cols-[1fr,3fr,1fr] md:grid-cols-[1fr,2.5fr,1fr] sm:gap-4 sm:items-center">
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-1 flex sm:items-center sm:justify-self-end sm:text-end"><?php esc_html_e('Präzision', 'd64'); ?></span>
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-2 flex max-sm:justify-self-end sm:col-start-3 sm:items-center"><?php esc_html_e('Imagination', 'd64'); ?></span>
						<div class="relative row-start-2 col-start-1 col-span-2 w-full max-sm:mt-2 sm:row-start-1 sm:col-start-2 sm:col-span-1">
							<div class="h-8 bg-lila-500/15 rounded-full">
								<div class="slider-thumb" style="left: 50%"></div>
							</div>
							<input type="range" class="absolute inset-0 w-full h-8 opacity-0 cursor-pointer" value="50">
						</div>
					</div>

					<!-- Slider 4: Menschliche Autorschaft vs KI-generierte Inhalte -->
					<div class="slider-row grid grid-rows-[auto,1fr] grid-cols-2 sm:grid-rows-1 sm:grid-cols-[1fr,3fr,1fr] md:grid-cols-[1fr,2.5fr,1fr] sm:gap-4 sm:items-center">
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-1 flex sm:items-center sm:justify-self-end sm:text-end"><?php esc_html_e('Menschliche Autor:innenschaft', 'd64'); ?></span>
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-2 flex max-sm:justify-self-end sm:col-start-3 sm:items-center"><?php esc_html_e('KI-generierte Inhalte', 'd64'); ?></span>
						<div class="relative row-start-2 col-start-1 col-span-2 w-full max-sm:mt-2 sm:row-start-1 sm:col-start-2 sm:col-span-1">
							<div class="h-8 bg-lila-500/15 rounded-full">
								<div class="slider-thumb" style="left: 50%"></div>
							</div>
							<input type="range" class="absolute inset-0 w-full h-8 opacity-0 cursor-pointer" value="50">
						</div>
					</div>

					<!-- Slider 5: KI-Minimalismus vs KI-Maximierung -->
					<div class="slider-row grid grid-rows-[auto,1fr] grid-cols-2 sm:grid-rows-1 sm:grid-cols-[1fr,3fr,1fr] md:grid-cols-[1fr,2.5fr,1fr] sm:gap-4 sm:items-center">
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-1 flex sm:items-center sm:justify-self-end sm:text-end"><?php esc_html_e('KI-Minimalismus', 'd64'); ?></span>
						<span class="text-gray-700 text-sm font-semibold row-start-1 col-start-2 flex max-sm:justify-self-end sm:col-start-3 sm:items-center"><?php esc_html_e('KI-Maximierung', 'd64'); ?></span>
						<div class="relative row-start-2 col-start-1 col-span-2 w-[100%+1rem] max-sm:mt-2 sm:row-start-1 sm:col-start-2 sm:col-span-1">
							<div class="h-8 bg-lila-500/15 rounded-full">
								<div class="slider-thumb" style="left: 50%"></div>
							</div>
							<input type="range" class="absolute inset-0 w-full h-8 opacity-0 cursor-pointer" value="50">
						</div>
					</div>
				</div>
			</div>

			<!-- Screenshot Download Button -->
			<div class="flex mx-4 lg:mx-auto justify-end max-w-5xl">
				<button id="downloadBtn" class="mt-6 px-4 py-2 bg-lila-500 text-white rounded hover:bg-lila-500/80 transition-colors">
					<?php esc_html_e('Screenshot generieren', 'd64'); ?>
				</button>
			</div>
		</section>
	<?php endif; ?>

<?php
get_footer();
?>

<style>
	.slider-thumb {
		position: absolute;
		height: 28px;
		width: 28px;
		background: #821f8b;
		border-radius: 50%;
		top: 2px;
		margin-left: -14px;
		cursor: pointer;
	}
</style>