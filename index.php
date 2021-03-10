<?php
/**
 * Plugin Name:     Event Tickets Extension: Hello Elementor compatibility
 * Description:     Activate alongside Hello Elementor theme.
 * Version:         1.0.0
 * Extension Class: Tribe__Extension__Hello_Elementor
 * Author:          The Events Calendar
 * Author URI:      https://evnt.is/1aor
 * License:         GPLv2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 */

// Do not load unless Tribe Common is fully loaded.
if ( ! class_exists( 'Tribe__Extension' ) ) {
	return;
}

/**
 * Extension main class, class begins loading on init() function.
 */
class Tribe__Extension__Hello_Elementor extends Tribe__Extension {

	/**
	 * Setup the Extension's properties.
	 *
	 * This always executes even if the required plugins are not present.
	 */
	public function construct() {
		$this->add_required_plugin( 'Tribe__Tickets__Main' );
		$this->add_required_plugin( 'Tribe__Tickets_Plus__Main' );

		$this->set_url( 'https://theeventscalendar.com/extensions/hello-elementor-integration/' );
	}

	/**
	 * Extension initialization and hooks.
	 */
	public function init() {
		add_filter( 'the_posts', [ $this, 'tec_tickets_ar_page_hello_elementor' ], -5 );
	}

	/**
	 * Fix AR page when using Hello Elementor theme.
	 *
	 * @since 1.0.0
	 *
	 * @param array $posts The list of posts.
	 * @return array $posts.
	 */
	public function tec_tickets_ar_page_hello_elementor( $posts ) {
		global $wp, $wp_query;

		$is_hello_elementor_theme = defined( 'HELLO_ELEMENTOR_VERSION' );

		if ( empty( $is_hello_elementor_theme ) ) {
			return $posts;
		}

		$template = tribe( 'tickets.attendee_registration.template' );

		// Bail if we're not on the attendee info page.
		if ( ! $template->is_on_ar_page() ) {
			return $posts;
		}

		// Set as singular if using hello elementor.
		$wp_query->is_singular = true;

		return $posts;
	}
}
