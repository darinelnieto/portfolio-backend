<?php
/**
 * 
 * Default search page.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<main id="ditto-search">
	<section>
		<div class="container">
            <h1><?php if(get_bloginfo("language") == "en-US"): ?>Search: <?php else: ?>Busqueda: <?php endif; ?><?= get_search_query(); ?></h1>
            <div class="row justify-content-center">
                <?php if (have_posts()): ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-12 mb-5">
                            <div class="row align-items-center">
                                <?php if(get_the_post_thumbnail_url()): ?>
                                    <div class="col-12 col-md-5 mb-4 mb-md-0">
                                        <a href="<?= get_permalink(); ?>" class="cta-image">
                                            <div class="feature-image-container">
                                                <img src="<?= get_the_post_thumbnail_url(); ?>" alt="<?= the_title(); ?>">
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="col-12 col-md-5">
                                    <div class="text-container">
                                        <h4><?= the_title(); ?></h4>
                                        <p><?= get_field('short_description'); ?></p>
                                        <a href="<?= get_permalink(); ?>" class="cta-button">
                                            <span class="text"><?php if(get_bloginfo("language") == "en-US"): echo "See more"; else: echo "Ver más"; endif; ?></span>
                                            <span class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15.656" height="15.656" viewBox="0 0 15.656 15.656">
                                                    <g id="Grupo_240" data-name="Grupo 240" transform="translate(-1539.091 -986.869)">
                                                        <line id="Línea_13" data-name="Línea 13" y1="14.802" x2="14.802" transform="translate(1539.444 987.369)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="1"/>
                                                        <line id="Línea_14" data-name="Línea 14" x2="11.698" transform="translate(1542.548 987.369)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="1"/>
                                                        <line id="Línea_15" data-name="Línea 15" y2="11.698" transform="translate(1554.246 987.369)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="1"/>
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="sorry">Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
                <?php endif ?>
            </div>
        </div>
	</section>
</main>

<?php get_footer(); ?>