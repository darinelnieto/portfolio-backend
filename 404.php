<?php
/**
 * 
 * Default 404.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$background = get_field('background_image', 'option');
?>
<main id="ditto_404_error">
	<img src="<?= $background['url']; ?>" alt="<?= $background['title']; ?>" width="<?= $background['width']; ?>" height="<?= $background['height']; ?>" class="background-image" />
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="text-contain">
					<h1>404</h1>
					<p><?= get_field('text_after_title', 'option'); ?></p>
					<a href="<?= home_url(); ?>" class="cta-return-home">
						<span class="text">
							<?= get_field('cta_text', 'option'); ?>
						</span>
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 8H15M15 8L8 1M15 8L8 15" stroke="#002D74" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>