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
      isLoading.value = true;
      if (!loginFormKey.currentState!.validate()) {
        isLoading.value = false;
        return;
      }
      final auth = AuthenticationRepository.instance;
      await auth.loginWithEmailAndPassword(email.text.trim(), password.text.trim());
      //print(auth.userId);
      //auth.setInitialScreen(auth.userId);

    } catch (e) {
      isLoading.value = false;
      //Helper.errorSnackBar(title: tOhSnap, message: e.toString());
    }
  }
}
