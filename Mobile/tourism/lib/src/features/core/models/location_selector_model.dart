import 'package:exploring/src/network/locations_list_remote_datasource.dart';
import 'package:exploring/src/network/models/response/locations_list_server_response_model.dart';

class LocationSelectorModel {
  final int id;
  final String name;

  LocationSelectorModel(
      this.id,
      this.name,
      );

  factory LocationSelectorModel.fromLocationServer(List<LocationServerResponse> list) {
    List<LocationSelectorModel> finalList = [];
    Set<LocationServerResponse> set = Set.from(list);
    for (var element in set) {
      finalList.add(LocationSelectorModel(element.locationId!, element.locationName!));
    }
    return finalList;
  }
}
