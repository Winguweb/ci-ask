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
        <div class="starter-template" style="margin-top: 50px;">
          <div class="row">
             <div class="col-md-10 col-xs-12 text-left">
                  <h1 class="upper bold-italic">Pedidos de Información</h1>   
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
					<p class="lead">
						Acá podes encontrar los pedidos de información que se registraron en Caminos de la Villa y las respuestas que obtuvimos de los organismos responsables.
					</p>
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
		<div class="col-xs-12 col-md-4 sidebar jumbotron">
			<h3 class="upper bold-italic">
				Hacé tu pedido de información. 
			</h3>
			<p>Nosotros nos encargamos de hacer el pedido al organismo que corresponda y avisarte cuando nos respondan</p>
			<div class="buttons">
				<a href="<?php echo url::site()."ci_ask/submit"; ?>" type="submit" class="btn btn-danger btn-lg upper bold-italic btn-block">
					<?php echo Kohana::lang('ci_ask.submit'); ?>
				</a>
			</div>	
			
		</div> <!--/.sidebar -->
	</div>
</div> <!--/.main-content -->



