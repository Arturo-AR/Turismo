import 'package:exploring/src/constants/text_strings.dart';
import 'package:exploring/src/network/models/main_server_response_model.dart';
import 'package:exploring/src/network/models/response/locations_list_server_response_model.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class LocationsListRemoteDataSource {
  Future<MainServerResponse<List<LocationServerResponse>>> getLocationList() async {
    const String requestUrl = '$baseUrl/exploring_countrys.php';
    var url = Uri.parse(requestUrl);
    try {
      var response = await http.post(url);
      if (response.statusCode == 200) {
        print("response from server");
        print(jsonDecode(response.body));
        MainServerResponse<LocationServerResponse> locationListServerResponse =
        MainServerResponse.fromJsonMap(jsonDecode(response.body));
        print(locationListServerResponse.responseObject.toString());
        return locationListServerResponse;
      } else {
        throw Exception("Error en el server");
      }
    } catch (e) {
      throw Exception("error en el catch");
    }
  }
}
