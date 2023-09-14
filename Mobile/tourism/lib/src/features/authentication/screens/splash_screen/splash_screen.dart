import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:tourism/src/constants/images_strings.dart';
import 'package:tourism/src/features/authentication/controllers/splash_screen_controller.dart';

class SplashScreen extends StatelessWidget {
  SplashScreen({
    Key? key,
  }) : super(key: key);

  final controller = Get.put(SplashScreenController());

  @override
  Widget build(BuildContext context) {

    controller.startTransition();
    return const Scaffold(
      backgroundColor: Colors.white,
      body: Center(
        child:
        Expanded(child: Image(image: AssetImage(aAppLogo))),
      ),
    );
  }
}
