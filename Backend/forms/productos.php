<?php
session_start();
$usuario = $_SESSION['usuario'];
$idUsuarioOperador = $_SESSION['idUsuario'];
$categoriaUsuario = $_SESSION['idUsuarioCategoria'];
if ($usuario == null || $usuario == '') {
	header('Location: ../');
	die();
}
include 'menu.php';
?>

<br>
	<center>
		<div id="main-container">
			<div class="row">
				<?php if ($categoriaUsuario == 3) { ?>
				<div class="col-lg-4 botonCargarProductos">
					<button type="button" class="btn btn-success btn-lg" onclick="mostrarCargarExcelProductos();"><img src="../iconos/excel.png" style="width: 30px;">Subir productos</button>
				</div>
				<?php } ?>
				<?php if ($categoriaUsuario == 1 || $categoriaUsuario == 2) { ?>
				<div class="col-lg-4"></div>
				<div class="col-lg-4">
					<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#alta_producto"><img src="../iconos/paquete.png" style="width: 30px;">Producto Nuevo</button>
				</div>
				<div class="col-lg-4"></div>
				<?php }elseif ($categoriaUsuario == 1 || $categoriaUsuario == 2 || $categoriaUsuario == 3){?>
					<div class="col-lg-4">
					<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#alta_producto"><img src="../iconos/paquete.png" style="width: 30px;">Producto Nuevo</button>
				</div>
				<?php } ?>
				<?php if ($categoriaUsuario == 3) { ?>
				<div class="col-lg-4">
					<button type="button" class="btn btn-secondary btn-lg" onclick="eliminarProductosTabla();"><img src="../iconos/exportarExcel.png" style="width: 30px;">Exportar productos</button>
				</div>
				<?php } ?>
			</div>
			<br>
			<div class="col-sm-12 excelSubirProductos"></div>
			<br><br><br>
			<div class="table-responsive tablaProductos">
				<table id="example" class="bg-light">
				  <thead>
				    <tr>
				      <th scope="col">IdProducto</th>
				      <th scope="col">Clave</th>
				      <th scope="col">Descripción</th>
				      <th scope="col">Existencia</th>
				      <th scope="col"></th>
				      <th scope="col"></th>

				     
				    </tr>
				  </thead>
				  <tbody>
				    <?php
							require_once("../db_funciones/db_global.php");
							require_once("../db_funciones/db_productos.php");

							$dbConnect = comenzarConexion();
							$datos = mostrarProductosPropios($dbConnect);
							for($i = 0; $i < count($datos); $i++){
								echo '<tr>
												<td class="idProductoPropio">'.$datos[$i]["idProductoPropio"].'</td>
												<td class="clave">'.$datos[$i]["clave"].'</td>
												<td class="descripcion">'.$datos[$i]["descripcion"].'</td>
												<td class="existencia">'.$datos[$i]["existencia"].'</td>
												<input type="hidden" class="clienteEliminado" value="'.$datos[$i]["eliminado"].'">';

												if ($datos[$i]["eliminado"] == 0) {
													echo'<td><div class="divBotones"><button class="btn btn-success" id="btnActivar" value="'.$datos[$i]["idProductoPropio"].'"><img src="../iconos/activado.png" style="width: 30px"></button></div></td>';
												}
												else if($datos[$i]["eliminado"] == 1){
													echo'<td><button class="btn btn-danger" id="btnDesactivar" value="'.$datos[$i]["idProductoPropio"].'"><img src="../iconos/desactivado.png" style="width: 30px"></button></td>';
												}
												
												echo '<td><button class="btn btn-warning" id="btnEditarProducto" value="'.$datos[$i]["idProductoPropio"].'"><img src="../iconos/editar.png" style="width: 30px"></button></td>
											</tr>';
							  }
							cerrarConexion($dbConnect);
						?>
				  </tbody>
				</table>
			</div>
		</div>
	</center>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#popupEditarProducto" id="editarProductoPopup" hidden></button>
<script>

	//FUNCION MOSTRAR FOMULARIO SUBIR PRODUCTOS===============================
	function mostrarCargarExcelProductos(){

    $(".tablaProductos").hide();

    var htmlBotonRegresarTablaProductos =
    "<button type='button' class='btn btn-secondary btn-lg' onclick='mostrarTablaProductos();'><img src='../iconos/regreso.png' style='width: 30px;'>Tabla Productos</button>";
    $(".botonCargarProductos").html(htmlBotonRegresarTablaProductos);

    var htmlCargarArchivosProductos =
    
	 	"<center>"+
      "<br>"+
      "<div class='col-sm-3 boxFile'>"+
          "<div>"+
              "<label>Archivo Productos</label>"+
              "<br>"+
              "<button class='col-sm-12 cargarArchivo' onClick='clickCargarExcelProductos();'>Archivo<span class='btnCargar'></span></button>"+
          "</div>"+
          "<form class='formularioCamposOcultos' id='formProductosNuevos' enctype='multipart/form-data'>"+

              "<input type='file' name='productosExcel' id='productosExcel' accept='.xls,.xlsx' onChange='cambioExcelProductos();' />"+
              "<input type='text' name='idUsuario' id='idUsuarioproductosNuevos' value='<?=$idUsuario;?>;'/>"+

          "</form>"+
      "</div>"+
      "<div class='col-sm-3'>"+
          "<br><br>"+
          "<button type='button' class='btn btn-success' onclick='enviarExcelProductos();'><img src='../iconos/excel.png' style='width: 30px;'><br>Importar</button>"+
      "</div>"+
  	"</center>";

  	$(".excelSubirProductos").html(htmlCargarArchivosProductos);
	}
	//========================================================================

	//FUNCION MOSTRAR FOMULARIO SUBIR PRODUCTOS===============================
	 function mostrarTablaProductos(){
	 	$(".excelSubirProductos").html("");
    $(".tablaProductos").show();

    var htmlBotonCargarProductos =
    "<button type='button' class='btn btn-success btn-lg' onclick='mostrarCargarExcelProductos();'><img src='../iconos/insertarExcel.png' style='width: 30px;'>Subir productos</button>";
    $(".botonCargarProductos").html(htmlBotonCargarProductos);
	 }
	//========================================================================

	//FUNCION CLIC CARGAR ARCHIVO=========================================================================
function clickCargarExcelProductos(){
    $("#productosExcel").click();
}
//====================================================================================================

//FUNCION CAMBIO ARCHIVO==============================================================================
function cambioExcelProductos(){
    $(".cargarArchivo").html("Cargado<span class='btnCargado'></span>");
}
//====================================================================================================

//FUNCION ENVIAR EXCEL MASIVO ENCABEZADOS ============================================================================
function enviarExcelProductos(){
    var productos = $("#productosExcel").val();
    var idUsuario = $("#idUsuarioproductosNuevos").val();

    // VALIDACION
      if(validacionCamposInput(productos, "", ".texto-mensaje", "", 0, "El archivo de la cotizacion es obligatoria.") == false){
        $("#msj").modal("toggle");
        return false;
      }

      $("#formProductosNuevos #idUsuarioUnico").val(idUsuario);

      $("#formProductosNuevos").submit();
}
//===================================================================================================

//EVENTO ENVIAR EXCEL MASIVO ENCABEZADOS============================================================================
$("#formProductosNuevos").on("submit", function(e){
    e.preventDefault();

    var formData = new FormData(document.getElementById("formProductosNuevos"));

    showMessageOverlay("ENVIANDO...", "../iconos/cargando.gif", "200", "200", "sending");

    $.ajax({
      url: "../backend/backend_productos_excel_registro.php",
      type: "POST",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){
        var resultado = JSON.parse(data);
        
        if(resultado["codigo"] == "fallo"){
          if(resultado["mensaje"] == ""){
            $(".texto-mensaje").text("ERROR.");
          }
          else{
            $(".texto-mensaje").text(resultado["mensaje"]);
          }
          $("#msj").modal("toggle");
          closeMessageOverlay();
        }
        else if(resultado["codigo"] == "exito"){
          $(".texto-mensaje").text("Productos guardados correctamente.");
          $("#msjRec").modal("toggle");
          closeMessageOverlay();
        }
      }
    });
});
//====================================================================================================

//FUNCION ELIMINAR PRODUCTOS TABLA=========================================
	 function eliminarProductosTabla(){
	 	alert("este modulo esta en proceso");
	 }
	//========================================================================

//Boton Editar Cliente====================================================
	$(document).on("click", "#btnEditarProducto", function(e){

		var nombresCliente = "";
		var rfcCliente = "";
		var telefonoCliente = "";
		var correoCliente = "";

		var idProducto = $(this).val();

		$("#editarProductoPopup").click();

		var jsonData = {
        "idProductoPropio": idProducto
	    }

      $.ajax({
        method: "POST",
        url: "../backend/backend_productos_propios_mostrar_editar.php",
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
            var resultados = resultadoMostrar["objetoRespuesta"]["datos"];
            // console.log(resultados);
            var clave = resultados["clave"];
						var descripcion = resultados["descripcion"];
						var existencia = resultados["existencia"];
						var idCategoria = resultados["idCategoria"];
						var idUnidad = resultados["idUnidad"];

						$("#claveProductoEditar").val(clave);
						$("#descripcionProductoEditar").val(descripcion);
						$("#categoriaProductoEditar").val(idCategoria);
						$("#unidadesMedidaProductoEditar").val(idUnidad);
						$("#existenciaProductosEditar").val(existencia);
            
            closeMessageOverlay();
          }
        }
      });

		var idUsuarioOper =  <?=$idUsuarioOperador;?>;

		$(document).on("click", "#btnActualizarProducto", function(e){

			clave = $("#claveProductoEditar").val();
			descripcion = $("#descripcionProductoEditar").val();
			existencia = $("#categoriaProductoEditar").val();
			idCategoria = $("#unidadesMedidaProductoEditar").val();
			idUnidad = $("#existenciaProductosEditar").val();

	    showMessageOverlay("ACTUALIZANDO PRODUCTO...", "../iconos/cargando.gif", "150", "150", "sending");
			var jsonData = {
        "idUsuarioOper": idUsuarioOper,
        "idProductoPropio": idProducto,
        "clave": clave,
				"descripcion": descripcion,
				"existencia": existencia,
				"idCategoria": idCategoria,
				"idUnidad": idUnidad
	    }

      $.ajax({
        method: "POST",
        url: "../backend/backend_productos_propios_actualizar.php",
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

//Boton Activar Producto=====================================================
	$(document).on("click", "#btnActivar", function(e){
		var idProducto = $(this).val();
		var estatus = 0;
		var idUsuarioOper =  <?=$idUsuarioOperador;?>;

		var jsonData = {
      "idUsuarioOper": idUsuarioOper,
      "idProductoPropio": idProducto,
      "estatus": estatus
     }
    showMessageOverlay("DESACTIVANDO PRODUCTO...", "../iconos/cargando.gif", "150", "150", "sending");
    $.ajax({
      method: "POST",
      url: "../backend/backend_productos_propios_eliminar.php",
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

//Boton Desactivar Producto================================================
	$(document).on("click", "#btnDesactivar", function(e){
		var idProducto = $(this).val();
		var estatus = 1;
		
		var idUsuarioOper =  <?=$idUsuarioOperador;?>;

		var jsonData = {
      "idUsuarioOper": idUsuarioOper,
      "idProductoPropio": idProducto,
      "estatus": estatus
    }

    showMessageOverlay("ACTIVANDO PRODUCTO...", "../iconos/cargando.gif", "150", "150", "sending");
    $.ajax({
      method: "POST",
      url: "../backend/backend_productos_propios_eliminar.php",
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

//EVENTO READY==============================================================
  $(document).ready(function(){
    
    $('#example').DataTable();

  });
  //=========================================================================

</script>