<?php
$replys = $asks;
foreach($asks as $ask){
	if($ask->reply == '0') {
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
		foreach($replys as $reply) :
			if($reply->reply == $ask->id) {
				?>
					<div id="incident_<?php echo $reply->id ?>" class="rb_report" style="background: #F0F0F0;">
						<div class="r_details" style="width:550px;">
									<p class="r_date r-3 bottom-cap"><?php echo $reply->date; ?></p>
									<div class="r_description"> <?php echo $reply->message; ?>  
									<div class="r_link">Descarga: <a href="http://"><?php echo $reply->file_link; ?></a></div>
									</div>
									<p class="r_location">Por: <b><?php echo $reply->author; ?></b></p>
						</div>
					</div>
				<?php
			}			
		endforeach;
		continue;
	}
}
?>
