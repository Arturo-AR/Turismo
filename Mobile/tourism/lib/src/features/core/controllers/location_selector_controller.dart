import 'package:exploring/src/features/core/models/location_selector_model.dart';
import 'package:get/get.dart';

import '../../../repository/locations_repository/locations_repository.dart';

class LocationSelectorController extends GetxController {
  static LocationSelectorController get instance => Get.find();

  late final LocationsRepository _locationRepository;

  LocationSelectorController() {
    _locationRepository = LocationsRepository();
  }

  String scannedQrCode = '';
  var locationIndex = 0.obs;

  var locationsList = <LocationSelectorModel>[].obs;

  Future<void> getLocationList(int id) async {
    print("Location with id: $id");
    try {
      //await Future.delayed(const Duration(milliseconds: 3000));
      /*locationsList.value = [
        LocationSelectorModel(1, "Mexico"),
        LocationSelectorModel(2, "Cuba"),
        LocationSelectorModel(3, "Estados Unidos"),
      ];*/
      _locationRepository.getLocationList().then((value) {
        List<LocationSelectorModel> newList = value.responseObject.map((dynamic item) => Todo.fromJson(item)).toList();
        locationsList.value = newList;
      });

    } catch (e) {
      throw Exception("error");
    }
  }

  @override
  void onReady() {
    getLocationList(-1);
  }
}
