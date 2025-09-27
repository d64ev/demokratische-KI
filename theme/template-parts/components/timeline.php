<?php
/**
 * Template Part für Timeline-Darstellung
 *
 * Vertikale Timeline mit ACF Repeater-Feldern für chronologische Inhalte.
 * Unterstützt Bilder, Videos, Text und Datum-Informationen.
 * 
 * ACF Felder (Repeater 'timeline'):
 * - 'image' (Image) - Timeline-Bild
 * - 'video' (File) - Video-Upload (MP4)
 * - 'headline' (Text) - Überschrift für Timeline-Item
 * - 'absatz' (Wysiwyg) - Beschreibungstext
 * - 'jahr' (Text) - Jahr-Angabe
 * - 'monat' (Text) - Monat-Angabe
 * 
 * Features:
 * - Vertikale Timeline mit Border-Line
 * - Video-Support (MP4 mit HTML5 Player)
 * - Bildbeschriftungen aus Image-Description
 * - Clip-Path Styling für moderne Optik
 * - Responsive Design
 * - Lila Farbschema für CCDKI Branding
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package d64
 */
?>

<div class="timeline max-w-[640px] m-auto py-10 px-4 sm:px-0">
	<!-- Timeline Container mit vertikaler Linie -->
	<div class="border-dashed border-l border-lila-500/20 min-h-40 flex flex-col gap-20">
		
		<?php while (have_rows('timeline')) : the_row();
			// ACF Subfields für Timeline-Item laden
			$image = get_sub_field('image');
			$headline = get_sub_field('headline');
			$paragraph = get_sub_field('absatz');
			$jahr = get_sub_field('jahr');
			$monat = get_sub_field('monat');
			
			// Video-Verarbeitung
			$video = false;
			$videoFile = get_sub_field('video');
			$video_url = '';
			$video_mime_type = '';
			
			if ($videoFile && !empty($videoFile)) {
				$video_url = $videoFile['url'];
				$video_mime_type = $videoFile['mime_type'];
				
				// Nur MP4 Videos unterstützen
				if ($video_mime_type === 'video/mp4') {
					$video = true;
				}
			}
		?>
			<!-- Timeline Item -->
			<div class="timeline-item border-l border-lila-500 flex flex-row gap-8 md:gap-10 -translate-x-[1px]">
				
				<!-- Datum-Bereich -->
				<div class="date flex flex-col pl-4 min-w-[60px]">
					<?php if ($monat) : ?>
						<span class="text-xs font-medium text-lila-500/80">
							<?php echo esc_html($monat); ?>
						</span>
					<?php endif; ?>
					<?php if ($jahr) : ?>
						<span class="font-medium text-lila-500">
							<?php echo esc_html($jahr); ?>
						</span>
					<?php endif; ?>
				</div>
				
				<!-- Content-Bereich -->
				<div class="flex flex-col gap-4">
					
					<!-- Timeline-Bild (falls vorhanden und kein Video) -->
					<?php if ($image && !$video) :
						// Image-Variablen extrahieren
						$url = $image['url'];
						$title = $image['title'];
						$alt = $image['alt'];
						$caption = $image['caption'];
						$description = $image['description'];
						$size = 'medium-16-9';
						$medium = $image['sizes'][$size];
					?>
						<div class="[clip-path:polygon(0_0,95%_0,100%_10%,100%_100%,0_100%)] overflow-hidden relative">
							<img src="<?php echo esc_url($medium); ?>" 
								 alt="<?php echo esc_attr($alt); ?>"
								 title="<?php echo esc_attr($title); ?>">
							
							<!-- Bildbeschriftung falls vorhanden -->
							<?php if ($description) : ?>
								<div class="absolute bottom-0 right-0 max-w-max rounded-tl bg-slate-300 bg-opacity-60 text-slate-800 text-xs font-medium text-end px-1 py-[1px]">
									<?php echo esc_html($description); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					
					<!-- Timeline-Video (falls vorhanden) -->
					<?php if ($video && $video_url) : ?>
						<div class="aspect-video relative rounded-xl overflow-hidden">
							<video class="w-full h-full object-cover" 
								   controls 
								   preload="metadata"
								   aria-label="<?php esc_attr_e('Timeline Video', 'd64'); ?>">
								<source src="<?php echo esc_url($video_url); ?>" 
										type="<?php echo esc_attr($video_mime_type); ?>">
								<?php esc_html_e('Ihr Browser unterstützt das Video-Element nicht.', 'd64'); ?>
							</video>
						</div>
					<?php endif; ?>
					
					<!-- Timeline-Text Content -->
					<div class="flex flex-col gap-2 md:gap-4">
						<?php if ($headline) : ?>
							<h2 class="font-bold text-xl sm:text-2xl md:text-2xl">
								<?php echo esc_html($headline); ?>
							</h2>
						<?php endif; ?>
						
						<?php if ($paragraph) : ?>
							<div class="prose prose-p:mb-3">
								<?php echo wp_kses_post($paragraph); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
</div>