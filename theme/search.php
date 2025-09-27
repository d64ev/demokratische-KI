<?php
/**
 * Template für Suchergebnis-Seiten
 *
 * Fallback-Template falls die JavaScript-powered Suche nicht funktioniert.
 * Zeigt Suchergebnisse kategorisiert nach Post-Types (Posts, Pages, Personen).
 * 
 * Funktionalität:
 * - Separate Abfragen für jeden Post-Type
 * - Unterschiedliche Layouts je Post-Type:
 *   * Posts: Grid mit post-tile Component
 *   * Personen: Grid mit person-tile Component  
 *   * Pages: Einfache Liste mit Links
 * 
 * Post-Types:
 * - 'post' → "Blogbeiträge" (Grid-Layout)
 * - 'page' → "Seiten" (Listen-Layout)
 * - 'personen' → "Personen" (Grid-Layout)
 * 
 * Template Parts:
 * - components/post-tile.php (für Posts)
 * - components/person-tile.php (für Personen)
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 * @package d64
 */

get_header();
?>
<section id="primary">
	<main id="main">
		<div class="max-w-[1200px] m-auto px-4 pt-4 pb-16 flex flex-col gap-4">
			
			<!-- Search Results Header -->
			<header class="page-header">
				<?php
				printf(
					/* translators: 1: search result title. 2: search term. */
					'<h1 class="page-title pb-4 text-base font-regular">%1$s <span class="font-semibold">%2$s</span></h1>',
					esc_html__('Suchbegriff:', 'd64'),
					esc_html(get_search_query())
				);
				?>
			</header><!-- .page-header -->
			
			<?php
			// Post-Types für Suche definieren
			$post_types = array('post', 'page', 'personen');
			
			foreach ($post_types as $type) {
				// Query-Args für aktuellen Post-Type
				$query_args = array(
					's' => get_search_query(),
					'post_type' => $type
				);
				
				// Überschrift für Post-Type bestimmen
				$headline = '';
				if ($type === 'post') {
					$headline = __('Blogbeiträge', 'd64');
				} else if ($type === 'page') {
					$headline = __('Seiten', 'd64');
				} else if ($type === 'personen') {
					$headline = __('Personen', 'd64');
				}
				
				// Suche für aktuellen Post-Type ausführen
				$search_query = new WP_Query($query_args);
				
				if ($search_query->have_posts()) :
					echo '<div>';
					echo '<h2 class="text-xl italic font-medium pb-4 md:pb-6">' . esc_html($headline) . '</h2>';
					
					// Layout-Container basierend auf Post-Type
					if ($type === 'personen' || $type === 'post') {
						// Grid-Layout für Posts und Personen
						?>
						<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-1">
						<?php
					} else if ($type === 'page') {
						// Listen-Layout für Pages
						?>
						<ul class="flex flex-col gap-2">
						<?php
					}
					
					// Loop durch Suchergebnisse
					while ($search_query->have_posts()) : 
						$search_query->the_post();
						
						if ($type === 'post') {
							// Posts mit post-tile Component
							get_template_part('template-parts/components/post-tile');
							
						} else if ($type === 'page') {
							// Pages als einfache Links
							?>
							<li>
								<a href="<?php the_permalink(); ?>"
								   class="text-2xl font-medium hover:text-d64blue-500 transition-colors">
									<?php the_title(); ?>
								</a>
							</li>
							<?php
							
						} else if ($type === 'personen') {
							// Personen mit person-tile Component
							get_template_part('template-parts/components/person-tile');
						}
						
					endwhile;
					
					// Layout-Container schließen
					if ($type === 'personen' || $type === 'post') {
						?>
						</div>
						<?php
					} else if ($type === 'page') {
						?>
						</ul>
						<?php
					}
					
					wp_reset_postdata(); // Loop zurücksetzen
					echo '</div>';
				endif;
			}
			
			// Fallback für "keine Ergebnisse" über Template Part
			if (!have_posts() && !isset($search_query)) {
				get_template_part('template-parts/content/content', 'none');
			}
			?>
		</div>
	</main><!-- #main -->
</section><!-- #primary -->
<?php
get_footer();