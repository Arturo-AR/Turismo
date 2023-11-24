import 'package:exploring/src/network/models/request/login_server_request_model.dart';
import 'package:exploring/src/network/auth_remote_datasource.dart';
import 'package:exploring/src/repository/authentication_repository/authentication_repository.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class LoginController extends GetxController {
  static LoginController get instance => Get.find();

  AuthRemoteDataSource authRemoteDataSource = AuthRemoteDataSource();
  late final AuthenticationRepository _authRepository;

  LoginController() {
    _authRepository = AuthenticationRepository();
  }

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
      //await auth.loginWithEmailAndPassword(email.text.trim(), password.text.trim());
      LoginServerRequest loginServerRequest =
          LoginServerRequest(email.text.trim(), password.text.trim());

      print(loginServerRequest.toJson().toString());
      _authRepository.login(loginServerRequest).then((value) {
        print("User Id: ${value.responseObject?.userId}");
        print("User Name: ${value.responseObject?.userName}");
        _authRepository.setInitialScreen(value.responseObject?.userId);
      });
    } catch (e) {
      //isLoading.value = false;
      //Helper.errorSnackBar(title: tOhSnap, message: e.toString());
      throw Exception("error");
    }
  }
}
