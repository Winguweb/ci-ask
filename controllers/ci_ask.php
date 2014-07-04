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

Class Ci_Ask_Controller extends Main_Controller 
{

	 function __construct()
	{
        	parent::__construct();
   	}

	function index()
	{
		$this->template->this_page = 'ask';
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->header->this_page ='ask';
   		$this->template->content = new View('ci_ask');
		$this->template->content->title = Kohana::lang('ci_ask.title');
		
		// Get the report listing view
		$ask_listing_view = $this->_get_ask_listing_view();
		
		

		// Set the view
		$this->template->content->ask_listing_view = $ask_listing_view;
		
	}
	
	/**
	 * Helper method to load the asks listing view
	 */
	private function _get_ask_listing_view()
	{

		// Load the report listing view
		$asks_listing = new View('list');

		$asks = ORM::factory('ci_ask')					
					->find_all();
		
		$q = ORM::factory('ci_ask')
						->where("type = 1")							
						->find_all();
		
		// Fetch all incidents
		//$incidents = reports::fetch_incidents(TRUE);

		// Set the view content
		$asks_listing->asks = $asks;
		$asks_listing->replys = $q;

		//Set default as not showing pagination. Will change below if necessary.
		//$report_listing->pagination = "";

		// Return
		return $asks_listing;
	}
	


    function submit()
    {
		$this->template->this_page = 'contact';
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->header->this_page ='ask';
   		$this->template->content = new View('question_submit');
		$this->template->content->title = Kohana::lang('ci_ask.title');
	
	    if ( isset(Auth::instance()->get_user()->id) )
		{			// Load User		
			$this->template->content->loggedin_user = Auth::instance()->get_user();
		}

		
		$form = array(
		'contact_name' => '', 
		'contact_email' => '', 
		'contact_phone' => '', 
		'contact_address' => '', 
		'contact_message' => '', 
		'captcha' => '');

		// Copy the form as errors, so the errors will be stored with keys
		// corresponding to the form field names
		$captcha = Captcha::factory();
		$errors = $form;
		$form_error = FALSE;
		$form_sent = FALSE;

		if ($_POST)
		{
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = Validation::factory($_POST);

       		//  Add some filters
        	$post->pre_filter('trim', TRUE);

	        // Add some rules, hay quethe input field, followed by a list of checks, carried out in order
        	//$post->add_rules('data_point.*','required','numeric','between[1,15]');
        	//
			$post->add_rules('contact_name', 'required', 'length[3,100]');
			$post->add_rules('contact_email', 'required', 'email', 'length[4,100]');
			$post->add_rules('contact_address', 'required', 'length[3,100]');			
			$post->add_rules('contact_message', 'required');
			$post->add_rules('captcha', 'required', 'Captcha::valid');
        	
        	// $post validate check
	        if ($post->validate())
			{ 
				
				$ask = new Ci_Ask_Model();				
				$ask->author = $post->contact_name;
				$ask->email = $post->contact_email;
				$ask->address = $post->contact_address;
				$ask->phone = $post->contact_phone;				
				$ask->message = $post->contact_message;
				$ask->ip = $_SERVER['REMOTE_ADDR'];
				$subject_ask = Kohana::lang('ci_ask.subject')." - ".date("d-m-Y",time());
				$ask->subject = $subject_ask;
				$ask->date = date("Y-m-d H:i:s",time());
				$ask->save();

				
				
				// Yes! everything is valid - Send email
				$site_email = Kohana::config('settings.site_email');
				$subject = Kohana::lang('ci_ask.email_send.subject');
				$message = Kohana::lang('ui_admin.sender') . ": " . $post->contact_name . "\n";
				$message .= Kohana::lang('ui_admin.email') . ": " . $post->contact_email . "\n";
				$message .= Kohana::lang('ui_admin.phone') . ": " . $post->contact_phone . "\n\n";
				$message .= Kohana::lang('ui_admin.message') . ": \n" . $post->contact_message . "\n\n\n";
				$message .= "~~~~~~~~~~~~~~~~~~~~~~\n";
				$message .= Kohana::lang('ui_admin.sent_from_website') . url::base();

				// Send Admin Message
				try
				{
					//email::send($site_email, $post->contact_email, $subject, $message, FALSE);
	
	
					$form_sent = TRUE;
					
					//url::redirect('ci_ask');
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

			}
	      		// Validation errors
	   		else
			{ 
				// Repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

				// Populate the error fields, if any
				$errors = arr::merge($errors, $post->errors('ci_ask'));
				$form_error = TRUE;
	     	
	   		} 
		     

        }  


		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_sent = $form_sent;
		$this->template->content->captcha = $captcha;
	}
	
	/**
	 * Report Thanks Page
	 */
	public function thanks()
	{
		$this->template->header->this_page = 'reports_submit';
		$this->template->content = new View('reports/submit_thanks');
		// Get Site Email
		$this->template->content->report_email = Kohana::config('settings.site_email');
	}
	
	

}

