import 'package:exploring/src/features/core/models/location_selector_model.dart';
import 'package:get/get.dart';

class LocationSelectorController extends GetxController {
  static LocationSelectorController get instance => Get.find();
  String scannedQrCode = '';
  var locationIndex = 0.obs;

  var countriesList = <LocationSelectorModel>[
    LocationSelectorModel(1, "Mexico"),
    LocationSelectorModel(2, "Cuba"),
    LocationSelectorModel(3, "Estados Unidos"),
  ].obs;

  var statesList = <LocationSelectorModel>[
    LocationSelectorModel(1, "Michoacan"),
    LocationSelectorModel(2, "Jalisco"),
    LocationSelectorModel(3, "Guanajuato"),
  ].obs;

  var townsList = <LocationSelectorModel>[
    LocationSelectorModel(1, "Huandacareo"),
    LocationSelectorModel(2, "Morelia"),
    LocationSelectorModel(3, "Puruandiro"),
  ].obs;

}
