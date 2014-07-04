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
  * domiclio/barrio, 
  * mail 
  * cuál es la pregunta >> * obligatorio. 
  * Teléfono optativo */
 ?>  
<div class="container-fluid wg-inner-header">
  <div class="container">
	<div class="starter-template">
	  <div class="row">
		 <div class="col-md-offset-2 col-md-8 .col-xs-12 text-center">
		  <div id="logo-home" class="stellar" data-stellar-ratio="4">
			<img src="<?php echo url::file_loc('images'); ?>themes/ci-theme/images/logo-caminosvilla-2.png" alt="Los Caminos de la Villa" class="img-responsive"/>
		  </div>
		</div>
		 </div>
	</div>
  </div>
</div><!-- /.container-fluid -->
<div class="container main-content isesion">	  
	<div class="row content-info">		
		<div class="row informacion-header">
			<div class="col-xs-12 col-md-8 col-md-offset-2" id="ingreso">
				<a href="<?php echo url::site()."ci_ask"; ?>">Volver al listado de Pedidos de información</a>
				<h1 class="bold-italic upper"><?php echo Kohana::lang('ci_ask.title'); ?></h1>
				<p class="lead">Acá puede dejar su pedido de información para que el equipo lo analice y podamos darle una respuesta.</p>				
			</div> 		  
		</div>		
		<div class="row informacion-center">
			<div class="col-xs-12 col-md-8 col-md-offset-2 pod-isesion contacto" id="consulta">
				<?php
				if ($form_error)
				{
					?>
					<!-- red-box -->
					<div class="alert alert-danger">						
						<ul style="list-style:none;">
							<?php
							foreach ($errors as $error_item => $error_description)
							{
								print (!$error_description) ? '' : "<li><span class='glyphicon glyphicon-remove'></span> " . $error_description . "</li>";
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
					<div class="alert alert-success">
						<p><span class="glyphicon glyphicon-ok"></span>
						<?php echo Kohana::lang('ui_main.contact_message_has_send'); ?>						
						</p>
					</div>
					<?php
				}								
				?>
				<?php
				$name = "";
				$email = "";
				if(isset($loggedin_user){				
					$name = ($loggedin_user != FALSE) ? $loggedin_user->name : '';
					$email = ($loggedin_user != FALSE) ? $loggedin_user->email : '';
				} 
				?>
				<?php print form::open(NULL, array('id' => 'contactForm', 'name' => 'contactForm', 'class' => 'form-horizontal')); ?>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo Kohana::lang('ui_main.contact_name'); ?> <span class="required">*</span></label>
						<div class="col-sm-9">
							<?php print form::input('contact_name', $name, 'class="text form-control"'); ?>	
						</div>			
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo Kohana::lang('ci_ask.address'); ?> <span class="required">*</span></label>
						<div class="col-sm-9">
							<?php print form::input('contact_address', $form['contact_address'], ' class="text form-control"'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo Kohana::lang('ui_main.contact_email'); ?> <span class="required">*</span></label>
						<div class="col-sm-9">
							<?php print form::input('contact_email', $email, ' class="text form-control"'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo Kohana::lang('ui_main.contact_phone'); ?></label>
						<div class="col-sm-9">
							<?php print form::input('contact_phone', $form['contact_phone'], ' class="text form-control"'); ?>
						</div>
					</div>						
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo Kohana::lang('ci_ask.message'); ?> <span class="required">*</span> </label>
						<div class="col-sm-9">
							<?php print form::textarea('contact_message', $form['contact_message'], ' rows="4" cols="40" class="textarea form-control long" ') ?>
						</div>
					</div>		
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo Kohana::lang('ui_main.contact_code'); ?></label>
						<div class="col-sm-9">
							<?php print $captcha->render(); ?>
							<?php print form::input('captcha', $form['captcha'], ' class="text"'); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
							<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.contact_send'); ?>" class="btn btn_submit" />
						</div>
					</div>
				<?php print form::close(); ?>
			</div>
		</div>
	</div>
</div>
		
 	
