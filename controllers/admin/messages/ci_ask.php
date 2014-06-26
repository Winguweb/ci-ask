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
			'reply_name' => '', 
			'reply_message' => '',
			'reply_link' => '');
		
		$captcha = Captcha::factory();
		$errors = $form;
		$form_error = FALSE;
		$form_sent = FALSE;

		$this->template->content = new View('admin/messages/ci_ask/reply');
		$this->template->content->title = Kohana::lang('ci_ask.title');	
	

		if ($_POST)
		{
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = Validation::factory($_POST);

       		//  Add some filters
        	$post->pre_filter('trim', TRUE);

	        // Add some rules, hay quethe input field, followed by a list of checks, carried out in order
        	//$post->add_rules('data_point.*','required','numeric','between[1,15]');
        	//
			$post->add_rules('reply_name', 'required', 'length[3,100]');
			$post->add_rules('reply_message', 'required');

        	
        	// $post validate check
	        if ($post->validate()) {

				$ask = new Ci_Ask_Model();				
				$ask->author = $post->reply_name;
				$ask->message = $post->reply_message;
				$ask->file_link = $post->reply_link;
				$ask->reply_to = $ask_id;
				$ask->type = '1';
				$ask->ip = $_SERVER['REMOTE_ADDR'];
				$ask->date = date("Y-m-d H:i:s",time());
				$ask->save();
				
				$question = ORM::factory('ci_ask')
						->where("type = 0")	
						->where("id", $ask_id)
						->find();
				$question->ask_active = '1';
				$question->save();
				
				
				// Yes! everything is valid - Send email
				/*
				$site_email = Kohana::config('settings.site_email');
				$subject = Kohana::lang('ci_ask.email_send.subject');
				$message = Kohana::lang('ui_admin.sender') . ": " . $post->contact_name . "\n";
				$message .= Kohana::lang('ui_admin.email') . ": " . $post->contact_email . "\n";
				$message .= Kohana::lang('ui_admin.phone') . ": " . $post->contact_phone . "\n\n";
				$message .= Kohana::lang('ui_admin.message') . ": \n" . $post->contact_message . "\n\n\n";
				$message .= "~~~~~~~~~~~~~~~~~~~~~~\n";
				$message .= Kohana::lang('ui_admin.sent_from_website') . url::base();
				*/

				// Send Admin Message
				try
				{
					//email::send($site_email, $post->contact_email, $subject, $message, FALSE);	
	
					$form_sent = TRUE;
					url::redirect(url::site().'admin/messages/ci_ask');
				}
				catch (Exception $e)
				{
					// repopulate the form fields
					$form = arr::overwrite($form, $post->as_array());

					// Manually add an error message for the email send failure.
					$errors['email_send'] = Kohana::lang('contact.email_send.failed');

					// populate the error fields, if any
					$errors = arr::merge($errors, $post->errors('contact'));
					$form_error = TRUE;
				}



			} else {
				// Repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

				// Populate the error fields, if any
				$errors = arr::merge($errors, $post->errors('ci_ask'));
				$form_error = TRUE;
			}
		}

	
		$reply = ORM::factory('ci_ask')
				->where("type = 0")	
				->where("id", $ask_id)
				->limit(1)
				->find_all();
				
		$this->template->content->question = $reply;
		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_sent = $form_sent;

		
		$this->themes->js = new View('admin/messages/ci_ask/main_js');
		
	}
	

}
