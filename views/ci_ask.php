<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Download Reports view page.
 * 
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
 ?>  

 	
 
<div id="" class="container main-content">
	<div class="row header-title">
		<div class="main-header">		
		 	<h1 class="bold-italic upper"><?php echo Kohana::lang('ci_ask.title'); ?> </h1>			 	
		</div>			
	</div>
	<div  class="row content-info">	
		<div id="reports-list" class="col-md-8 col-xs-12 colleft">
			<?php echo $ask_listing_view; ?>
		</div>
		<div id="filter" class="col-md-4 col-xs-12 colleft">
			<div class="buttons">
	          <a href="<?php echo url::site()."ci_ask/submit"; ?>" role="button" class="btn btn-lg btn-danger upper bold-italic"><?php echo Kohana::lang('ci_ask.submit'); ?></a>
	        </div>		
		</div>
	</div>
</div>


