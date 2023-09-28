import 'package:flutter/services.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:get/get.dart';

class QrScannerController extends GetxController {
  static QrScannerController get instance => Get.find();
  String scannedQrCode = '';

  Future<void> scanQR() async {
    try {
      scannedQrCode = await FlutterBarcodeScanner.scanBarcode(
        "#ff6666", "cancel", true, ScanMode.QR,);
      Get.snackbar("Qr Code",scannedQrCode, snackPosition: SnackPosition.BOTTOM);
    } on PlatformException {

    }
  }

}