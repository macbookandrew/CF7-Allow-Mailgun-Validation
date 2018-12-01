<?php
/**
 * Plugin Name: CF7 Mailgun Domain Validation
 * Description: Allows the mg domain for your site to pass Contact Form 7 email validation.
 * Version: 1.0.1
 * Author: AndrewRMinion Design
 * Author URI: https://andrewrminion.com.com
 *
 * @package cf7-mailgun-domain-validation
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CF7 Mailgun validation.
 */
class CF7_Mailgun_Domain_Validation {
	/**
	 * Class instance.
	 *
	 * @var CF7_Mailgun_Domain_Validation
	 */
	private static $_instance = null;

	/**
	 * Return only one instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return CF7_Mailgun_Domain_Validation class.
	 */
	public static function get_instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new CF7_Mailgun_Domain_Validation();
		}

		return self::$_instance;
	}

	/**
	 * Kick things off.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wpcf7_config_validator_validate', array( $this, 'validate' ) );
	}

	/**
	 * Allow the mg subdomain of your site to pass validation.
	 *
	 * @since 1.0.0
	 *
	 * @param WPCF7_ConfigValidator $validator Instance of the CF& config validator.
	 *
	 * @return void
	 */
	public function validate( $validator ) {

		// Get fields to search.
		$search_fields = array(
			'mail.sender',
			'mail2.sender',
		);

		// Get site domain from Mailgun plugin settings if possible.
		$mailgun = get_option( 'mailgun' );

		// Build site domain.
		if ( $mailgun ) {
			$mg_domain = $mailgun['domain'];
		} else {
			$mg_domain = 'mg.' . str_replace( 'http://', '', get_site_url( null, '', 'http' ) );
		}

		/**
		 * Filter the Mailgun domain.
		 *
		 * @param string $domain Your mailgun domain; defaults to 'mg'.
		 *
		 * @return string Your mailgun domain.
		 */
		$mg_domain = apply_filters( 'cf7_mailgun_Domain_validation', $mg_domain );

		// Get contact form and errors.
		$form       = $validator->contact_form();
		$form_props = $form->get_properties();
		$errors     = $validator->collect_error_messages();

		// Check each error.
		foreach ( $errors as $key => $error ) {
			$key_parts = explode( '.', $key );

			if ( in_array( $key, $search_fields, true ) ) {
				foreach ( $errors[ $key ] as $sub_key => $sub_error ) {

					$sender_string = $form_props[ $key_parts[0] ][ $key_parts[1] ];
					$senders       = explode( ',', $sender_string );

					// Check all senders.
					foreach ( $senders as $sender ) {
						if ( false !== strpos( $sender, '@' . $mg_domain ) && 'Sender email address does not belong to the site domain.' === $sub_error['message'] ) {
							$validator->remove_error( $key, 103 );
						}
					}
				}
			}
		}
	}
}

CF7_Mailgun_Domain_Validation::get_instance();
