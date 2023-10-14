<?php
session_start();
$usuario = $_SESSION['usuario'];
$idUsuarioOperador = $_SESSION['idUsuario'];
if ($usuario == null || $usuario == '') {
	header('Location: ../');
	die();
}
include 'menu.php';
?>

<br>
	<center>
		<div id="main-container">
			<!-- <button type="button" class="btn btn-success" id="btnNuevo"><img src="../iconos/usuario.png" style="width: 30px;">Usuario Nuevo</button> -->
			<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#popupAltaCliente"><img src="../iconos/clientes.png" style="width: 30px;">Cliente Nuevo</button>
			<br><br><br>
			<div class="table-responsive">
				<table id="example" class="bg-light">
				  <thead>
				    <tr>
				      <th scope="col">IdUsuario</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">RFC</th>
				      <th scope="col">TELEFONO</th>
				      <th scope="col">CORREO</th>
				      <th scope="col"></th>
				      <th scope="col"></th>

				     
				    </tr>
				  </thead>
				  <tbody>
				    <?php
							require_once("../db_funciones/db_global.php");
							require_once("../db_funciones/db_clientes.php");

							$dbConnect = comenzarConexion();
							$datos = mostrarClientes($dbConnect);
							for($i = 0; $i < count($datos); $i++){
								echo '<tr>
												<td class="idCliente">'.$datos[$i]["idCliente"].'</td>
												<td class="nombreCliente">'.$datos[$i]["cliente"].'</td>
												<td class="rfcClinete">'.$datos[$i]["rfc"].'</td>
												<td class="telefonoCliente">'.$datos[$i]["telefono"].'</td>
												<td class="correoCliente">'.$datos[$i]["correo"].'</td>
												<input type="hidden" class="clienteEliminado" value="'.$datos[$i]["eliminado"].'">';

												if ($datos[$i]["eliminado"] == 0) {
													echo'<td><div class="divBotones"><button class="btn btn-success" id="btnActivar" value="'.$datos[$i]["idCliente"].'"><img src="../iconos/activado.png" style="width: 30px"></button></div></td>';
												}
												else if($datos[$i]["eliminado"] == 1){
													echo'<td><button class="btn btn-danger" id="btnDesactivar" value="'.$datos[$i]["idCliente"].'"><img src="../iconos/desactivado.png" style="width: 30px"></button></td>';
												}
												
												echo '<td><button class="btn btn-warning" id="btnEditarCliente" value="'.$datos[$i]["idCliente"].'"><img src="../iconos/editar.png" style="width: 30px"></button></td>
											</tr>';
							  }
							cerrarConexion($dbConnect);
						?>
				  </tbody>
				</table>
			</div>
		</div>
	</center>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#popupEditarCliente" id="editarClientePopup" hidden></button>
<script>
//Funcion activar tabla===================================================
 $(document).ready(function() {
		$('#example').DataTable();
	} );
//========================================================================

//Boton Editar Cliente====================================================
	$(document).on("click", "#btnEditarCliente", function(e){

		var nombresCliente = "";
		var rfcCliente = "";
		var telefonoCliente = "";
		var correoCliente = "";

		var idCliente = $(this).val();

		$("#editarClientePopup").click();

		var jsonData = {
        "idCliente": idCliente
	    }

      $.ajax({
        method: "POST",
        url: "../backend/backend_cliente_mostrar_editar.php",
        data: jsonData,
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
          if(resultadoMostrar["codigo"] == "fallo"){
	        	// var resultados = resultadoMostrar["mensaje"];
	         //  $(".texto-mensaje").text(resultados);
	        	// $("#msj").modal("toggle");
	           closeMessageOverlay();
	        }
          else if(resultadoMostrar["codigo"] == "exito"){
            var resultados = resultadoMostrar["objetoRespuesta"]["datos"];
            // console.log(resultados);
            var cliente = resultados["cliente"];
						var rfc = resultados["rfc"];
						var telefono = resultados["telefono"];
						var correo = resultados["correo"];

						$("#nombreClienteEditar").val(cliente);
						$("#rfcClienteEditar").val(rfc);
						$("#telefonoClineteEditar").val(telefono);
						$("#correoClienteEditar").val(correo);
            
            closeMessageOverlay();
          }
        }
      });

		var idUsuarioOper =  <?=$idUsuarioOperador;?>;

		$(document).on("click", "#btnActualizarCliente", function(e){

			cliente = $("#nombreClienteEditar").val();
			rfc = $("#rfcClienteEditar").val();
			telefono = $("#telefonoClineteEditar").val();
			correo = $("#correoClienteEditar").val();

	    showMessageOverlay("ACTUALIZANDO USUARIO...", "../iconos/cargando.gif", "150", "150", "sending");
			var jsonData = {
        "idUsuarioOper": idUsuarioOper,
        "idCliente": idCliente,
        "cliente": cliente,
				"rfc": rfc,
				"telefono": telefono,
				"correo": correo,
	    }

      $.ajax({
        method: "POST",
        url: "../backend/backend_cliente_actualizar.php",
        data: jsonData,
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
          if(resultadoMostrar["codigo"] == "fallo"){
	        	var resultados = resultadoMostrar["mensaje"];
            $(".texto-mensaje").text(resultados);
          	$("#msj").modal("toggle");
	           closeMessageOverlay();
	        }
          else if(resultadoMostrar["codigo"] == "exito"){
            var resultados = resultadoMostrar["mensaje"];
            $(".texto-mensaje").text(resultados);
          	$("#msjRec").modal("toggle");
            closeMessageOverlay();
          }
        }
      });
		});
	});
//==========================================================================

//Boton Activar Cliente=====================================================
	$(document).on("click", "#btnActivar", function(e){
		var idCliente = $(this).val();
		var estatus = 0;
		var idUsuarioOper =  <?=$idUsuarioOperador;?>;

		var jsonData = {
      "idUsuarioOper": idUsuarioOper,
      "idCliente": idCliente,
      "estatus": estatus
     }
    showMessageOverlay("DESACTIVANDO USUARIO...", "../iconos/cargando.gif", "150", "150", "sending");
    $.ajax({
      method: "POST",
      url: "../backend/backend_cliente_eliminar.php",
      data: jsonData,
      success:function(data){
        var resultadoMostrar = JSON.parse(data);
        if(resultadoMostrar["codigo"] == "fallo"){
        	var resultados = resultadoMostrar["mensaje"];
          $(".texto-mensaje").text(resultados);
        	$("#msj").modal("toggle");
           closeMessageOverlay();
        }
        else if(resultadoMostrar["codigo"] == "exito"){
        	var resultados = resultadoMostrar["mensaje"];
        	$(".texto-mensaje").text(resultados);
          $("#msjRec").modal("toggle");
        	closeMessageOverlay();
        }
      }
    });
	});
//========================================================================

//Boton Desactivar Cliente================================================
	$(document).on("click", "#btnDesactivar", function(e){
		var idCliente = $(this).val();
		var estatus = 1;
		
		var idUsuarioOper =  <?=$idUsuarioOperador;?>;

		var jsonData = {
      "idUsuarioOper": idUsuarioOper,
      "idCliente": idCliente,
      "estatus": estatus
    }

    showMessageOverlay("ACTIVANDO USUARIO...", "../iconos/cargando.gif", "150", "150", "sending");
    $.ajax({
      method: "POST",
      url: "../backend/backend_cliente_eliminar.php",
      data: jsonData,
      success:function(data){
        var resultadoMostrar = JSON.parse(data);
        if(resultadoMostrar["codigo"] == "fallo"){
        	var resultados = resultadoMostrar["mensaje"];
          $(".texto-mensaje").text(resultados);
        	$("#msj").modal("toggle");
           closeMessageOverlay();
        }
        else if(resultadoMostrar["codigo"] == "exito"){
        	var resultados = resultadoMostrar["mensaje"];
        	$(".texto-mensaje").text(resultados);
          $("#msjRec").modal("toggle");
        	closeMessageOverlay();
        }
      }
    });
	});
	//========================================================================

	//Registrar Cliente///////////////////////////////////////////////////////
	$(document).on("click", "#btnGuardarCliente", function(){
	    var btn = $(this);
	    var idUsuarioOper =  <?=$idUsuarioOperador;?>;
	    var nombresCliente   = $("#nombreCliente").val();
      var rfcCliente = $("#rfcCliente").val();
      var telefonoCliente   = $("#telefonoClinete").val();
      var correoCliente = $("#correoCliente").val();

	    var jsonData = {
          "idUsuarioOper": idUsuarioOper,
          "cliente": nombresCliente,
          "rfc": rfcCliente,
          "telefono": telefonoCliente,
          "correo": correoCliente
      }

	    showMessageOverlay("REGISTRANDO USUARIO...", "iconos/cargando.gif", "150", "150", "sending");
	    $.ajax({
	      method: "POST",
	      url: "../backend/backend_cliente_registrar.php",
	      data: jsonData,
	      success:function(data){
	        var resultadoMostrar = JSON.parse(data);
	        if(resultadoMostrar["codigo"] == "fallo"){
	        	var resultados = resultadoMostrar["mensaje"];
	          $(".texto-mensaje").text(resultados);
	        	$("#msj").modal("toggle");
	           closeMessageOverlay();
	        }
	        else if(resultadoMostrar["codigo"] == "exito"){
		        $("#nombreCliente").val("");
				    $("#rfcCliente").val("");
				    $("#telefonoClinete").val("");
				  	$("#correoCliente").val("");
			      var resultados = resultadoMostrar["mensaje"];
	        	$(".texto-mensaje").text(resultados);
	          $("#msjRec").modal("toggle");
	          closeMessageOverlay();
	        }
	      }
	    }); 
	 });
	/////////////////////////////////////////////////////////////////////////////

// //EVENTO READY==============================================================
//   $(document).ready(function(){
//     var idUsuarioOperGlobal = "";

//   });
//   //=========================================================================
</script>
