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
		<div id="contact_us" class="contact">
			<?php
			if ($form_error)
			{
				?>
				<!-- red-box -->
				<div class="red-box">
					<h3>Error!</h3>
					<ul>
						<?php
						foreach ($errors as $error_item => $error_description)
						{
							print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
						}
						?>
					</ul>
				</div>
				<?php
			}

			if ($form_sent)
			{
				?>
				<!-- green-box -->
				<div class="green-box">
					<h3><?php echo Kohana::lang('ui_main.contact_message_has_send'); ?></h3>
				</div>
				<?php
			}								
			?>
			<?php print form::open(NULL, array('id' => 'contactForm', 'name' => 'contactForm')); ?>
			<div class="form-group">
				<label><?php echo Kohana::lang('ui_main.contact_name'); ?>:</label>
				<?php print form::input('contact_name', $form['contact_name'], ' class="text form-control"'); ?>
			</div>
			<div class="form-group">
				<label><?php echo Kohana::lang('ui_main.contact_email'); ?>:</label>
				<?php print form::input('contact_email', $form['contact_email'], ' class="text form-control"'); ?>
			</div>
			<div class="form-group">
				<label><?php echo Kohana::lang('ui_main.contact_phone'); ?>:</label>
				<?php print form::input('contact_phone', $form['contact_phone'], ' class="text form-control"'); ?>
			</div>
			<div class="repor_row">
				<label>Organismo:</label>
				<?php $selection = array('organismo1' =>'Organismo 1', 'organismo2' => 'Organismo 2', 'organismo3' => 'Organismo 3'); ?>
				<?php print form::dropdown('input_dropdown',$selection,'standard', ' class="text form-control"'); ?><br>
			</div>
			<div class="form-group">
				<label><?php echo Kohana::lang('ui_main.contact_subject'); ?>:</label>
				<?php print form::input('contact_subject', $form['contact_subject'], ' class="text form-control"'); ?>
			</div>								
			<div class="form-group">
				<label><?php echo Kohana::lang('ui_main.contact_message'); ?>:</label>
				<?php print form::textarea('contact_message', $form['contact_message'], ' rows="4" cols="40" class="textarea form-control long" ') ?>
			</div>		
			<div class="form-group">
				<label><?php echo Kohana::lang('ui_main.contact_code'); ?>:</label>
				<?php print $captcha->render(); ?>
				<?php print form::input('captcha', $form['captcha'], ' class="text"'); ?>
			</div>
			<div class="form-group">
				<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.contact_send'); ?>" class="btn btn_submit" />
			</div>
			<?php print form::close(); ?>
		</div>
			
	</div>
		<!-- end contacts block -->
	</div>
</div>


