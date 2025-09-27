<?php
/**
 * Template part für Footer Content
 *
 * Vereinfachter Footer mit Navigation und Logo.
 * 
 * Features:
 * - ACF Options für Footer Links
 * - Responsive Layout (mobil: gestapelt, desktop: horizontal)
 * - CCDKI Branding mit eigenem Logo
 * 
 * Layout-Struktur:
 * - Links: Footer Navigation Links
 * - Rechts: CCDKI Logo
 * - Hellblaues Farbschema (d64blue-100/800)
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package d64
 */
?>
<footer id="colophon" class="bg-d64blue-100 sm:mt-20 lg:mt-28">
	<div class="py-10 max-w-[1200px] m-auto flex flex-col-reverse px-4 md:flex md:flex-row md:justify-between gap-12 md:gap-8">
		
		<!-- Linke Spalte: Navigation + Logo -->
		<div class="flex flex-col md:flex-col-reverse gap-12 md:gap-48">
			
			<!-- Footer Navigation Links -->
			<?php
			$footer_navigation_items = get_field('footer_links', 'option');
			if ($footer_navigation_items): ?>
				<nav class="text-d64blue-800 text-sm font-medium" role="navigation" aria-label="<?php esc_attr_e('Footer Navigation', 'd64'); ?>">
					<ul class="style-none flex flex-col md:flex-row gap-2 md:gap-4">
						<?php foreach ($footer_navigation_items as $item) : ?>
							<li>
								<a href="<?php echo esc_url($item['link']['url']); ?>" 
								   <?php if (!empty($item['link']['target']) && $item['link']['target'] === '_blank') : ?>
								   	target="_blank" 
								   	rel="noopener noreferrer"
								   	aria-label="<?php echo esc_attr($item['link']['title'] . ' ' . __('(öffnet in neuem Tab)', 'd64')); ?>"
								   <?php endif; ?>
								   class="md:hover:bg-d64blue-50 md:hover:text-d64blue-900 md:py-1 md:px-2 md:rounded-lg transition-colors">
									<?php echo esc_html($item['link']['title']); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>
			
			<!-- Footer Logo - CCDKI -->
			<div id="footer-logo" class="logo z-50">
				<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="max-w-content">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/ccdki-logo.png'); ?>" 
					     alt="<?php esc_attr_e('CCDKI Logo', 'd64'); ?>" 
					     class="w-32 md:w-48" 
					     width="600" 
					     height="338">
				</a>
			</div>
		</div>
		
		<!-- Rechte Spalte: Leer (für zukünftige Erweiterungen) -->
		<div class="block max-w-sm">
			<!-- Platzhalter für zukünftige Inhalte -->
		</div>
	</div>
</footer><!-- #colophon -->