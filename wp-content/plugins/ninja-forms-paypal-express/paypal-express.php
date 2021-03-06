<?php
/*
Plugin Name: Ninja Forms - PayPal Express
Plugin URI: http://ninjaforms.com/downloads/paypal-express
Description: Allows for integration with the PayPal Express payment gateway.
Version: 1.0.10
Author: The WP Ninjas
Author URI: http://ninjaforms.com
Text Domain: ninja-forms-paypal-express
Domain Path: /lang/

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

define("NINJA_FORMS_PAYPAL_EXPRESS_DIR", WP_PLUGIN_DIR."/".basename( dirname( __FILE__ ) ) );
define("NINJA_FORMS_PAYPAL_EXPRESS_URL", plugins_url()."/".basename( dirname( __FILE__ ) ) );
define("NINJA_FORMS_PAYPAL_EXPRESS_VERSION", "1.0.10");
define("NINJA_FORMS_PAYPAL_EXPRESS_DEBUG", false);

function ninja_forms_paypal_express_setup_license() {
  if ( class_exists( 'NF_Extension_Updater' ) ) {
    $NF_Extension_Updater = new NF_Extension_Updater( 'PayPal Express', NINJA_FORMS_PAYPAL_EXPRESS_VERSION, 'WP Ninjas', __FILE__, 'paypal_express' );
  }
}

add_action( 'admin_init', 'ninja_forms_paypal_express_setup_license' );

/**
 * Load translations for add-on.
 * First, look in WP_LANG_DIR subfolder, then fallback to add-on plugin folder.
 */
function ninja_forms_paypal_express_load_translations() {

  /** Set our unique textdomain string */
  $textdomain = 'ninja-forms-paypal-express';

  /** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
  $locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );

  /** Set filter for WordPress languages directory */
  $wp_lang_dir = apply_filters(
    'ninja_forms_paypal_express_wp_lang_dir',
    trailingslashit( WP_LANG_DIR ) . 'ninja-forms-paypal-express/' . $textdomain . '-' . $locale . '.mo'
  );

  /** Translations: First, look in WordPress' "languages" folder = custom & update-secure! */
  load_textdomain( $textdomain, $wp_lang_dir );

  /** Translations: Secondly, look in plugin's "lang" folder = default */
  $plugin_dir = trailingslashit( basename( dirname( __FILE__ ) ) );
  $lang_dir = apply_filters( 'ninja_forms_paypal_express_lang_dir', $plugin_dir . 'lang/' );
  load_plugin_textdomain( $textdomain, FALSE, $lang_dir );

}
add_action( 'plugins_loaded', 'ninja_forms_paypal_express_load_translations' );

register_activation_hook( __FILE__, 'ninja_forms_paypal_express_activation' );

require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/includes/functions.php' );
require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/includes/activation.php' );
require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/includes/shortcodes.php' );

require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/classes/class-paypal-settings.php' );
require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/classes/class-paypal-checkout.php' );
require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/classes/class-paypal-process.php' );
require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/classes/class-paypal-response.php' );
require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/classes/class-paypal-subs.php' );
require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/classes/class-paypal-subs.php' );
require_once( NINJA_FORMS_PAYPAL_EXPRESS_DIR.'/classes/deprecated-class-paypal-subs.php' );

function nf_pe_pre_27() {
  if ( defined( 'NINJA_FORMS_VERSION' ) ) {
    if ( version_compare( NINJA_FORMS_VERSION, '2.7' ) == -1 ) {
      return true;
    } else {
      return false;
    }   
  } else {
    return null;
  }
}