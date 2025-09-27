<?php
/**
 * Template part für Ansprechpartner-Darstellung
 * 
 * Zeigt eine oder mehrere Ansprechpersonen in einem Container mit spezieller Styling.
 * 
 * Verwendung:
 * - Wird über get_template_part() mit args Array aufgerufen
 * - Erwartet Personen-Posts über $args['ansprechpartner']
 * - Optional: Farbkonfiguration über $args['main_color']
 * 
 * Features:
 * - Container Query (@container) für responsive Design
 * - "Chopped Corner" Design-Element (abgeschnittene Ecke)
 * - Social Media Links mit Icon-Mapping
 * - Responsive Layout (vertical → horizontal)
 * - Custom CSS Variablen für dynamische Farben
 * 
 * ACF Felder (pro Person):
 * - 'funktion' - Position/Rolle der Person
 * - 'desc' - Beschreibungstext
 * - 'links' - Array mit Social Media Links
 * 
 * Args:
 * - $args['ansprechpartner'] (array) - Array von Post Objects
 * - $args['main_color'] (string) - Hex-Farbcode (Default: #6B46C1)
 * - $args['is_desktop'] (bool) - Desktop-Flag (aktuell ungenutzt)
 * 
 * @package d64
 */

// Args von get_template_part() laden
$ansprechpartner = isset($args['ansprechpartner']) ? $args['ansprechpartner'] : null;
$main_color = isset($args['main_color']) ? $args['main_color'] : '#6B46C1';
$is_desktop = isset($args['is_desktop']) ? $args['is_desktop'] : false;

// Nur anzeigen wenn Ansprechpartner vorhanden
if ($ansprechpartner) :
?>
<section class="ansprechperson-section @container pt-6 pb-2 bg-transparent border-2 custom-border relative">
	<!-- Chopped Corner Design-Element -->
	<div class="chopped-corner absolute top-0 right-0 w-12 h-12 bg-white rotate-45 translate-x-[24.5px] -translate-y-[24.5px] border-b-2 custom-border"></div>
	
	<!-- Section Header -->
	<h2 class="text-lg lg:text-xl m-auto font-medium pl-4 custom-color">
		<?php esc_html_e('Ansprechperson', 'd64'); ?>
	</h2>
	
	<!-- Ansprechpartner Content -->
	<div class="ansprechperson-content">
		<?php 
		foreach ($ansprechpartner as $post) : 
			setup_postdata($post);
			
			// Social Media Links aus ACF laden
			$links = get_field('links');
			$social_media_fields = ['linkedin', 'email', 'twitter', 'facebook', 'instagram', 'website', 'mastodon'];
			
			// Prüfen ob Social Media Links vorhanden sind
			$has_social_media = false;
			foreach ($social_media_fields as $field) {
				if (!empty($links[$field])) {
					$has_social_media = true;
					break;
				}
			}
		?>
			<!-- Personen-Kachel -->
			<div class="person-tile bg-transparent rounded-xl p-4 flex flex-col @md:flex-row @md:gap-8">
				
				<!-- Profilbild -->
				<div class="person-tile__image overflow-hidden aspect-square mb-4">
					<?php the_post_thumbnail('medium-1-1', ['class' => '!rounded-none']); ?>
				</div>
				
				<!-- Personen-Informationen -->
				<div class="">
					<div class="person-tile__content">
						<!-- Name und Funktion -->
						<h3 class="person-tile__title pb-3 flex flex-col">
							<span class="text-2xl md:text-[28px] font-medium custom-color">
								<?php the_title(); ?>
							</span>
							<?php if (get_field('funktion')) : ?>
								<span class="text-lg md:text-xl pt-2 font-normal custom-color">
									<?php the_field('funktion'); ?>
								</span>
							<?php endif; ?>
						</h3>
						
						<!-- Beschreibung -->
						<div class="person-tile__excerpt text-base">
							<?php if (get_field('desc')) the_field('desc'); ?>
						</div>
					</div>
					
					<!-- Social Media Links -->
					<?php if ($has_social_media) : ?>
						<div class="person-tile__social mt-4 md:mt-8 flex gap-2">
							<?php
							// Social Media Icon-Mapping
							$social_media_icons = [
								'twitter' => 'twitter.svg',
								'facebook' => 'facebook.svg',
								'instagram' => 'instagram.svg',
								'website' => 'globe.svg',
								'linkedin' => 'linkedin.svg',
								'email' => 'mail.svg',
								'mastodon' => 'mdi_mastodon.svg',
							];
							
							// Social Media Links ausgeben
							foreach ($social_media_icons as $key => $icon) {
								if (!empty($links[$key])) {
									$url = $key === 'email' ? 'mailto:' . $links[$key] : $links[$key];
									$label = ucfirst($key) . ($key === 'email' ? ' senden' : ' öffnen');
									
									echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" class="w-5 h-5" aria-label="' . esc_attr($label) . '">';
									echo '<img src="' . esc_url(get_template_directory_uri() . "/assets/icons/$icon") . '" alt="' . esc_attr(ucfirst($key) . ' Icon') . '">';
									echo '</a>';
								}
							}
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php
wp_reset_postdata();
endif;
?>