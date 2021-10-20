<article class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
		if ($image) :
	?>
	<header class="post__header">
			<div class="post__image--wrap">
				<img src="<?php echo esc_url($image[0]); ?>" alt="">
			</div>
	</header>
	<?php endif; ?>
	<div class="post__body">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'pm-flex-corporate'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			)
		);

		/*wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pm-flex-corporate' ),
				'after'  => '</div>',
			)
		);*/
		?>
	</div>
</article>