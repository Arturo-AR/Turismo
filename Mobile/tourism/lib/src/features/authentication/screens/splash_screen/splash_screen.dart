import 'package:flutter/material.dart';
import 'package:tourism/src/constants/images_strings.dart';

class SplashScreen extends StatelessWidget {
  const SplashScreen({
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {

    return const Scaffold(
      backgroundColor: Colors.white,
      body: Center(
        child:
        Expanded(child: Image(image: AssetImage(aAppLogo))),
      ),
    );
  }
}
