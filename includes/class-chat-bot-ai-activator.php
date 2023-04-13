<?php

/**
 * Fired during plugin activation
 *
 * @link       http://afbinc.epizy.com
 * @since      1.0.0
 *
 * @package    Chat_Bot_Ai
 * @subpackage Chat_Bot_Ai/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Chat_Bot_Ai
 * @subpackage Chat_Bot_Ai/includes
 * @author     Aliyan Faisal <aliyanfaisal15@gmail.com>
 */
class Chat_Bot_Ai_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		// create DB_ TABLE
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . "ai_chat_bot";
		$sql = "CREATE TABLE $table_name (
		  id int NOT NULL AUTO_INCREMENT,
		  meta_key varchar(50) NOT NULL,
		  meta_value varchar(1000) NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		// dbDelta( $sql );
		maybe_create_table($table_name, $sql);


		$chatBotDB = getChatBotDB();

		if($chatBotDB->checkExist("chatbot_name")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "chatbot_name",
					"meta_value" => "Maven"
				]
			);
		}


		if($chatBotDB->checkExist("chatbot_side")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "chatbot_side",
					"meta_value" => "on"
				]
			);
		}


		if($chatBotDB->checkExist("enable_chatbot")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "enable_chatbot",
					"meta_value" => "on"
				]
			);
		}

		if($chatBotDB->checkExist("starter_msg")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "starter_msg",
					"meta_value" => "Hi I’m <b>Maven</b> your customer delight bot. I’m powered by AI technology and here to help answer your questions in a delightful way.<br> How can we help you today?"
					
				]
			);
		}


		if($chatBotDB->checkExist("company_name")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "company_name",
					"meta_value" => get_bloginfo("name")
					
				]
			);
		}



		if($chatBotDB->checkExist("powered_by_text")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "powered_by_text",
					"meta_value" => "Move Up Marketing Group"
					
				]
			);
		}


		if($chatBotDB->checkExist("powered_by_text_link")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "powered_by_text_link",
					"meta_value" => "https://MoveUpMarketingGroup.com"
					
				]
			);
		}




		if($chatBotDB->checkExist("chatbot_logo")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "chatbot_logo",
					"meta_value" => ChatBotUrl . "/public/img/logo.png"
					
				]
			);
		}


		if($chatBotDB->checkExist("widget_hover_text")==0 ){
			$wpdb->replace(
				$wpdb->prefix . "ai_chat_bot",
				[
					"meta_key" => "widget_hover_text",
					"meta_value" => "Do you have any Questions?"
					
				]
			);
		}

		


		
		 
	
	}
}
