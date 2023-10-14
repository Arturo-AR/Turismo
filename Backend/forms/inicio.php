<?php
session_start();
$usuario = $_SESSION['usuario'];
$nombreUsuario = $_SESSION['nombreUsuario'];
$categoriaUsuario = $_SESSION['idUsuarioCategoria'];
if ($usuario == null || $usuario == '') {
    header('Location: ../');
    die();
}
require '../modulos/principal/menu.php';
require_once "../db_funciones/db_global.php";
?>
	<section>
		<br><br>
		<h1>¡Bienvenido <?=$nombreUsuario;?>!</h1>
		<br>
		<h3>Sistema de cotizaciones</h3>
		<br><br>
		<h4>Ultimas Cotizaciones</h4>
		<center>
			<div class="table-responsive">
				<table id="cotizaciones" class="bg-light">
					<thead>
						<tr>
							<th>Detalle</th>
							<th>Fecha</th>
							<th>Hora</th>
							<th style="visibility:collapse; display:none;"></th>
						</tr>
					</thead>
					<tbody class="cotizacionesMostrar">
						<?php
							require_once("../db_funciones/db_cotizaciones.php");

							$dbConnect = comenzarConexion();

							$datos = mostrarCotizacionTabla($dbConnect);
							for($i = 0; $i < count($datos); $i++){
								echo '<tr>
									<td>'.$datos[$i]["detalleMovimiento"].'</td>
									<td>'.$datos[$i]["fechaOper"].'</td>
									<td>'.$datos[$i]["horaOper"].'</td>
									<td style="visibility:collapse; display:none;">'.$datos[$i]["idMovimiento"].'</td>

								</tr>';
							  }
							cerrarConexion($dbConnect);
						?>
					</tbody>
				</table>
			</div>
			<br><br>
			<?php if (($categoriaUsuario == 1) || ($categoriaUsuario == 3)) { ?>
			<h4>Ultimas Movimientos Generados</h4>
			<div class="table-responsive">
				<table id="example" class="bg-light">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Area</th>
							<th>Detalle</th>
							<th style="visibility:collapse; display:none;"></th>
						</tr>
					</thead>
						<tbody>
					    <?php
							require_once("../db_funciones/db_log_movimientos.php");

							$dbConnect = comenzarConexion();

							$datos = mostrarLogMovimientos($dbConnect);
							for($i = 0; $i < count($datos); $i++){
								echo '<tr>
									<td style="">'.$datos[$i]["fechaOper"].'</td>
									<td>'.$datos[$i]["horaOper"].'</td>
									<td>'.$datos[$i]["area"].'</td>
									<td>'.$datos[$i]["detalleMovimiento"].'</td>
									<td style="visibility:collapse; display:none;">'.$datos[$i]["idMovimiento"].'</td>

								</tr>';
							  }
							cerrarConexion($dbConnect);
						?>
					  </tbody>
				</table>
			</div>
		<?php } ?>
		</center>
	</section>
<script>
//FUNCION OBTENER COTIZACIONES GENERADAS========================================================================================
function obtenerCotizacionesGeneradas(){



	showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
	$.ajax({
	    method: "POST",
	    url: "../backend/backend_cotizacion_mostrar_tabla.php",
	    data: "",
	    success:function(data){
	        var resultadoMostrar = JSON.parse(data);
	        if(resultadoMostrar["codigo"] == "fallo"){
	            var resultados = resultadoMostrar["mensaje"];
	            $(".texto-mensaje").text(resultados);
	            $("#msj").modal("toggle");
	            closeMessageOverlay();
	        }
	        else if(resultadoMostrar["codigo"] == "exito"){
	            var resultadosTablaCotizaciones= resultadoMostrar["objetoRespuesta"]["cotizaciones"];
	            console.log(resultadosTablaCotizaciones);
	        }
	    }
	});
}
//====================================================================================================

//EVENTO READY========================================================================================
$(document).ready(function(){
    $('#example').DataTable();
	$('#cotizaciones').DataTable();
    // obtenerCotizacionesGeneradas();
});
//====================================================================================================
</script>
