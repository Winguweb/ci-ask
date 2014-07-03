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
		<div class="col-xs-12 col-md-8" id="ingreso">
			<div class="row informacion-header">
				<div class="col-xs-12 col-md-12" id="ingreso">
					<h1 class="bold-italic upper">Pedidos de Información</h1>
					<p class="lead"></p>
				</div> 
			</div>
			<div class="row informacion-center">			
				<?php echo $ask_listing_view; ?>
			</div> <!-- informacion-center -->
			<!--
			<div class="row informacion-bottom">
				<div class="col-xs-12 col-md-12">
					<button type="submit" class="btn btn-default btn-lg upper bold-italic btn-block">Cargar más consultas</button>
				</div> 
			</div>
			-->
		</div>
		<div class="col-xs-12 col-md-4 sidebar">
			<div class="buttons">
				<a href="<?php echo url::site()."ci_ask/submit"; ?>" type="submit" class="btn btn-danger btn-lg upper bold-italic btn-block">
					<?php echo Kohana::lang('ci_ask.submit'); ?>
				</a>
			</div>	
			
		</div> <!--/.sidebar -->
	</div>
</div> <!--/.main-content -->



