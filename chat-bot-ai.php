<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://moveupmarketinggroup.com/
 * @since             1.0.0
 * @package           Chat_Bot_Ai
 *
 * @wordpress-plugin
 * Plugin Name:       Ai Chat Bot v1.1
 * Plugin URI:        https://moveupmarketinggroup.com/
 * Description:       A customer Support Chat Bot from MoveUpMarketingGroup.
 * Version:           1.1.0
 * Author:            MoveUpMarketingGroup
 * Author URI:        https://moveupmarketinggroup.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       chat-bot-ai
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define("ChatBotPath", plugin_dir_path( __FILE__ ));
define("ChatBotUrl", plugin_dir_url(__FILE__));

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CHAT_BOT_AI_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-chat-bot-ai-activator.php
 */
function activate_chat_bot_ai() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chat-bot-ai-activator.php';
	Chat_Bot_Ai_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-chat-bot-ai-deactivator.php
 */
function deactivate_chat_bot_ai() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chat-bot-ai-deactivator.php';
	Chat_Bot_Ai_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_chat_bot_ai' );
register_deactivation_hook( __FILE__, 'deactivate_chat_bot_ai' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-chat-bot-ai.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_chat_bot_ai() {

	$plugin = new Chat_Bot_Ai();
	$plugin->run();

}

run_chat_bot_ai();


function getChatBotDB(){
	require_once ChatBotPath."includes/database/class-chat-bot-ai-database.php";
	
	$chatBotDB= new ChatBotDatabase();

	return $chatBotDB;
}






// REST ROUTES HERE
require_once ChatBotPath."includes/rest-routes/chat-bot-ai-rest-routes.php";










function delete_plugin_database_table(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'ai_chat_bot';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}

register_uninstall_hook(__FILE__, 'delete_plugin_database_table');

