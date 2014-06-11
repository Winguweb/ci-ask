<?php
$replys = $asks;
foreach($asks as $ask){
	if($ask->type == '0') {
		?>
		<div id="incident_<?php echo $ask->id ?>" class="rb_report">
			<div class="r_details" style="width:550px;">
							<h2><?php echo html::escape($ask->subject); ?>			
								</h2>
							<p class="r_date r-3 bottom-cap"><?php echo $ask->date; ?></p>
							<div class="r_description"> <?php echo $ask->message; ?>  
							</div>
							<p class="r_location">Por: <b><?php echo $ask->author; ?></b></p>
			</div>
		</div>
		<?php	
		if($ask->ask_active == '1') {
			respuesta($ask->id, $replys);
		}
	}
}
?>
<?php
function respuesta($id, $replys) {
		$i = 1;		
		do {					
			if($replys[$i]->reply_to == $id) {						
				?>
					<div id="incident_<?php echo $replys[$i]->id ?>" class="rb_report" style="background: #F0F0F0;">
						<div class="r_details" style="width:550px;">
									<p class="r_date r-3 bottom-cap"><?php echo $replys[$i]->date; ?></p>
									<div class="r_description"> <?php echo $replys[$i]->message; ?>  
									<div class="r_link">Descarga: <a href="http://"><?php echo $replys[$i]->file_link; ?></a></div>
									</div>
									<p class="r_location">Por: <b><?php echo $replys[$i]->author; ?></b></p>
						</div>
					</div>
				<?php				
			} 			
			$i++;	
		} while ($replys[$i]->reply_to == $id);
}
?>
