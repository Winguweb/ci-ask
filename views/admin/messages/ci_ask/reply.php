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
				<h3><?php echo Kohana::lang('ui_main.edit_report') //: Kohana::lang('ui_main.new_report'); ?></h3>
				<div class="btns" style="float:right;">
					<ul>
						<li><a href="#" class="btn_save"><?php echo utf8::strtoupper(Kohana::lang('ui_main.save_report'));?></a></li>
						<li><a href="#" class="btn_save_close"><?php echo utf8::strtoupper(Kohana::lang('ui_main.save_close'));?></a></li>
					</ul>
				</div>
			</div>
			<div class="f-col-full">
				<div class="row">
					<h4><?php echo Kohana::lang('ui_main.contact_name'); ?>:</h4>
					<?php print form::input('contact_name', $form['contact_name'], ' class="text title"'); ?>
				</div>
					
				<div class="row">
					<h4><?php echo Kohana::lang('ui_main.contact_message'); ?>:</h4>
					<?php print form::textarea('contact_message', $form['contact_message'], ' rows="4" cols="40" class="textarea " ') ?>
				</div>		

				<!-- Photo Fields -->
				<div class="row link-row">
					<h4><?php echo Kohana::lang('ui_main.reports_photos');?></h4>

				</div>


				<div id="divPhoto" class="row">
					<?php
					$this_div = "divPhoto";
					$this_field = "incident_photo";
					$this_startid = "photo_id";
					$this_field_type = "file";
		
					if (empty($form[$this_field]['name'][0]))
					{
						$i = 1;
						print "<div class=\"row link-row\">";
						print form::upload($this_field . '[]', '', ' class="text long"');
						print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
						print "</div>";
					}
					else
					{
						$i = 0;
						foreach ($form[$this_field]['name'] as $value) 
						{
							print "<div ";
							if ($i != 0) {
								print "class=\"row link-row second\" id=\"" . $this_field . "_" . $i . "\">\n";
							}
							else
							{
								print "class=\"row link-row\" id=\"$i\">\n";
							}
							// print "\"<strong>" . $value . "</strong>\"" . "<BR />";
							print form::upload($this_field . '[]', $value, ' class="text long"');
							print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
							if ($i != 0)
							{
								print "<a href=\"#\" class=\"rem\"  onClick='removeFormField(\"#".$this_field."_".$i."\"); return false;'>remove</a>";
							}
							print "</div>\n";
							$i++;
						}
					}
					print "<input type=\"hidden\" name=\"$this_startid\" value=\"$i\" id=\"$this_startid\">";
					?>
				</div>

			
				<div class="btns">
					<ul>
						<li><a href="#" class="btn_save"><?php echo utf8::strtoupper(Kohana::lang('ui_main.save_report'));?></a></li>
						<li><a href="#" class="btn_save_close"><?php echo utf8::strtoupper(Kohana::lang('ui_main.save_close'));?></a></li>					
						<li><a href="<?php echo url::site().'admin/reports/';?>" class="btns_red"><?php echo utf8::strtoupper(Kohana::lang('ui_main.cancel'));?></a></li>
					</ul>
				</div>						
				
			</div>
				<?php print form::close(); ?>

				
		</div>


</div>


