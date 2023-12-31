<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blocksy
 */

$prefix = blocksy_manager()->screen->get_prefix();

$maybe_custom_output = apply_filters(
	'blocksy:posts-listing:canvas:custom-output',
	null
);

if ($maybe_custom_output) {
	echo $maybe_custom_output;
	return;
}

$blog_post_structure = blocksy_listing_page_structure([
	'prefix' => $prefix
]);

$container_class = 'ct-container';

if ($blog_post_structure === 'gutenberg') {
	$container_class = 'ct-container-narrow';
}


/**
 * Note to code reviewers: This line doesn't need to be escaped.
 * Function blocksy_output_hero_section() used here escapes the value properly.
 */
echo blocksy_output_hero_section([
	'type' => 'type-2'
]);

$section_class = '';

if (! have_posts()) {
	$section_class = 'class="ct-no-results"';
}

if ( is_search() && ! have_posts() ) {
	if (
		function_exists('blc_get_content_block_that_matches')
		&&
		blc_get_content_block_that_matches([
			'template_type' => 'nothing_found',
			'match_conditions' => false
		])
	) {
		echo blc_render_content_block(
			blc_get_content_block_that_matches([
				'template_type' => 'nothing_found',
				'match_conditions' => false
			])
		);
	} else {
		if (
			! function_exists('elementor_theme_do_location')
			||
			! elementor_theme_do_location('single')
		) { ?>
			<div class="<?php echo $container_class ?>" <?php echo wp_kses_post(blocksy_sidebar_position_attr()); ?> <?php echo blocksy_get_v_spacing() ?>>
				<section <?php echo $section_class ?>>
				<?php
					echo blocksy_output_hero_section([
						'type' => 'type-1'
					]);

					get_template_part('template-parts/content-none');
				?>
				</section>

			<?php get_sidebar(); ?>
			</div>
		<?php }
	}
} else {
?>

<div class="<?php echo $container_class ?>" <?php echo wp_kses_post(blocksy_sidebar_position_attr()); ?> <?php echo blocksy_get_v_spacing() ?>>
	<section <?php echo $section_class ?>>
		<?php
			if ( have_posts() ) {
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_output_hero_section() used here
				 * escapes the value properly.
				 */
				echo blocksy_output_hero_section([
					'type' => 'type-1'
				]);

				echo blocksy_render_archive_cards();
			}
		?>
	</section>

	<?php get_sidebar(); ?>
</div>

<?php }
