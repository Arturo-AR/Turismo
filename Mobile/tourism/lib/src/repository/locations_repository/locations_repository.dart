import 'package:exploring/src/network/locations_list_remote_datasource.dart';
import 'package:exploring/src/network/models/response/locations_list_server_response_model.dart';
import 'package:get/get.dart';
import '../../network/models/main_server_response_model.dart';
import '../../network/models/response/login_server_response_model.dart';

class LocationsRepository extends GetxController {
  static LocationsRepository get instance => Get.find();

  LocationsListRemoteDataSource locationListRemoteDataSource = LocationsListRemoteDataSource();

  Future<MainServerResponse<List<LocationServerResponse>>> getLocationList() {
    print("Entro al repository");
    return locationListRemoteDataSource.getLocationList();
  }

}
