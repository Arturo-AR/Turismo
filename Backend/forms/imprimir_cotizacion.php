<?php
session_start();
include 'menu.php';
?>

<div class="panel panel-info">
	<div class="panel-heading">IMPRIMIR COTIZACIÓN</div>
	<br>
	<div class="panel-body">
		<div class="titulosh3"><h3>BUSQUEDA DE COTIZACIONES</h3></div>
		<div class="row">
			<div class="col-lg-4 selectTipoCotizImprimir">
				<label>Tipo de cotizaciones</label>
				<select class="form-control" id="tipoCotizacionImprimir" onchange="tipoCotizacionSelect();">
					<option value="-1">Tipos</option>
					<option value="0">Cotizaciones</option>
					<option value="1">Cotizaciones Multiples</option>
					<option value="2">Cotizaciones Excel Multiple</option>
					<option value="3">Cotizaciones Excel</option>
				</select>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-2 selectCotizImprimirUnica"></div>
			<div class="col-lg-2 selectCotizEncontradaImprimirUnica"></div>
			<div class="col-lg-1 checkNombreEmpresaUnica"></div>
		</div>
		<div class="row">
			<div class="col-lg-2 selectCotizImprimirExcel"></div>
			<div class="col-lg-2 selectCotizEncontradaImprimirExcel"></div>
			<div class="col-lg-1 checkNombreEmpresaExcel"></div>
		</div>
		<div class="row">
			<div class="col-lg-2 selectClientesImprimir"></div>
			<div class="col-lg-2 selectEmpresasImprimir"></div>
			<div class="col-lg-2 selectCotizImprimir"></div>
			<div class="col-lg-2 selectCotizEncontradaImprimir"></div>
			<div class="col-lg-1 checkLogoEmpresa"></div>
			<div class="col-lg-1 checkNombreEmpresa"></div>
		</div>
		<div class="row">
			<div class="col-lg-4 campoNombreEmpresaExcel"></div>
		</div>
		<div class="row">
			<div class="col-lg-4 campoNombreEmpresa"></div>
		</div>
		<div class="row">
			<div class="col-lg-4 campoNombreEmpresaUnica"></div>
		</div>
		<br><br>
		<div class="titulosh3"><h3>IMPRIMIR COTIZACIÓN</h3></div>
		<div class="row">
			<div class="col-lg-2">
				<label for="folio_cotiz"> Porcentaje de Utilidad </label>
				<input type="text" class="form-control" maxlength="2" onKeypress="soloNumeros(this);" placeholder="Ingresa utilidad" id="utilidad_cotiz">
			</div>
			<div class="col-lg-2 fechaCotizacionImprimir">
				<label>Fecha cotización</label>
				<input type='date' align='center' size='8' name='fecha' id='fecha_cotiz' class='form-control'>
			</div>
			<div class="col-lg-2">
				<label for="no_requisision">Número de requisición</label>
				<input type="text" align="center" size="8" value name="no_requisicion" id="no_requisicion" class="form-control">
			</div>
			<!-- <div class="col-lg-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="folioCotizImprimir" id="folioCotizImprimir">Ver folio
					</label>
				</div>
			</div> -->
			<div class="col-lg-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="firmaCotizImprimir" id="firmaCotizImprimir">Firma
					</label>
				</div>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-lg-2 botonImprimirCotiz"></div>
			<div class="col-lg-2 botonEnviarCorreoCotiz"></div>
		</div>
	</div>
</div>
<script>
//FUNCION OBTENER DATOS CLIENTES=========================================================================
function tipoCotizacionSelect(){
	var idSelectTipo = $('#tipoCotizacionImprimir').val();
	if (idSelectTipo == 0) {

		obtener_datos_proveedor_unica_imprimir();

		$(".selectClientesImprimir").html("");
		$(".selectEmpresasImprimir").html("");
		$(".selectCotizImprimir").html("");
		$(".selectCotizEncontradaImprimir").html("");
		$(".checkLogoEmpresa").html("");
		$(".checkNombreEmpresa").html("");
		$(".campoNombreEmpresa").html("");

		$(".selectCotizImprimirExcel").html("");
		$(".selectCotizEncontradaImprimirExcel").html("");
		$(".checkNombreEmpresaExcel").html("");
		$(".campoNombreEmpresaExcel").html("");
	}
	else if (idSelectTipo == 1) {
		obtener_datos_clientes_imprimir();
    	obtener_datos_empresas_imprimir();
    	obtener_datos_proveedor_imprimir();

    	$(".selectCotizImprimirUnica").html("");
		$(".selectCotizEncontradaImprimirUnica").html("");
		$(".checkNombreEmpresaUnica").html("");
		$(".campoNombreEmpresaUnica").html("");

		$(".selectCotizImprimirExcel").html("");
		$(".selectCotizEncontradaImprimirExcel").html("");
		$(".checkNombreEmpresaExcel").html("");
		$(".campoNombreEmpresaExcel").html("");
	}
	else if (idSelectTipo == 2) {
		obtener_datos_proveedor_excel_imprimir();

		$(".selectClientesImprimir").html("");
		$(".selectEmpresasImprimir").html("");
		$(".selectCotizImprimir").html("");
		$(".selectCotizEncontradaImprimir").html("");
		$(".checkLogoEmpresa").html("");
		$(".checkNombreEmpresa").html("");
		$(".campoNombreEmpresa").html("");

		$(".selectCotizImprimirUnica").html("");
		$(".selectCotizEncontradaImprimirUnica").html("");
		$(".checkNombreEmpresaUnica").html("");
		$(".campoNombreEmpresaUnica").html("");
	}
	else if (idSelectTipo == -1) {

		$(".selectClientesImprimir").html("");
		$(".selectEmpresasImprimir").html("");
		$(".selectCotizImprimir").html("");
		$(".selectCotizEncontradaImprimir").html("");
		$(".checkLogoEmpresa").html("");
		$(".checkNombreEmpresa").html("");
		$(".selectCotizImprimirUnica").html("");
		$(".selectCotizEncontradaImprimirUnica").html("");
		$(".checkNombreEmpresaUnica").html("");

		$(".selectCotizImprimirExcel").html("");
		$(".selectCotizEncontradaImprimirExcel").html("");
		$(".checkNombreEmpresaExcel").html("");
	}
	
}
//====================================================================================================

//FUNCION OBTENER DATOS CLIENTES=========================================================================
function obtener_datos_clientes_imprimir(){
	showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cliente_mostrar.php",
        data: "",
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
          if(resultadoMostrar["codigo"] == "fallo"){
               //  var resultados = resultadoMostrar["mensaje"];
              	// $(".texto-mensaje").text(resultados);
               //  $("#msj").modal("toggle");
               	closeMessageOverlay();
            }
            else if(resultadoMostrar["codigo"] == "exito"){
                var resultados = resultadoMostrar["objetoRespuesta"]["cliente"];

                var opcionesClientes = "<option value='-1' cliente='' rfc='' telefono=''>Clientes *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var nombreCliente   = resultadosTotales["cliente"];
                    var idCliente = resultadosTotales["idCliente"];
                    var rfcCliente = resultadosTotales["rfc"];
                    var telefonoCliente = resultadosTotales["telefono"];

                    opcionesClientes += "<option value='"+idCliente+"' cliente='"+nombreCliente+"' rfc='"+rfcCliente+"' telefono='"+telefonoCliente+"'>"+nombreCliente+"</option>";
                }
                var htmlSelectClientes =
                "<label>Cliente Cotización</label>"+
                "<select name='cliente_cotiz' class='form-control' id='clienteCotizacionImprimir'>"+opcionesClientes+"</select>";
                $(".selectClientesImprimir").html(htmlSelectClientes);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS EMPRESAS=======================================================================
function obtener_datos_empresas_imprimir(){

  showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
  $.ajax({
    method: "POST",
    url: "../backend/backend_mostrar_empresa.php",
    data: "",
    success:function(data){
      var resultadoMostrar = JSON.parse(data);
      if(resultadoMostrar["codigo"] == "fallo"){
          //   var resultados = resultadoMostrar["mensaje"];
          // $(".texto-mensaje").text(resultados);
          //   $("#msj").modal("toggle");
           closeMessageOverlay();
        }
      else if(resultadoMostrar["codigo"] == "exito"){
        var resultados = resultadoMostrar["objetoRespuesta"]["empresas"];

        var opcionesEmpresasImprimir = "<option value='-1' nombre=''>EMPRESA *</option>";

        for (i = 0; i < resultados.length; i++) {
            var resultadosTotales = resultados[i];
            // console.log(resultadosTotales);
            var idEmpresa = resultadosTotales["id_empresa"];
            // var atencion = resultadosTotales["atencion"];
            var empresa   = resultadosTotales["nombre"];
            // var telefono  = resultadosTotales["telefono"];

            opcionesEmpresasImprimir += "<option value='"+idEmpresa+"' nombre='"+empresa+"'>"+empresa+"</option>";
        }
        var htmlSelectEmpresasImprimir =
        "<label>Empresa</label>"+
        "<select name='empresa_cotiz' class='form-control' id='empresaSelectImprimir'>"+opcionesEmpresasImprimir+"</select>";
        $(".selectEmpresasImprimir").html(htmlSelectEmpresasImprimir);

        closeMessageOverlay();
      }
    }
  });
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function obtener_datos_proveedor_imprimir(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_proveedores_mostrar.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["proveedores"];
                // console.log(resultados);
                var opcionesCotizacionesImprimir = "<option value='-1' folio='' proveedor=''>Proveedor *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idProveedor = resultadosTotales["idProveedor"];
                    var folio   = resultadosTotales["folio"];
                    var proveedor = resultadosTotales["proveedor"];

                    opcionesCotizacionesImprimir += "<option value='"+idProveedor+"' folio='"+folio+"' proveedor='"+proveedor+"'>"+proveedor+"</option>";
                }
                var htmlSelectCotizacionesProveedor =
                "<label>Proveedor</label>"+
                "<select name='proveedor_imprimir' class='form-control' id='proveedor_imprimir' onchange='selectFoliosImprimir(this);'>"+opcionesCotizacionesImprimir+"</select>";
                $(".selectCotizImprimir").html(htmlSelectCotizacionesProveedor);
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function obtener_datos_proveedor_unica_imprimir(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_proveedores_mostrar.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["proveedores"];
                // console.log(resultados);
                var opcionesCotizacionesImprimirUnicas = "<option value='-1' folio='' proveedor=''>Proveedor *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idProveedor = resultadosTotales["idProveedor"];
                    var folio   = resultadosTotales["folio"];
                    var proveedor = resultadosTotales["proveedor"];

                    opcionesCotizacionesImprimirUnicas += "<option value='"+idProveedor+"' folio='"+folio+"' proveedor='"+proveedor+"'>"+proveedor+"</option>";
                }
                var htmlSelectCotizacionesUnicas =
                "<label>Proveedor</label>"+
                "<select name='proveedor_imprimir_unica' class='form-control' id='proveedor_imprimir_unica' onchange='selectFoliosImprimirUnica(this);'>"+opcionesCotizacionesImprimirUnicas+"</select>";
                $(".selectCotizImprimirUnica").html(htmlSelectCotizacionesUnicas);
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function obtener_datos_proveedor_excel_imprimir(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_proveedores_mostrar.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["proveedores"];
                // console.log(resultados);
                var opcionesCotizacionesImprimirExcel = "<option value='-1' folio='' proveedor=''>Proveedor *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idProveedor = resultadosTotales["idProveedor"];
                    var folio   = resultadosTotales["folio"];
                    var proveedor = resultadosTotales["proveedor"];

                    opcionesCotizacionesImprimirExcel += "<option value='"+idProveedor+"' folio='"+folio+"' proveedor='"+proveedor+"'>"+proveedor+"</option>";
                }
                var htmlSelectCotizacionesExcel =
                "<label>Proveedor</label>"+
                "<select name='proveedor_imprimir_excel' class='form-control' id='proveedor_imprimir_excel' onchange='selectFoliosImprimirExcel(this);'>"+opcionesCotizacionesImprimirExcel+"</select>";
                $(".selectCotizImprimirExcel").html(htmlSelectCotizacionesExcel);
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosImprimir(e){
	var idProveedorSeleccionada = $(e).val();
	// console.log(idProveedorSeleccionada);

	var general = "";

	if (idProveedorSeleccionada == 2) {

		// var htmlCheckLogoEmpresa =
		// "<div class='checkbox'><label><input type='checkbox' name='logoEmpresaCheck' id='logoEmpresaCheck'>Logo</label></div>";
		// $(".checkLogoEmpresa").html(htmlCheckLogoEmpresa);

		var htmlCheckNombreEmpresa =
		"<div class='checkbox'><label><input type='checkbox' name='nombreEmpresaCheck' id='nombreEmpresaCheck'>Nombre</label></div>";
		$(".checkNombreEmpresa").html(htmlCheckNombreEmpresa);

	}
	else{
		$(".checkLogoEmpresa").html("");
		$(".checkNombreEmpresa").html("");
	}

	// $('#logoEmpresaCheck').on('change', function() {
	//     var checked = this.checked
	//     if (checked == true) {
	//     	general = 1;
	//     	var htmlCampoLogoEmpresa =
	// 		"<label>Logo de Empresa</label>"+
	// 		"<button class='botonLogoEmpresa'>";
	// 		$(".campoLogoEmpresa").html(htmlCampoLogoEmpresa);

	// 		var htmlBotonImprimirCotiz =
 //            "<button type='button' class='btn btn-outline-success'  onclick='imprimirCotizacion("+general+");' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
 //            $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);
	//     }
	//     else{
	//     	$(".campoLogoEmpresa").html("");
	//     }
	// });

	$('#nombreEmpresaCheck').on('change', function() {
	    var checked = this.checked
	    if (checked == true) {
	    	general = 2
	    	var htmlCampoNombreEmpresa =
			"<label>Nombre de Empresa</label>"+
			"<input type='text' value name='nombreEmpresa' id='nombreEmpresa' class='form-control'>";
			$(".campoNombreEmpresa").html(htmlCampoNombreEmpresa);

			var htmlBotonImprimirCotiz =
            "<button type='button' class='btn btn-outline-success'  onclick='imprimirCotizacion("+general+");' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
            $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);
	    }
	    else{
	    	$(".campoNombreEmpresa").html("");
	    }
	});

    var folioSeleccionado = $("#proveedor_imprimir option:selected").attr("folio");

    var jsonData = {
        "folioCotizacion": folioSeleccionado,
        }

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_proveedores_mostrar_folios.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["folios"];
                // console.log(resultados);
                var opcionesFolioCotizacionesImprimir = "<option value='-1' folio=''>Cotizaciones *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idCotizacionEncontrada = resultadosTotales["idCotizacion"];
                    var folioCotizacion   = resultadosTotales["folioCotizacion"];

                    opcionesFolioCotizacionesImprimir += "<option value='"+idCotizacionEncontrada+"' folio='"+folioCotizacion+"'>"+folioCotizacion+"</option>";
                }
                var htmlSelectCotizacionesProveedor =
                "<label>Cotizaciones Encontradas</label>"+
                "<select name='cotizEncontradaImprimir' class='form-control' id='cotizEncontradaImprimir' onchange='mostrarBotones();'>"+opcionesFolioCotizacionesImprimir+"</select>";
                $(".selectCotizEncontradaImprimir").html(htmlSelectCotizacionesProveedor);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosImprimirUnica(e){
	var idProveedorSeleccionada = $(e).val();

	var general = "";

	if (idProveedorSeleccionada == 2) {

		// var htmlCheckLogoEmpresa =
		// "<div class='checkbox'><label><input type='checkbox' name='logoEmpresaCheck' id='logoEmpresaCheck'>Logo</label></div>";
		// $(".checkLogoEmpresa").html(htmlCheckLogoEmpresa);

		var htmlCheckNombreEmpresa =
		"<div class='checkbox'><label><input type='checkbox' name='nombreEmpresaCheckUnica' id='nombreEmpresaCheckUnica'>Nombre</label></div>";
		$(".checkNombreEmpresaUnica").html(htmlCheckNombreEmpresa);

	}
	else{
		// $(".checkLogoEmpresa").html("");
		$(".checkNombreEmpresaUnica").html("");
	}

	// $('#logoEmpresaCheck').on('change', function() {
	//     var checked = this.checked
	//     if (checked == true) {
	//     	general = 1;
	//     	var htmlCampoLogoEmpresa =
	// 		"<label>Logo de Empresa</label>"+
	// 		"<button class='botonLogoEmpresa'>";
	// 		$(".campoLogoEmpresa").html(htmlCampoLogoEmpresa);

	// 		var htmlBotonImprimirCotiz =
 //            "<button type='button' class='btn btn-outline-success'  onclick='imprimirCotizacion("+general+");' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
 //            $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);
	//     }
	//     else{
	//     	$(".campoLogoEmpresa").html("");
	//     }
	// });

	$('#nombreEmpresaCheckUnica').on('change', function() {
	    var checked = this.checked
	    if (checked == true) {
	    	general = 2
	    	var htmlCampoNombreEmpresa =
			"<label>Nombre de Empresa</label>"+
			"<input type='text' name='nombreEmpresaUnica' id='nombreEmpresaUnica' class='form-control'>";
			$(".campoNombreEmpresaUnica").html(htmlCampoNombreEmpresa);

			var htmlBotonImprimirCotiz =
            "<button type='button' class='btn btn-outline-success'  onclick='imprimirCotizacion("+general+");' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
            $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);
	    }
	    else{
	    	$(".campoNombreEmpresaUnica").html("");
	    }
	});

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_unica_motrar_todas.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["cotizaciones_unicas"];
                // console.log(resultados);
                var opcionesFolioCotizacionesImprimirUnica = "<option value='-1' folio=''>Cotizaciones *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idCotizacionUnica = resultadosTotales["idCotizacionUnica"];
                    var descripcion   = resultadosTotales["descripcion"];

                    opcionesFolioCotizacionesImprimirUnica += "<option value='"+idCotizacionUnica+"' desc='"+descripcion+"'>COTIZ00"+idCotizacionUnica+"</option>";
                }
                var htmlCotizacionesUnicas =
                "<label>Cotizaciones Encontradas</label>"+
                "<select name='cotizEncontradaImprimirUnica' class='form-control' id='cotizEncontradaImprimirUnica' onchange='mostrarBotones();'>"+opcionesFolioCotizacionesImprimirUnica+"</select>";
                $(".selectCotizEncontradaImprimirUnica").html(htmlCotizacionesUnicas);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosImprimirExcel(e){
	var idProveedorSeleccionada = $(e).val();

	var general = "";

	if (idProveedorSeleccionada == 2) {

		// var htmlCheckLogoEmpresa =
		// "<div class='checkbox'><label><input type='checkbox' name='logoEmpresaCheck' id='logoEmpresaCheck'>Logo</label></div>";
		// $(".checkLogoEmpresa").html(htmlCheckLogoEmpresa);

		var htmlCheckNombreEmpresa =
		"<div class='checkbox'><label><input type='checkbox' name='nombreEmpresaCheckExcel' id='nombreEmpresaCheckExcel'>Nombre</label></div>";
		$(".checkNombreEmpresaExcel").html(htmlCheckNombreEmpresa);

	}
	else{
		// $(".checkLogoEmpresa").html("");
		$(".checkNombreEmpresaExcel").html("");
	}

	// $('#logoEmpresaCheck').on('change', function() {
	//     var checked = this.checked
	//     if (checked == true) {
	//     	general = 1;
	//     	var htmlCampoLogoEmpresa =
	// 		"<label>Logo de Empresa</label>"+
	// 		"<button class='botonLogoEmpresa'>";
	// 		$(".campoLogoEmpresa").html(htmlCampoLogoEmpresa);

	// 		var htmlBotonImprimirCotiz =
 //            "<button type='button' class='btn btn-outline-success'  onclick='imprimirCotizacion("+general+");' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
 //            $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);
	//     }
	//     else{
	//     	$(".campoLogoEmpresa").html("");
	//     }
	// });

	$('#nombreEmpresaCheckExcel').on('change', function() {
	    var checked = this.checked
	    if (checked == true) {
	    	general = 2
	    	var htmlCampoNombreEmpresa =
			"<label>Nombre de Empresa</label>"+
			"<input type='text' value name='nombreEmpresaExcel' id='nombreEmpresaExcel' class='form-control'>";
			$(".campoNombreEmpresaExcel").html(htmlCampoNombreEmpresa);

			var htmlBotonImprimirCotiz =
            "<button type='button' class='btn btn-outline-success'  onclick='imprimirCotizacion("+general+");' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
            $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);
	    }
	    else{
	    	$(".campoNombreEmpresaExcel").html("");
	    }
	});

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_excel_mostrar_todas.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["cotizaciones_excel"];
                console.log(resultados);
                var opcionesFolioCotizacionesImprimirExcel = "<option value='-1'>Cotizaciones *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idCotizacionExcel = resultadosTotales["idCotizacionExcel"];
                    // var descripcion   = resultadosTotales["descripcion"];

                    opcionesFolioCotizacionesImprimirExcel += "<option value='"+idCotizacionExcel+"'>"+idCotizacionExcel+"</option>";
                }
                var htmlCotizacionesExcel =
                "<label>Cotizaciones Encontradas</label>"+
                "<select name='cotizEncontradaImprimirExcel' class='form-control' id='cotizEncontradaImprimirExcel' onchange='mostrarBotones();'>"+opcionesFolioCotizacionesImprimirExcel+"</select>";
                $(".selectCotizEncontradaImprimirExcel").html(htmlCotizacionesExcel);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION IMPRIMIR COTIZACION=======================================================================
function mostrarBotones(){
	var htmlBotonImprimirCotiz =
    "<button type='button' class='btn btn-outline-success'  onclick='imprimirCotizacion();' style='width: 100%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
    $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);

    var htmlBotonEnviarCorreoCotiz =
    "<button type='button' class='btn btn-outline-success'  onclick='enviarCorreoCotización();' style='width: 100%;'><img src='../iconos/correo-electronico.png' style='width: 40px;'>Enviar por correo</button>";
    $(".botonEnviarCorreoCotiz").html(htmlBotonEnviarCorreoCotiz);
}
//====================================================================================================

//FUNCION IMPRIMIR COTIZACION=======================================================================
function imprimirCotizacion(general){
	var idSelectTipo = $('#tipoCotizacionImprimir').val();
	var nombreProveedorImprimir = "";
	var folioCotizacionImprimir = "";
	var utilidadCotizacionImprimir = "";
	var firmaCotizacionImprimir = "";
	var logoEmpresa = "";
	var nombreEmpresa = "";
	var idCotizacionExcel = "";
	var idCotizacionUnica = "";

	// cotizacion unica====================================================================================
	if (idSelectTipo == 0) {
		if (general == 1) {
			nombreProveedorImprimir = $("#proveedor_imprimir_unica option:selected").attr("proveedor");
			idCotizacionUnica = $("#cotizEncontradaImprimirUnica").val();
			utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
			// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
			firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
			// var nombreEmpresaGeneral = $("#empresaSelectImprimir").val();
			logoEmpresa = $("#logoEmpresa").val();

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&idCotizacionUnica='+idCotizacionUnica+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir+'&&logo='+logoEmpresa);
		}
		else if (general == 2){
			nombreProveedorImprimir = $("#proveedor_imprimir_unica option:selected").attr("proveedor");
			idCotizacionUnica = $("#cotizEncontradaImprimirUnica").val();
			utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
			// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
			firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
			// var nombreEmpresaGeneral = $("#empresaSelectImprimir").val();
			nombreEmpresa = $("#nombreEmpresaUnica").val();

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&idCotizacionUnica='+idCotizacionUnica+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir+'&&nombreEmpresa='+nombreEmpresa);
		}

		nombreProveedorImprimir = $("#proveedor_imprimir_unica option:selected").attr("proveedor");
		idCotizacionUnica = $("#cotizEncontradaImprimirUnica").val();
		utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
		// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
		firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");

	    window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&idCotizacionUnica='+idCotizacionUnica+'&utilidad='+utilidadCotizacionImprimir+'&firma='+firmaCotizacionImprimir);
	}
	// cotizacion multiple====================================================================================
	// proveedor
	// utilidad
	// firma
	// folioCotizacionDetalle
	else if (idSelectTipo == 1) {
		if (general == 1) {
			nombreProveedorImprimir = $("#proveedor_imprimir option:selected").attr("proveedor");
			folioCotizacionImprimir = $("#cotizEncontradaImprimir option:selected").attr("folio");
			utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
			// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
			firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
			// var nombreEmpresaGeneral = $("#empresaSelectImprimir").val();
			logoEmpresa = $("#logoEmpresa").val();

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&folioCotizacionDetalle='+folioCotizacionImprimir+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir+'&&logo='+logoEmpresa);
		}
		else if (general == 2){
			nombreProveedorImprimir = $("#proveedor_imprimir option:selected").attr("proveedor");
			folioCotizacionImprimir = $("#cotizEncontradaImprimir option:selected").attr("folio");
			utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
			// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
			firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
			// var nombreEmpresaGeneral = $("#empresaSelectImprimir").val();
			nombreEmpresa = $("#nombreEmpresa").val();

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&folioCotizacionDetalle='+folioCotizacionImprimir+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir+'&&nombreEmpresa='+nombreEmpresa);
		}

		nombreProveedorImprimir = $("#proveedor_imprimir option:selected").attr("proveedor");
		folioCotizacionImprimir = $("#cotizEncontradaImprimir option:selected").attr("folio");
		utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
		// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
		firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");

	    window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&folioCotizacionDetalle='+folioCotizacionImprimir+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir);
	}
	// cotizacion excel masivas====================================================================================
	else if (idSelectTipo == 2) {
		if (general == 1) {
			nombreProveedorImprimir = $("#proveedor_imprimir option:selected").attr("proveedor");
			utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
			// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
			firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
			// var nombreEmpresaGeneral = $("#empresaSelectImprimir").val();
			logoEmpresa = $("#logoEmpresa").val();
			idCotizacionExcel = $("#cotizEncontradaImprimirExcel").val();

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir+'&&logo='+logoEmpresa);
		}
		else if (general == 2){
			nombreProveedorImprimir = $("#proveedor_imprimir option:selected").attr("proveedor");
			utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
			// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
			firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
			// var nombreEmpresaGeneral = $("#empresaSelectImprimir").val();
			nombreEmpresa = $("#nombreEmpresaExcel").val();
			idCotizacionExcel = $("#cotizEncontradaImprimirExcel").val();

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir+'&&nombreEmpresa='+nombreEmpresa);
		}

		nombreProveedorImprimir = $("#proveedor_imprimir_excel option:selected").attr("proveedor");
		utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
		// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
		firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
		idCotizacionExcel = $("#cotizEncontradaImprimirExcel").val();

	    window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir);
	}
	// cotizacion excel unica===============================================================================
	// else if (idSelectTipo == 3) {
	// 	if (general == 1) {
	// 		nombreProveedorImprimir = $("#proveedor_imprimir option:selected").attr("proveedor");
	// 		utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
	// 		// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
	// 		firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
	// 		// var nombreEmpresaGeneral = $("#empresaSelectImprimir").val();
	// 		logoEmpresa = $("#logoEmpresa").val();
	// 		idCotizacionExcel = $("#cotizEncontradaImprimirExcel").val();

	// 		window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&folioCotizacionDetalle='+folioCotizacionImprimir+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir+'&&general='+general+'&&logo='+logoEmpresa);
	// 	}
	// 	else if (general == 2){
	// 		nombreProveedorImprimir = $("#proveedor_imprimir option:selected").attr("proveedor");
	// 		utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
	// 		// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
	// 		firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
	// 		// var nombreEmpresaGeneral = $("#empresaSelectImprimir").val();
	// 		nombreEmpresa = $("#nombreEmpresaExcel").val();
	// 		idCotizacionExcel = $("#cotizEncontradaImprimirExcel").val();

	// 		window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&folioCotizacionDetalle='+folioCotizacionImprimir+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir+'&&general='+general+'&&nombreEmpresa='+nombreEmpresa);
	// 	}

	// 	nombreProveedorImprimir = $("#proveedor_imprimir_excel option:selected").attr("proveedor");
	// 	utilidadCotizacionImprimir   = $("#utilidad_cotiz") .val();
	// 	// var folioCheckCotizacionImprimir = $("#folioCotizImprimir").prop("checked");
	// 	firmaCotizacionImprimir = $("#firmaCotizImprimir").prop("checked");
	// 	idCotizacionExcel = $("#cotizEncontradaImprimirExcel").val();

	//     window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+nombreProveedorImprimir+'&&folioCotizacionDetalle='+folioCotizacionImprimir+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidadCotizacionImprimir+'&&firma='+firmaCotizacionImprimir);
	// }
}

//====================================================================================================

//EVENTO READY========================================================================================
$(document).ready(function(){
});
//====================================================================================================
</script>
