<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _themename
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found section">
			<div class="section_in">

				<div class="error-message">
					<div class="error-message__container">
						<h1 class="animated bounce">404</h1>
						<p>Page not found.</p>

						<a class="header__logo notranslate" href="<?php echo esc_url(home_url('/')) ?>" title="Go to home page" aria-label="Go to home page">
							<div class="header__logo_i_w">
								<img class="header__logo_i"
									 src="<?php echo get_template_directory_uri() . '/assets/images/logo.png' ?>" alt="logo" loading="lazy">
							</div>
							<div class="header__logo_text">
								<span><?php bloginfo('name'); ?></span>
								<span><?php bloginfo('description'); ?></span>
							</div>
						</a>
					</div>
				</div>


			</div>
			</div>



<!--			<div class="page-content">-->
<!--				<p>--><?php //esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', '_themename' ); ?><!--</p>-->

					<?php
					//get_search_form();

					//the_widget( 'WP_Widget_Recent_Posts' );
					?>

<!--					<div class="widget widget_categories">-->
<!--						<h2 class="widget-title">--><?php //esc_html_e( 'Most Used Categories', '_themename' ); ?><!--</h2>-->
<!--						<ul>-->
							<?php
//							wp_list_categories(
//								array(
//									'orderby'    => 'count',
//									'order'      => 'DESC',
//									'show_count' => 1,
//									'title_li'   => '',
//									'number'     => 10,
//								)
//							);
							?>
<!--						</ul>-->
							<!--</div> .widget -->

<!--					--><?php
//					/* translators: %1$s: smiley */
//					$_themename_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', '_themename' ), convert_smilies( ':)' ) ) . '</p>';
//					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$_themename_archive_content" );
//
//					the_widget( 'WP_Widget_Tag_Cloud' );
//					?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
