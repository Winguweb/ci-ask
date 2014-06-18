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
 /* Nombre, 
  * Documento (tipo y número), 
  * domiclio/barrio, 
  * mail 
  * cuál es la pregunta >> * obligatorio. 
  * Teléfono optativo */
 ?>  
 
<div class="bg">

	<h2>
		<?php admin::messages_subtabs("ci_ask"); ?>
	</h2>		

	<?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'reportForm', 'name' => 'reportForm')); ?>
		<input type="hidden" name="save" id="save" value="">
		<div  class="report-form">	
			<div class="head">
				<h3><?php echo Kohana::lang('ci_ask.reply') ?></h3>
				<div class="btns" style="float:right;">
					<ul>
						<li><a href="#" class="btn_save"><?php echo utf8::strtoupper(Kohana::lang('ui_main.save_report'));?></a></li>
						<li><a href="#" class="btn_save_close"><?php echo utf8::strtoupper(Kohana::lang('ui_main.save_close'));?></a></li>
					</ul>
				</div>
			</div>
			<div class="f-col">
				<div class="row">
					<h3>Mensaje:</h3>
					<p style="padding-left: 20px;"><?php echo $question[0]->message; ?></>
				</div>
				<div class="row">
					<h3>Datos del pedido:</h3>
					<ul>
						<li><strong>Nombre:</strong> <?php echo $question[0]->date; ?></li>
						<li><strong>Nombre:</strong> <?php echo $question[0]->author; ?></li>
						<li><strong>DNI:</strong> <?php echo $question[0]->identification; ?></li>
						<li><strong>Dirección:</strong> <?php echo $question[0]->address; ?></li>
						<li><strong>Email:</strong> <?php echo $question[0]->email; ?></li>
						<li><strong>Télefono:</strong> <?php echo $question[0]->phone; ?></li>
					</ul>
				</div>
			</div>
			<div class="f-col-1">
				<div class="row">
					<h4><?php echo Kohana::lang('ui_main.contact_name'); ?>:</h4>
					<?php print form::input('contact_name', $form['contact_name'], ' class="text title"'); ?>
				</div>
					
				<div class="row">
					<h4><?php echo Kohana::lang('ui_main.contact_message'); ?>:</h4>
					<?php print form::textarea('contact_message', $form['contact_message'], ' rows="4" cols="40" class="textarea " ') ?>
				</div>	

				<div class="row link-row">
					<h4><?php echo Kohana::lang('ui_main.upload_file');?></h4>
					<div class="file link-row">
					<?php print form::upload('file', '', ' class="text long"'); ?>
					<?php print "<input type=\"hidden\" name=\"file_id\" value=\"\" id=\"file_id\">"; ?>
					</div>
				</div>		

			
				<div class="btns">
					<ul>
						<li><a href="#" class="btn_save"><?php echo utf8::strtoupper(Kohana::lang('ui_main.save_report'));?></a></li>
						<li><a href="#" class="btn_save_close"><?php echo utf8::strtoupper(Kohana::lang('ui_main.save_close'));?></a></li>					
						<li><a href="<?php echo url::site().'admin/messages/ci_ask';?>" class="btns_red"><?php echo utf8::strtoupper(Kohana::lang('ui_main.cancel'));?></a></li>
					</ul>
				</div>						
				
			</div>		

				
		</div>
	<?php print form::close(); ?>

</div>



