<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://afbinc.epizy.com
 * @since      1.0.0
 *
 * @package    Chat_Bot_Ai
 * @subpackage Chat_Bot_Ai/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Chat_Bot_Ai
 * @subpackage Chat_Bot_Ai/admin
 * @author     Aliyan Faisal <aliyanfaisal15@gmail.com>
 */
class Chat_Bot_Ai_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{


		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->addMenu();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chat_Bot_Ai_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chat_Bot_Ai_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/chat-bot-ai-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chat_Bot_Ai_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chat_Bot_Ai_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/chat-bot-ai-admin.js', array('jquery'), $this->version, false);
	}


	/**
	 * 
	 * 
	 * ADD ADMIN MENU and Pages 
	 */


	public function addMenu()
	{
		
		add_action('admin_menu', function () {
			add_menu_page(
				"AI Chat Bot",
				"Ai Chat Bot",
				"manage_options",
				"ai-chat-bot",
				function () {
					require_once ChatBotPath . "/admin/pages/chat_bot_default.php";
				},
				ChatBotUrl . "/public/img/logo.ico",
				4
			);
		});

		// 
	}
}
