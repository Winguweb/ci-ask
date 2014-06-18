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
	
	public static function save_media($post, $incident)
	{
		$upload_dir = Kohana::config('upload.directory', TRUE);	

		// c. Photos
		if ( ! empty($post->incident_photo))
		{
			$filenames = upload::save('incident_photo');
			$i = 1;

			foreach ($filenames as $filename)
			{
				$new_filename = $incident->id.'_'.$i.'_'.time();

				//$file_type = substr($filename,-4);
				$file_type =".".substr(strrchr($filename, '.'), 1); 
				/				/ replaces the commented line above to take care of images with .jpeg extension.
				
				// Name the files for the DB
				$media_link = $new_filename.$file_type;
				$media_medium = $new_filename.'_m'.$file_type;
				$media_thumb = $new_filename.'_t'.$file_type;

				// IMAGE SIZES: 800X600, 400X300, 89X59
				// Catch any errors from corrupt image files
				try
				{
					$image = Image::factory($filename);
					// Large size
					if( $image->width > 800 || $image->height > 600 )
					{
						Image::factory($filename)->resize(800,600,Image::AUTO)
							->save($upload_dir.$media_link);
					}
					else
					{
						$image->save($upload_dir.$media_link);
					}

				}
				catch (Kohana_Exception $e)
				{
					// Do nothing. Too late to throw errors
					$media_link = NULL;
					$media_medium = NULL;
					$media_thumb = NULL;
				}
					
				// Okay, now we have these three different files on the server, now check to see
				//   if we should be dropping them on the CDN
				
				if (Kohana::config("cdn.cdn_store_dynamic_content"))
				{
					$cdn_media_link = cdn::upload($media_link);
					$cdn_media_medium = cdn::upload($media_medium);
					$cdn_media_thumb = cdn::upload($media_thumb);
					
					// We no longer need the files we created on the server. Remove them.
					$local_directory = rtrim($upload_dir, '/').'/';
					if (file_exists($local_directory.$media_link))
					{
						unlink($local_directory.$media_link);
					}
 
					if (file_exists($local_directory.$media_medium))
					{
						unlink($local_directory.$media_medium);
					}
 
					if (file_exists($local_directory.$media_thumb))
					{
						unlink($local_directory.$media_thumb);
					}
					
					$media_link = $cdn_media_link;
					$media_medium = $cdn_media_medium;
					$media_thumb = $cdn_media_thumb;
				}

				// Remove the temporary file
				unlink($filename);

				// Save to DB
				$photo = new Media_Model();
				$photo->location_id = $incident->location_id;
				$photo->incident_id = $incident->id;
				$photo->media_type = 1; // Images
				$photo->media_link = $media_link;
				$photo->media_medium = $media_medium;
				$photo->media_thumb = $media_thumb;
				$photo->media_date = date("Y-m-d H:i:s",time());
				$photo->save();
				$i++;
			}
		}
	}

}
