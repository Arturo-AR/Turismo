import 'dart:convert';
import 'package:exploring/src/constants/text_strings.dart';
import 'package:exploring/src/features/authentication/models/login_request_model.dart';
import 'package:exploring/src/network/models/main_server_response.dart';
import 'package:exploring/src/network/models/server_response.dart';
import 'package:http/http.dart' as http;

class AuthRemoteDataSource {

  Future<ServerResponse<MainServerResponse>> login(
      LoginRequest loginRequestBody) async {

    const String requestUrl = '$baseUrl/exploring.php';

    var url = Uri.parse(requestUrl);

    final requestBody = jsonEncode(loginRequestBody.toJson());

    try{
      var response = await http.post(url,
          body: requestBody);

      if (response.statusCode == 200) {

        ServerResponse<MainServerResponse> responseServer =
        ServerResponse.fromJsonMap(jsonDecode(response.body));
        return responseServer;
      } else {

        throw Exception("Error en el server");
      }
    }catch(e) {
      throw Exception("error en el catch");
    }

  }

}