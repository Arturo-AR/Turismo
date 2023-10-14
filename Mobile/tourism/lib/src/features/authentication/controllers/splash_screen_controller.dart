import 'package:get/get.dart';
import 'package:exploring/src/features/authentication/screens/welcome/welcome_screen.dart';

class SplashScreenController extends GetxController {
  static SplashScreenController get find => Get.find();

  Future startTransition() async {
    await Future.delayed(const Duration(milliseconds: 3000));
    Get.off(const WelcomeScreen());
  }
}
