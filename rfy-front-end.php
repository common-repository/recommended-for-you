<?php
/**
 * Description: Shows "Recomended for you"
 * Version: 1.1
 * Author: Mukul Lodhi
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.htmls
 *
 * Display Recommended Posts.
 *
 * @package     Recommended_For_You
 * @author      Mukul Lodhi
 * @license     GPL-2.0+
 */

$rfy_settings = get_option( 'rfy_settings' );

if ( 'yes' === $rfy_settings['enabled'] ) {
	add_filter( 'the_content', 'rfy_content' );
}

if ( ! function_exists( 'rfy_content' ) ) {

	/**
	 * Function get content.
	 *
	 * @param string $content content.
	 */
	function rfy_content( $content ) {

		$rfy_settings = get_option( 'rfy_settings' );

		if ( is_single() ) {

			$current_post = get_the_ID();

			$post_id = get_recomended_post_for( $current_post );

			$featured_img = get_the_post_thumbnail( $post_id );

			$title = get_the_title( $post_id );

			$my_post = get_post( $post_id );

			$excerpt = $my_post->post_excerpt;

			$excerpt = preg_replace( '/<img[^>]+\>/i', '', $excerpt );

			$url = get_permalink( $post_id );

			if ( empty( $excerpt ) ) {

				$excerpt = get_post_field( 'post_content', $post_id );

				$excerpt = trim( wp_strip_all_tags( $excerpt ) );

				$excerpt = preg_replace( '/<img[^>]+\>/i', '', $excerpt );

				$excerpt = implode( ' ', array_slice( explode( ' ', $excerpt ), 0, 20 ) );
			}

			$rfy_settings = get_option( 'rfy_settings' );

			if ( 'yes' === $rfy_settings['enabled_btn'] ) {
				$close_btn = "<div class='rf_close_btn'><a>X</a></div>";
			} else {
				$close_btn = '';
			}

			$addmore  = "<div class='rf_end_of_content'></div>";
			$addmore .= "<div class='rf_floating' id='rf_" . get_the_ID() . "'>";
			if ( 'yes' === $rfy_settings['enable_heading'] ) {
				$addmore .= "<div class='rf_heading' > <h3>" . esc_html( $rfy_settings['rfy_heading'] ) . '</h3></div>';
			}
			$addmore .= "<div class='rf_title' > <a href='" . $url . "' class='rfy_a'>" . $title . '</a></div>';
			$addmore .= "<div class='rf_img' >" . $featured_img . '</div>';
			$addmore .= "<div class='rf_content'>" . $excerpt . '</div>';
			$addmore .= $close_btn;
			$addmore .= '</div>';
			$addmore .= '<input type="hidden" name="' . esc_attr( 'rfy_mobile_enabled' ) . '" id="' . esc_attr( 'rfy_mobile_enabled' ) . '" value="' . esc_html( $rfy_settings['mobile_enabled'] ) . '">';
			$content .= $addmore;
		}
		return $content;
	}
}

if ( ! function_exists( 'get_recomended_post_for' ) ) {

	/**
	 * Function get current recommended post.
	 *
	 * @param string $current_post post.
	 */
	function get_recomended_post_for( $current_post ) {

		$tags = wp_get_post_tags( $current_post );
		if ( $tags ) {
			$current_tag = $tags[0]->slug;
			$the_query   = new WP_Query(
				array(
					'tag'            => $current_tag,
					'posts_per_page' => '1',
					'post__not_in'   => array( $current_post ),
				)
			);
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$post_id = get_the_ID();
				}
			} else {
				$post_id = get_random_posts_for( $current_post );
			}
		} else {
			$post_id = get_random_posts_for( $current_post );
		}
		return $post_id;
	}
}

if ( ! function_exists( 'get_random_posts_for' ) ) {

	/**
	 * Function get random post.
	 *
	 * @param string $current_post post.
	 */
	function get_random_posts_for( $current_post ) {
		$posts_count = wp_rand( 1, 15 );
		$the_query   = new WP_Query(
			array(
				'posts_per_page' => $posts_count,
				'post__not_in'   => array( $current_post ),
			)
		);
		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$post_id = get_the_ID();
			}
		}
		return $post_id;
	}
}
