<?php
/*
Plugin Name: _Author
Author: Takayuki Miyauchi
Plugin URI: https://github.com/miya0001/_author
Version: nightly
Author URI: http://takayukimiyauchi.jp/
*/

namespace _author;

use \Miya\WP\GH_Auto_Updater;

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

add_action( 'init', '_author\activate_updater' );

function activate_updater() {
	$plugin_slug = plugin_basename( __FILE__ );
	$gh_user = 'miya0001';
	$gh_repo = '_author';
	// Activate automatic update.
	new GH_Auto_Updater( $plugin_slug, $gh_user, $gh_repo );
}

function whoami() {
	$author_link = '';
	if ( $url = get_the_author_meta( 'user_url' ) ) {
		$author_link = '<p><a href="' . esc_url( $url ) . '"><span class="dashicons dashicons-admin-home"></span> ウェブサイト</a></p>';
	}

	$html = sprintf(
		'<div class="underscore_author">
			<div class="container">
			<div class="author-avatar">%s</div>
			<div class="author-text"><h3 class="author-name">%s</h3><div>%s</div>%s</div>
		</div></div>',
		str_replace( "%", "%%", get_avatar( get_the_author_meta( 'ID' ), 256 ) ),
		get_the_author_meta( 'display_name' ),
		get_the_author_meta( 'user_description' ),
		$author_link
	);

	return $html;
}

add_filter( 'the_content', function( $content ) {
	if ( 'post' !== get_post_type() ) {
		return $content;
	}

	if ( ! is_single() ) {
		return $content;
	}

	if ( ! is_main_query() ) {
		return $content;
	}

	return $content . whoami();
} );

add_action( 'wp_enqueue_scripts', function() {
	if ( is_singular() && 'post' === get_post_type() ) {
		wp_enqueue_script(
			'underscore_author',
			plugins_url( 'js/script.min.js', __FILE__ ),
			array(),
			filemtime( dirname( __FILE__ ) . '/js/script.min.js' ),
			true
		);
	}

	wp_enqueue_style( 'dashicons' );
} );