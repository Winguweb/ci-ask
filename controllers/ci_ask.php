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

		$asks = ORM::factory('ci_ask')->find_all();
		
		// Fetch all incidents
		//$incidents = reports::fetch_incidents(TRUE);

		// Set the view content
		$asks_listing->asks = $asks;


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
		
		$form = array('contact_name' => '', 'contact_email' => '', 'contact_phone' => '', 'contact_subject' => '', 'contact_message' => '', 'captcha' => '');

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

	        // Add some rules, the input field, followed by a list of checks, carried out in order
        	//$post->add_rules('data_point.*','required','numeric','between[1,15]');
        	//
        	            	// $post validate check
	        if ($post->validate())
			{ 
				

			}
	      		// Validation errors
	   		else
			{ 
			        	// repopulate the form fields
				        //$form = arr::overwrite($form, $post->as_array());

				        // populate the error fields, if any
				        //$errors = arr::overwrite($errors, $post->errors('report'));
				       // $form_error = TRUE;
			        
	     	
	   		} 
		     

        }  



		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_sent = $form_sent;
		$this->template->content->captcha = $captcha;
	}

}
