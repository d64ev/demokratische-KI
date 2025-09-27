<?php
/**
 * Template Name: Custom Home Page
 * 
 * Startseiten-Template für CCDKI - Zentrum für digitale Kompetenz und Innovation  
 * Zeigt Hero-Bereich, Timeline, Events, Blog-Posts und KI-Wertekompass
 * 
 * Sections:
 * - Hero Section mit dynamischen Bildern und Links
 * - Timeline mit konfigurierbaren Kacheln
 * - Events Section (The Events Calendar Integration)
 * - Blog Section mit aktuellen Posts
 * - Ergebnisse Section mit Bild und Text
 * - KI-Wertekompass mit interaktiven Slidern
 * 
 * @package d64
 */

get_header();
?>
<section id="primary" class="max-w-screen overflow-x-hidden relative overflow-clip">
	<!-- Hintergrundbild - CCDKI Logo -->
	<img class="absolute right-0 hidden md:block lg:right-0 top-10 -z-10 h-[80vh] max-h-[900px] object-cover opacity-50" 
		 src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/background-logo.png'); ?>" 
		 alt="<?php esc_attr_e('CCDKI Home Background', 'd64'); ?>">
	
	<main id="main" class="front-page max-w-[1200px] m-auto">
		
		<!-- Hero Section -->
		<?php 
		$heroImage1 = get_field('bild-1');
		?>
		
		<!-- Mobile Hero Image -->
		<div class="relative md:hidden">
			<div class="bg-gradient-to-b from-transparent to-d64blue-50 sm:to-white w-full h-20 absolute left-0 right-0 bottom-0"></div>
			<?php if ($heroImage1) : ?>
				<img class="w-full max-h-[320px] object-cover aspect-video" 
					 src="<?php echo esc_url($heroImage1['url']); ?>" 
					 alt="<?php esc_attr_e('D64 Home Background', 'd64'); ?>">
			<?php else : ?>
				<img class="w-full max-h-[320px] object-cover aspect-video" 
					 src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/home-2.jpg'); ?>" 
					 alt="<?php esc_attr_e('D64 Home Background', 'd64'); ?>">
			<?php endif; ?>
		</div>
		
		<!-- Hero Content Section -->
		<div class="py-0 sm:py-6 sm:pt-0">
			<section class="pb-12 pt-8 sm:py-20 bg-d64blue-50 sm:bg-transparent" id="hero-content">
				<div class="flex flex-col gap-8 md:gap-10 px-4 max-w-[960px]">
					<!-- Hero Text Content -->
					<div class="prose prose-strong:text-d64blue-900 prose-img:my-0 lg:max-w-[960px] prose-h1:font-bold prose-h1:!text-[clamp(2rem,1.118rem+3.529vw,3.5rem)] prose-ul:list-inside">
						<?php the_content(); ?>
					</div>

					<!-- Hero Links (Button-ähnliche Links) -->
					<?php if( have_rows('hero_links') ): ?>
						<div class="flex flex-row flex-wrap gap-1">
						<?php while( have_rows('hero_links') ): the_row(); 
							$link = get_sub_field('hero_link');
							if (!$link) continue;
							
							$url = esc_url($link['url']);
							$title = esc_html($link['title']);
							$target = $link['target'] ? esc_attr($link['target']) : '_self';
							?>
							<a href="<?php echo $url; ?>" 
							   target="<?php echo $target; ?>"
							   class="flex px-4 py-[10px] text-base rounded-full font-medium max-w-content bg-lila-500 text-white hover:underline transition-colors">
								<?php echo $title; ?>
							</a>
						<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>

		<!-- Timeline Section -->
		<?php if (have_rows('tiles')): ?>
			<div class="pb-8 pt-10 lg:pb-24">
				<!-- Section Header -->
				<?php 
				$argsHeader = [
					'tag' => 'h2',
					'text' => __('Time Line', 'd64'),
				];
				get_template_part('template-parts/components/section-header', null, $argsHeader);
				?>
				
				<!-- Timeline Tiles - Horizontal Scroll Container -->
				<div class="gap-4 flex px-4 w-screen overflow-x-scroll no-scrollbar">
					<?php
					$index = 0; 
					while (have_rows('tiles')) : the_row();
						$label = get_sub_field('label');
						$datum = get_sub_field('datum');
						$icon = get_sub_field('icon');
						$link = get_sub_field('link');
						
						// CSS Klassen basierend auf Index
						$pointerClass = empty($link) ? 'pointer-events-none' : '';
						$bgColor = ($index === 1 || $index === 3) ? "bg-lila-500/20" : 
							(($index === 2 || $index === 4) ? "bg-lila-500" : "bg-lila-500/60");
						?>
						<a href="<?php echo esc_url($link); ?>" class="group flex flex-col gap-4 w-52 <?php echo esc_attr($pointerClass); ?>">
							<!-- Timeline Titel -->
							<h3 class="group-hover:underline text-balance font-bold text-d64blue-900"><?php echo esc_html($label); ?></h3>
							
							<!-- Timeline Icon Container mit Clip-Path -->
							<div class="w-52 h-28 group-hover:translate-x-1 transition-transform flex items-center justify-center [clip-path:polygon(0_0,90%_0,100%_50%,90%_100%,0_100%,10%_50%)] <?php echo esc_attr($bgColor); ?>">
								<?php if ($icon): ?>
									<div class="flex flex-col w-12 h-12">
										<img src="<?php echo esc_url($icon['url']); ?>" 
											 alt="<?php echo esc_attr($icon['alt']); ?>">
									</div>
								<?php endif; ?>
							</div>
							
							<!-- Timeline Datum -->
							<p class="font-medium text-lila-500"><?php echo esc_html($datum); ?></p>
						</a>
						<?php 
						$index++;
					endwhile; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Events Section -->
		<?php
		// Prüfung ob The Events Calendar aktiv ist
		if (function_exists('tribe_get_events')) {
			// Nächste 3 Events laden
			$events = tribe_get_events([
				'posts_per_page' => 3,
				'start_date' => 'now',
				'orderby' => ['event_date' => 'ASC']
			]);

			// Events Section nur anzeigen wenn Events vorhanden
			if (!empty($events)) {
				$argsHeader = [
					'tag' => 'h2',
					'text' => __('Veranstaltungen', 'd64'),
				];
				?>
				<section id="events-preview" class="pb-6 pt-10 px-4 sm:pb-6 md:pb-8 lg:py-10">
					<!-- Section Header -->
					<?php get_template_part('template-parts/components/section-header', null, $argsHeader); ?>
					
					<!-- Event Tiles Grid -->
					<div id="events-grid">
						<?php 
						global $post;
						foreach ($events as $post) {
							setup_postdata($post);
							get_template_part('template-parts/components/event-tile');
						}
						wp_reset_postdata();
						?>
					</div>
					
					<?php
					// Gesamtanzahl Events für Button-Bedingung prüfen
					$total_events = tribe_get_events([
						'posts_per_page' => -1,
						'start_date' => 'now',
						'fields' => 'ids'
					]);

					if (count($total_events) > 3) : ?>
						<div class="py-6 sm:py-10 md:py-14">
							<a href="<?php echo esc_url(get_site_url() . '/veranstaltungen'); ?>"
							   class="text-lg font-medium sm:m-auto flex items-center gap-1 max-w-max px-4 py-2 hover:bg-d64gray-50 hover:gap-2 transition-all">
								<span><?php esc_html_e('Alle Veranstaltungen anzeigen', 'd64'); ?></span>
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right" aria-hidden="true">
									<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
								</svg>
							</a>
						</div>
					<?php else : ?>
						<div class="pb-8 md:p-12"></div>
					<?php endif; ?>
				</section>
			<?php 
			}
		} 
		?>

		<!-- Blog Section -->
		<section id="blog-preview" class="py-6 px-4 sm:py-6 md:py-8 lg:py-10">
			<?php
			// Letzte 3 Posts laden
			$lastposts = get_posts([
				'posts_per_page' => 3,
			]);
			wp_reset_postdata();

			// Section Header
			$argsHeader = [
				'tag' => 'h2',
				'text' => __('Aktuelles', 'd64'),
			];
			get_template_part('template-parts/components/section-header', null, $argsHeader);
			?>

			<!-- Posts Grid -->
			<div class="grid gap-6 md:gap-4 md:grid-cols-3">
				<?php 
				foreach ($lastposts as $post) : 
					setup_postdata($post);
					get_template_part('template-parts/components/post-tile');
				endforeach; 
				wp_reset_postdata(); 
				?>
			</div>
			
			<!-- "Alle Posts" Button -->
			<div class="py-6 sm:py-10 md:py-14">
				<a href="<?php echo esc_url(get_site_url() . '/aktuelles'); ?>"
				   class="text-lg font-medium sm:m-auto flex items-center gap-1 max-w-max px-4 py-2 hover:bg-d64gray-50 hover:gap-2 transition-all">
					<span><?php esc_html_e('Alle Beiträge anzeigen', 'd64'); ?></span>
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right" aria-hidden="true">
						<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
					</svg>
				</a>
			</div>
		</section>

		<!-- Ergebnisse Section -->
		<section id="results" class="py-6 px-4 sm:py-6 md:py-8 lg:py-10 mb-8">
			<?php 
			$argsHeader = [
				'tag' => 'h2',
				'text' => __('Ergebnisse', 'd64'),
			];
			get_template_part('template-parts/components/section-header', null, $argsHeader);
			?>
			
			<!-- Ergebnisse Content - Bild und Text -->
			<div class="flex flex-col gap-4 lg:grid lg:gap-8 lg:grid-cols-2">
				<?php $ergebnisseBild = get_field('ergebnisse_bild'); ?>
				<?php if ($ergebnisseBild) : ?>
					<img src="<?php echo esc_url($ergebnisseBild['url']); ?>" 
						 class="max-w-screen-sm w-full" 
						 alt="<?php echo esc_attr($ergebnisseBild['alt']); ?>">
				<?php endif; ?>
				
				<?php if (get_field('ergebnisse_text')) : ?>
					<div class="max-w-screen-md prose">
						<?php the_field('ergebnisse_text'); ?>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<!-- KI-Wertekompass Section -->
		<section id="ki-wertekompass" class="py-6 px-4 sm:py-6 md:py-8 lg:py-10">
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
	</main>
</section>

<?php get_footer(); ?>

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