import 'package:exploring/src/features/core/models/place_model.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/services.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:get/get.dart';

class QrScannerController extends GetxController {
  static QrScannerController get instance => Get.find();
  String scannedQrCode = '';

  var  listNetwork = <PlaceModel>[
    PlaceModel(
        "https://blog.vivaaerobus.com/wp-content/uploads/2020/08/que-hacer-en-yucatan.jpg",
        "Piramide del sol",
        "PDS",
        "Una piramide muy antigua de mexico",
        true),
    PlaceModel(
        "https://cbb.edu.pe/wp-content/uploads/2023/01/Cuales-son-los-mejores-lugares-turisticos-del-Peru-que-mas-se-visitan.jpg",
        "Cara de Peru",
        "CDP",
        "Montanas que parecen caras en Peru",
        true),
    PlaceModel(
        "https://cdn.inteligenciaviajera.com/wp-content/uploads/2020/04/sitios-turisticos-2.jpg",
        "Templo del Amparo",
        "TDA",
        "Templo en la plaza principal",
        false),
    PlaceModel(
        "https://esta.click/templates/yootheme/cache/77/viajar_a_California-773f9d54.jpeg",
        "Puente rojo",
        "PR",
        "Famoso puente rojo que esta en san francisco",
        true),
    PlaceModel(
        "https://www.nextibs.com/wp-content/uploads/2019/02/colosseum-3012088_1920.jpg",
        "Vista Bella",
        "VB",
        "Una Alberca muy perrona",
        true),
    PlaceModel("https://uneg.edu.mx/wp-content/uploads/2023/04/P10-1-min.jpg",
        "Piramide de la luna",
        "PDLL",
        "Piramide que esta en mexico muy bonita",
        false),
    PlaceModel(
        "https://content.skyscnr.com/m/25adda91669a1d75/original/GettyImages-466024975_doc.jpg",
        "Moais",
        "M",
        "Caras moais que estan en la isla de hawai",
        false),
    PlaceModel(
        "https://www.mexicodesconocido.com.mx/wp-content/uploads/2021/05/aguascalientes-7-imperdibles.jpg",
        "Plaza de toros",
        "PDT",
        "Plaza de toros de huandacareo",
        true),PlaceModel(
        "https://blog.vivaaerobus.com/wp-content/uploads/2020/08/que-hacer-en-yucatan.jpg",
        "Piramide del sol",
        "PDS",
        "Una piramide muy antigua de mexico",
        true),
    PlaceModel(
        "https://cbb.edu.pe/wp-content/uploads/2023/01/Cuales-son-los-mejores-lugares-turisticos-del-Peru-que-mas-se-visitan.jpg",
        "Cara de Peru",
        "CDP",
        "Montanas que parecen caras en Peru",
        true),
    PlaceModel(
        "https://cdn.inteligenciaviajera.com/wp-content/uploads/2020/04/sitios-turisticos-2.jpg",
        "Templo del Amparo",
        "TDA",
        "Templo en la plaza principal",
        false),
    PlaceModel(
        "https://esta.click/templates/yootheme/cache/77/viajar_a_California-773f9d54.jpeg",
        "Puente rojo",
        "PR",
        "Famoso puente rojo que esta en san francisco",
        true),
    PlaceModel(
        "https://www.nextibs.com/wp-content/uploads/2019/02/colosseum-3012088_1920.jpg",
        "Vista Bella",
        "VB",
        "Una Alberca muy perrona",
        true),
    PlaceModel("https://uneg.edu.mx/wp-content/uploads/2023/04/P10-1-min.jpg",
        "Piramide de la luna",
        "PDLL",
        "Piramide que esta en mexico muy bonita",
        false),
    PlaceModel(
        "https://content.skyscnr.com/m/25adda91669a1d75/original/GettyImages-466024975_doc.jpg",
        "Moais",
        "M",
        "Caras moais que estan en la isla de hawai",
        false),
    PlaceModel(
        "https://www.mexicodesconocido.com.mx/wp-content/uploads/2021/05/aguascalientes-7-imperdibles.jpg",
        "Plaza de toros",
        "PDT",
        "Plaza de toros de huandacareo",
        true),
  ].obs;

  void unLockPlace(int index, bool unLocked)  {
    listNetwork[index].discovered = unLocked;
  }

  Future<void> scanQR() async {
    try {
      scannedQrCode = await FlutterBarcodeScanner.scanBarcode(
        "#ff6666", "cancel", true, ScanMode.QR,);
      var index = listNetwork.indexWhere((element) => element.qrCode == scannedQrCode);
      if (index != -1) {
        listNetwork[index].discovered = true;
        notifyChildrens();
      } else {
        Get.snackbar("Qr Invalido",scannedQrCode, snackPosition: SnackPosition.BOTTOM);
      }

    } on PlatformException {
      if (kDebugMode) {
        print("Error");
      }
    }
  }
}