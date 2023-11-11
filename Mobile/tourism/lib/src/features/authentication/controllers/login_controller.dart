import 'package:exploring/src/features/authentication/models/login_request_model.dart';
import 'package:exploring/src/network/models/main_server_response.dart';
import 'package:exploring/src/network/models/server_response.dart';
import 'package:exploring/src/repository/authentication_repository/authentication_repository.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
// se agrego este archivo
class LoginController extends GetxController {
  static LoginController get instance => Get.find();

  /// TextField Controllers to get data from TextFields
  final showPassword = false.obs;
  final email = TextEditingController();
  final password = TextEditingController();
  GlobalKey<FormState> loginFormKey = GlobalKey<FormState>();

  /// Loader
  final isLoading = false.obs;

  /// [EmailAndPasswordLogin]
  Future<void> login() async {
    print("entro al login de loginController");
    try {
      final auth = AuthenticationRepository.instance;
      //await auth.loginWithEmailAndPassword(email.text.trim(), password.text.trim());
      LoginRequest loginRequest = LoginRequest(email.text.trim(), password.text.trim());

      auth.login(loginRequest).then((value) {
        //print(auth.userId);
        auth.setInitialScreen(value.responseObject?.userid);
      });
      //print(auth.userId);
      //auth.setInitialScreen(auth.userId);

    } catch (e) {
      //isLoading.value = false;
      //Helper.errorSnackBar(title: tOhSnap, message: e.toString());
      throw Exception("error");
    }
  }
}
