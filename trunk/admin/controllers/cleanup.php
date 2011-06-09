<?php
/**
 * jUpgrade
 *
 * @version		$Id: cleanup.php
 * @package		MatWare
 * @subpackage	com_jupgrade
 * @copyright	Copyright 2006 - 2011 Matias Aguire. All rights reserved.
 * @license		GNU General Public License version 2 or later.
 * @author		Matias Aguirre <maguirre@matware.com.ar>
 * @link		http://www.matware.com.ar
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * cleanup Controller
 *
 * @package		MatWare
 * @subpackage	com_jupgrade
 */
class jupgradeControllerCleanup extends JController
{	
	function cleanup()
	{
		require_once JPATH_COMPONENT_ADMINISTRATOR.'/includes/jupgrade.class.php';
		
		/**
		 * Initialize jupgrade class
		 */
		$jupgrade = new jUpgrade;
		
		// Drop all j16_tables
		$query = "DROP TABLE `j16_assets`, `j16_banners`, `j16_banner_clients`, `j16_banner_tracks`, `j16_categories`, `j16_contact_details`, `j16_content`, `j16_content_frontpage`, `j16_content_rating`, `j16_core_log_searches`, `j16_extensions`,  `j16_languages`, `j16_menu`, `j16_menu_types`, `j16_messages`, `j16_messages_cfg`, `j16_modules`, `j16_modules_menu`, `j16_newsfeeds`, `j16_redirect_links`, `j16_schemas`, `j16_session`, `j16_template_styles`, `j16_updates`, `j16_update_categories`, `j16_update_sites`, `j16_update_sites_extensions`, `j16_usergroups`, `j16_users`, `j16_user_profiles`, `j16_user_usergroup_map`, `j16_viewlevels`, `j16_weblinks`";
		$jupgrade->db_new->setQuery($query);
		$jupgrade->db_new->query();

		// Truncate mapping tables
		$query = "TRUNCATE TABLE `j16_jupgrade_categories`, `j16_jupgrade_menus`, `j16_jupgrade_modules`";
		$jupgrade->db_new->setQuery($query);
		$jupgrade->db_new->query();

		// Set all status to 0 and clear state
		$query = "UPDATE j16_jupgrade_steps SET status = 0, state = ''";
		$jupgrade->db_new->setQuery($query);
		$jupgrade->db_new->query();

		// Cleanup 3rd extensions
		$query = "DELETE FROM j16_jupgrade_steps WHERE id > 10";
		$jupgrade->db_new->setQuery($query);
		$jupgrade->db_new->query();

		// Check for query error.
		$error = $jupgrade->db_new->getErrorMsg();
	}
}