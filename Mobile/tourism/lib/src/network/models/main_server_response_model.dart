import 'package:exploring/src/network/models/response/login_server_response_model.dart';

class MainServerResponse<T> {
  late String responseCode;
  late String responseMessage;
  T? responseObject;

  MainServerResponse({
    required this.responseCode,
    required this.responseMessage,
    this.responseObject,
  });

  factory MainServerResponse.fromJsonMap(Map<String, dynamic> json) {
    MainServerResponse<T> responseServer = MainServerResponse(
        responseCode: json['response_code'],
        responseMessage: json['response_message']);

    if (T == LoginServerResponse) {
      responseServer.responseObject =
          LoginServerResponse.fromJsonMap(json['response_object']) as T?;
    }
    /*else if (T == HelpResponse) {
      responseServer.responseObject =
      HelpResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ErrorTypeResponse) {
      responseServer.responseObject =
      ErrorTypeResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == MenuResponse) {
      responseServer.responseObject =
      MenuResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ContratoResponse) {
      responseServer.responseObject =
      ContratoResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == InstruccionCodigoActivacionResponse) {
      responseServer.responseObject =
      InstruccionCodigoActivacionResponse.fromJsonMap(
          json['responseobject']) as T?;
    } else if (T == RegistroResponse) {
      responseServer.responseObject =
      RegistroResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ServiciosResponse) {
      responseServer.responseObject =
      ServiciosResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ServicioDetalleAccionesResponse) {
      responseServer.responseObject =
      ServicioDetalleAccionesResponse.fromJsonMap(json['responseobject'])
      as T?;
    } else if (T == ServicioDetallePagoResponse) {
      responseServer.responseObject =
      ServicioDetallePagoResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ServicioOpcionResponse) {
      responseServer.responseObject =
      ServicioOpcionResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ServicioResponse) {
      responseServer.responseObject =
      ServicioResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == FacturaResponse) {
      responseServer.responseObject =
      FacturaResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == CodigoBarrasResponse) {
      responseServer.responseObject =
      CodigoBarrasResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == PagoEncabezadoResponse) {
      responseServer.responseObject =
      PagoEncabezadoResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == TarjetaResponse) {
      responseServer.responseObject =
      TarjetaResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == PayResponse) {
      responseServer.responseObject =
      PayResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == LineasResponse) {
      responseServer.responseObject =
      LineasResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == RecargasResponse) {
      responseServer.responseObject =
      RecargasResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == CaracteristicasResponse) {
      responseServer.responseObject =
      CaracteristicasResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == PagoOxxoResponse) {
      responseServer.responseObject =
      PagoOxxoResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ConsumoResponse) {
      responseServer.responseObject =
      ConsumoResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == AgregarServicioResponse) {
      responseServer.responseObject =
      AgregarServicioResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == CentroCobroResponse) {
      responseServer.responseObject =
      CentroCobroResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ServicioCoberturaResponse) {
      responseServer.responseObject =
      ServicioCoberturaResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == MapaResponse) {
      responseServer.responseObject =
      MapaResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == CentroCobroDetalleResponse) {
      responseServer.responseObject =
      CentroCobroDetalleResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == FormaPagoResponse) {
      responseServer.responseObject =
      FormaPagoResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == PaqueteResponse) {
      responseServer.responseObject =
      PaqueteResponse.fromJson(json['responseobject']) as T?;
    } else if (T == PromocionResponse) {
      responseServer.responseObject =
      PromocionResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == TelevisionResponse) {
      responseServer.responseObject =
      TelevisionResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == ContrataTelevisionResponse) {
      responseServer.responseObject =
      ContrataTelevisionResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == DocumentoLegalResponse) {
      responseServer.responseObject =
      DocumentoLegalResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == CanalResponse) {
      responseServer.responseObject =
      CanalResponse.fromJsonMap(json['responseobject']) as T?;
    } else if (T == CanalProgramacionResponse) {
      responseServer.responseObject =
      CanalProgramacionResponse.fromJsonMap(json['responseobject']) as T?;
    }*/

    return responseServer;
  }
}
