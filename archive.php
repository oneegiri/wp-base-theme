<?php
get_header();
get_template_part('template-parts/shared/page-intro', null, array(
	'title' => get_the_archive_title()
));
?>

<?php if (have_posts()) : ?>
	<div class="container">
		<div class="row" id="archive-<?php echo get_queried_object_id(); ?>">
			<?php
			/* Start the Loop */
			while (have_posts()) :
				the_post();

				get_template_part('template-parts/content-archive');

			endwhile;

			the_posts_navigation();

		else :

			get_template_part('template-parts/content', 'none');

		endif;
			?>
		</div>
	</div>

	<?php
	//get_sidebar();
	get_footer();
	?>