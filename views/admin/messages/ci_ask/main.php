<h2>
	<?php admin::messages_subtabs("ci_ask"); ?>
</h2>
<div class="tabs">
	<ul class="tabset">
			<li>
				<a href="?" 
				<?php if ($tab != 0 AND $tab != 1) echo "class=\"active2\""; ?>>
				<?php echo Kohana::lang('ui_main.show_all'); ?> (<?php echo $count_all; ?>)
				</a>
			</li>	
			<li>
				<a href="?tab=<?php echo Ci_Ask_Message_Model::STATUS_TOREVIEW; ?>" 
				<?php if ($tab == 0) echo "class=\"active2\""; ?>>
				<?php echo Kohana::lang('ci_ask.to_review'); ?> (<?php echo $count_to_review; ?>)
				</a>
			</li>			
			<li>
				<a href="?tab=<?php echo Ci_Ask_Message_Model::STATUS_REVIEWED; ?>" 
				<?php if ($tab == 1) echo "class=\"active2\""; ?>>
				<?php echo Kohana::lang('ci_ask.reviewed'); ?> (<?php echo $count_to_reviewed; ?>)
				</a>
			</li>	
	</ul>
	<!-- tab -->
	<div class="tab">
		<ul>
			<li>
				<a href="#" onClick="askAction('d', '<?php echo utf8::strtoupper(Kohana::lang('ci_ask.discard'));?>', '')">
					<?php echo utf8::strtoupper(Kohana::lang('ci_ask.discard'));?>
				</a>
			</li>	
		</ul>		
	</div>
</div>
<?php 
if ($form_error) {
?>
	<!-- red-box -->
	<div class="red-box">
		<h3><?php echo Kohana::lang('ui_main.error');?></h3>
		<ul><?php echo Kohana::lang('ui_main.select_one');?></ul>
	</div>
<?php
}
if ($form_saved) {
?>
	<!-- green-box -->
	<div class="green-box" id="submitStatus">
		<h3><?php echo Kohana::lang('ui_main.messages');?> <?php echo $form_action; ?> <a href="#" id="hideMessage" class="hide"><?php echo Kohana::lang('ui_main.hide_this_message');?></a></h3>
	</div>
<?php
}
?>
<!-- report-table -->
<?php print form::open(NULL, array('id' => 'socialMediaMain', 'name' => 'socialMediaMain')); ?>
	<input type="hidden" name="action" id="action" value="">
	<input type="hidden" name="message_single" id="message_single" value="">

	<div class="table-holder">
		<table class="table">
			<thead>
				<tr>
					<th class="col-1"><input id="checkallmessage" type="checkbox" class="check-box" onclick="CheckAll( this.id, 'message_id[]' )" /></th>					
					<th class="col-2"><?php echo Kohana::lang('ui_main.message_details');?></th>
					<th class="col-3"><?php echo Kohana::lang('ui_main.date');?></th>
					<th class="col-4"><?php echo Kohana::lang('ui_main.actions');?></th>
				</tr>
			</thead>
			<tfoot>
				<tr class="foot">
					<td colspan="5">
						<?php echo $pagination; ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
					if ($total_items == 0)
					{
					?>
						<tr>
							<td colspan="4" class="col">
								<h3><?php echo Kohana::lang('ui_main.no_results');?></h3>
							</td>
						</tr>
					<?php
					}

					foreach ($entries as $entry)
					{
						$entry_id = $entry->id;
						//$entry_link = $entry->getData("url");
						$entry_description = $entry->message;
						$entry_date = date('Y-m-d', strtotime($entry->date));
						$entry_active = $entry->ask_active;
						?>
						<tr>
							<td class="col-1"><input name="message_id[]" id="message_id" value="<?php echo $entry_id; ?>" type="checkbox" class="check-box"/></td>							
							<td class="col-2">
								<div class="post"><?php echo $entry_description; ?></div>
								<ul class="info">
									<li class="none-separator">
									<?php echo Kohana::lang('ui_main.author');?>: <?php echo $entry->author; ?> - 
									<?php echo Kohana::lang('ui_main.email');?>: <?php echo $entry->email; ?> -
									<?php echo Kohana::lang('ui_main.phone');?>: <?php echo $entry->phone; ?>
									</li>
								</ul>
							</td>
							<td class="col-3"><?php echo $entry_date; ?></td>							
							<td class="col-4">
								<ul>
									<li>
										<?php
											if($entry_active == 1) {
												echo "Respondido";
												// echo "<a href='".url::site()."admin/messages/ci_ask/reply/".$entry_id."'>Editar Respuesta</a>";
											} else {
												echo "<a href='".url::site()."admin/messages/ci_ask/reply/".$entry_id."'>Responder</a>";
											}
										?>										
									</li>
									<li><a href="<?php echo url::site().'admin/messages/ci_ask/delete/'.$entry_id ?>" onclick="return confirm("<?php echo Kohana::lang('ui_main.action_confirm');?>")" class="del"><?php echo Kohana::lang('ui_main.delete');?></a></li>								
								</ul>
							</td>
						</tr>
						<?php
					}
			?>			
			</tbody>
		</table>
	</div>
	<div class="tabs">
		<div class="tab">
			<ul>
				<li>
					<a href="#" onClick="socialMediaAction('d', '<?php echo utf8::strtoupper(Kohana::lang('ci_ask.discard'));?>', '')">
						<?php echo utf8::strtoupper(Kohana::lang('ci_ask.discard'));?>
					</a>
				</li>	
			</ul>			
		</div>
	</div>
<?php print form::close(); ?>

