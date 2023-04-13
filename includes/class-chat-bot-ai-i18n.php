<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://afbinc.epizy.com
 * @since      1.0.0
 *
 * @package    Chat_Bot_Ai
 * @subpackage Chat_Bot_Ai/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Chat_Bot_Ai
 * @subpackage Chat_Bot_Ai/includes
 * @author     Aliyan Faisal <aliyanfaisal15@gmail.com>
 */
class Chat_Bot_Ai_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'chat-bot-ai',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
