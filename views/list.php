<?php
$replys = $asks;
foreach($asks as $ask){
	if($ask->type == '0') {
		?>
		<div id="incident_<?php echo $ask->id ?>" class="col-xs-12 col-md-12 pregunta">
			<div class="wrapper row">
				<div class="row p-header">
					<div class="col-xs-2 col-sm-2">
                        <img class="img-circle img-responsive" data-src="holder.js/100x100" src="<?php echo url::file_loc('images'); ?>themes/ci-theme/images/profile-anonimo.jpg">
                    </div>
                    <div class="col-xs-12 col-sm-10">
                        <h4 class="upper bold-italic"><?php echo $ask->author; ?> <small>- <span class="glyphicon glyphicon-time"></span> <?php echo $ask->date; ?></small></h4> 
                         <div class="row p-question">
                            <div class="pointer"></div>  
                            <div class="col-xs-12">
                                <p><?php echo $ask->message; ?>  </p>
                            </div> 
                        </div>  <!-- p-question -->
                    </div>
				</div>		
				<div class="row p-buttons">
				</div>
				<?php
				if($ask->ask_active == '1') {
					respuesta($ask->id, $replys);
				}		
				?>
			</div>
		</div>
		<?php			
	}
}
?>
<?php
function respuesta($id, $replys) {
		$i = 1;		
		do {					
			if($replys[$i]->reply_to == $id) {						
				?>
					<div id="incident_<?php echo $replys[$i]->id ?>" class="row p-answer" >
						<div class="col-xs-12 col-sm-10 col-sm-offset-2">
							<div class="row p-header">    
								<div class="col-xs-2 col-sm-2">
									<img class="img-circle img-responsive" data-src="holder.js/100x100" src="<?php echo url::file_loc('images'); ?>themes/ci-theme/images/profile-admin.jpg">
								</div>
								<div class="col-xs-12 col-sm-10">
									<h4 class="upper bold-italic"><?php echo $replys[$i]->author; ?> <small>- <span class="glyphicon glyphicon-time"></span> <?php echo $replys[$i]->date; ?></small></h4> 
									<div class="row p-question-r2">
									<div class="col-xs-12">
									  <p><?php echo $replys[$i]->message; ?></p>
									   <button href="<?php echo $replys[$i]->file_link; ?>" class="btn btn-default btn-block upper bold-italic"><span class="glyphicon glyphicon-save"></span> Descargar Archivo Adjunto</button>
									</div> 
									</div>
								</div>
							</div>  <!-- p-header -->							
						  </div>					  

					</div>
				<?php				
			} 			
			$i++;	
		} while ($replys[$i]->reply_to == $id);
}
?>
