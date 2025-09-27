<?php
/**
 * Template part für Header Content
 * 
 * Standard Header für alle Seiten mit Navigation und Suche.
 * 
 * Features:
 * - CCDKI Branding mit eigenem Logo
 * - Responsive Navigation (Mobile + Desktop)
 * - JavaScript-powered Suche mit Overlay
 * - Fixed Header mit Backdrop Blur
 * - Sub-Navigation Support für Mobile
 * 
 * Template Parts:
 * - components/mobile-nav-button.php (Mobile Menu Button)
 * - components/desktop-navigation.php (Desktop Navigation)
 * - components/search-bar.php (Suchleiste)
 * - components/nav-icon-bar.php (Desktop Icon Bar)
 * - components/mobile-navigation.php (Mobile Navigation)
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package d64
 */
?>
<header id="masthead" class="relative pb-[86px] lg:pb-[95px]">
	<div id="header-content" data-expanded="false" class="fixed top-0 left-0 right-0 z-20 bg-white bg-opacity-80 backdrop-blur-sm">
		
		<!-- Haupt-Header mit Logo und Navigation -->
		<div id="header-header" class="inner w-full transition-color bg-transparent flex justify-between items-center px-4 py-4 max-w-[1200px] m-auto relative z-50">
			
			<!-- Logo - CCDKI -->
			<div id="main-logo" class="logo z-50">
				<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/ccdki-logo.png'); ?>" 
					     alt="<?php esc_attr_e('Logo CCDKI', 'd64'); ?>" 
					     class="w-40 md:w-48" 
					     width="416" 
					     height="130">
				</a>
			</div>
			
			<!-- Zurück-Button für Mobile Sub-Navigation (versteckt per Default) -->
			<div id="sub-nav-btn-container" class="hidden absolute h-[54px] w-24 bg-d64gray-50 left-4 top-4 z-[100]">
				<button id="submenu-nav-button" 
				        class="rounded-full text-d64blue-500 w-max"
				        aria-label="<?php esc_attr_e('Zurück zur Hauptnavigation', 'd64'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left pointer-events-none" aria-hidden="true">
						<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>
					</svg>
				</button>
			</div>
			
			<!-- Mobile Navigation Button -->
			<div class="lg:hidden">
				<?php get_template_part('template-parts/components/mobile-nav-button'); ?>
			</div>
			
			<!-- Desktop Navigation und Suche -->
			<div class="z-10 hidden lg:block relative">
				<?php get_template_part('template-parts/components/desktop-navigation'); ?>
				<?php get_template_part('template-parts/components/search-bar'); ?>
				
				<!-- Search Results Overlay -->
				<div id="search-result-overlay" class="hidden max-h-[80vh] overflow-y-scroll top-20 border bg-white p-2 pt-4 rounded-b-lg w-auto z-10 shadow">
					<div class="px-2 m-auto">
						<div id="search-results" class="space-y-4 pt-4">
							
							<!-- Themen/Posts Suchergebnisse -->
							<div class="">
								<h3 class="font-medium italic text-lg pb-2">
									<?php esc_html_e('Themen', 'd64'); ?>
								</h3>
								<div id="post-results" class="pl-2 results-section"></div>
								<div id="post-pagination" class="mt-2 flex gap-1"></div>
							</div>
							
							<!-- Seiten Suchergebnisse -->
							<div class="border-d64blue-900 border-t pt-2">
								<h3 class="font-medium italic text-lg pb-2">
									<?php esc_html_e('Seiten', 'd64'); ?>
								</h3>
								<div id="page-results" class="pl-2 results-section"></div>
								<div id="page-pagination" class="mt-2 flex gap-1"></div>
							</div>
							
							<!-- Keine Ergebnisse Meldung -->
							<div id="no-results" class="hidden pb-1 -translate-y-2">
								<p><?php esc_html_e('Keine Ergebnisse', 'd64'); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Desktop Icon Bar -->
			<div class="hidden lg:block">
				<?php get_template_part('template-parts/components/nav-icon-bar'); ?>
			</div>
		</div>
		
		<!-- Mobile Navigation (versteckt per Default) -->
		<?php get_template_part('template-parts/components/mobile-navigation'); ?>
	</div>
</header><!-- #masthead -->