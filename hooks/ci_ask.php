<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Download Reports Hook.
 * This hook will take care of adding a link in the nav_main_top section.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */


// Hook into the nav main_top

class requestinformation {

public function __construct()
	{	
		Event::add('system.pre_controller', array($this, 'add'));
		//Event::add('ushahidi_action.nav_main_top', array($this, 'add'));
		//Event::add('ushahidi_action.nav_admin_messages', array($this, 'add'));
          
	}	

public function add()
	{	
		// Add plugin link to nav_main_top		
		//echo "<li><a href='" . url::site() . "ci_ask'>" . strtoupper(Kohana::lang('ui_main.ci_ask')) . "</a></li>";
		// Settings menu
			Event::add('ushahidi_action.nav_admin_messages', array($this, '_messages'));		
	}

public function _messages()
{

	$this_sub_page = Event::$data;
	echo "<a href=\"".url::site()."admin/messages/ci_ask\">". strtoupper(Kohana::lang('ci_ask.title'))."</a>";
}

}
new requestinformation();


