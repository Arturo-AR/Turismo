import 'dart:convert';
import 'package:exploring/src/constants/text_strings.dart';
import 'package:exploring/src/network/models/request/login_server_request_model.dart';
import 'package:exploring/src/network/models/response/login_server_response_model.dart';
import 'package:exploring/src/network/models/main_server_response_model.dart';
import 'package:http/http.dart' as http;

class AuthRemoteDataSource {
  Future<MainServerResponse<LoginServerResponse>> login(
      LoginServerRequest loginRequestBody) async {
    const String requestUrl = '$baseUrl/exploring.php';
    var url = Uri.parse(requestUrl);
    final requestBody = jsonEncode(loginRequestBody.toJson());
    try {
      var response = await http.post(url, body: requestBody);
      if (response.statusCode == 200) {
        MainServerResponse<LoginServerResponse> loginServerResponse =
            MainServerResponse.fromJsonMap(jsonDecode(response.body));
        return loginServerResponse;
      } else {
        throw Exception("Error en el server");
      }
    } catch (e) {
      throw Exception("error en el catch");
    }
  }
}
