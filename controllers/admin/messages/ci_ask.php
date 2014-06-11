<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Download Reports Controller.
 * This controller will take care of downloading reports.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author Marco Gnazzo
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

Class Ci_Ask_Controller extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'messages';

		// If user doesn't have access, redirect to dashboard
		if ( ! $this->auth->has_permission("manage"))
		{
			url::redirect(url::site().'admin/dashboard');
		}
   	}
   	
	static private function processSubmit() {
		if ($_POST && !empty($_POST["action"])) {
			$post = Validation::factory($_POST);

			//  Add some filters
			$post->pre_filter('trim', TRUE);

			$action_to_status = array(
					'p'		=> Ci_Ask_Message_Model::STATUS_POTENTIAL,
					'n'		=> Ci_Ask_Message_Model::STATUS_TOREVIEW, //not spam
					's'		=> Ci_Ask_Message_Model::STATUS_SPAM,
					'd'		=> Ci_Ask_Message_Model::STATUS_DISCARDED
				);

			$messages = array();



			$saved = true;
		}

		return array(
			"error" => false,
			"saved" => false
		);
	}


	function index()
	{		
		$result = self::processSubmit();
		
		$this->template->content = new View('admin/messages/ci_ask/main');
		$this->template->content->title = Kohana::lang('ci_ask.title');		

		$this->template->content->form_error = $result["error"];
		$this->template->content->form_saved = $result["saved"];

		$review_filter = "`ask_active` = " . Ci_Ask_Message_Model::STATUS_TOREVIEW . " OR ";
		$review_filter .= "`ask_active` = " . Ci_Ask_Message_Model::STATUS_REVIEWED;
		
		$filter = isset($_GET["tab"]) && ($_GET["tab"] == 1 or $_GET["tab"] == 0)? "`ask_active` = ".$_GET["tab"]: $review_filter;
		$this->template->content->tab = $filter;
				
		// Pagination
		$pagination = new Pagination(array(
			'query_string'   => 'page',
			'items_per_page' => $this->items_per_page,
			'total_items'    => ORM::factory('ci_ask')
				->where("type = 0")	
				->where($filter)					
				->count_all()
		));

		$this->template->content->pagination = $pagination;
		$this->template->content->total_items = $pagination->total_items;

		
		$entries = ORM::factory('ci_ask')
						->where("type = 0")						
						->where($filter)		
						->orderby('date', 'DESC')					
						->find_all($this->items_per_page, $pagination->sql_offset);
						
		$this->template->content->entries = $entries;
		
		$this->template->content->count_all = ORM::factory('ci_ask')				
				->where("`type` = 0")
				->count_all();

		$this->template->content->count_to_review = ORM::factory('ci_ask')
						->where(" `type` = 0")
						->where(" `ask_active` = 0")						
						->count_all();
		
		$this->template->content->count_to_reviewed = ORM::factory('ci_ask')
						->where("`type` = 0")
						->where(" `ask_active` = 1")						
						->count_all();	

		$this->themes->js = new View('admin/messages/ci_ask/main_js');		
	}   
	
	function reply($ask_id) 
	{
		self::processSubmit();
		
		$form = array(
			'contact_name' => '', 
			'contact_message' => '');
		
		$captcha = Captcha::factory();
		$errors = $form;
		$form_error = FALSE;
		$form_sent = FALSE;

		$this->template->content = new View('admin/messages/ci_ask/reply');
		$this->template->content->title = Kohana::lang('ci_ask.title');	
		
		$reply = ORM::factory('ci_ask')
				->where("type = 0")	
				->where("reply_to", $ask_id)
				->limit(1)
				->find_all();
				
		$this->template->content->answer = $reply;
		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_sent = $form_sent;

		
		$this->themes->js = new View('admin/messages/ci_ask/main_js');
		
	}

}
