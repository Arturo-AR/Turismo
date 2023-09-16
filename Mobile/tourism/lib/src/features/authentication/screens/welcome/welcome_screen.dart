import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:tourism/src/constants/colors.dart';
import 'package:tourism/src/constants/images_strings.dart';
import 'package:tourism/src/constants/text_strings.dart';
import 'package:tourism/src/features/authentication/screens/login/login_screen.dart';
import 'package:tourism/src/features/authentication/screens/singup/signup_screen.dart';
import 'package:tourism/src/features/core/screens/places_screen.dart';

class WelcomeScreen extends StatelessWidget {
  const WelcomeScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    //final controller = Get.put(FadeInAnimationController());
    //controller.animationIn();

    var mediaQuery = MediaQuery.of(context);
    var width = mediaQuery.size.width;
    var height = mediaQuery.size.height;
    var brightness = mediaQuery.platformBrightness;
    final isDarkMode = brightness == Brightness.dark;

    return SafeArea(
      child: Scaffold(
        backgroundColor: isDarkMode ? aSecondaryColor : aBackGroundColor,
        //backgroundColor: aBackGroundColor,
        body: Stack(
          children: [
            Container(
              padding: const EdgeInsets.all(20),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  Hero(
                      tag: 'welcome-image-tag',
                      child: Image(
                          image: const AssetImage(aAppImage),
                          width: width * 0.7,
                          height: height * 0.4)),
                  Column(
                    children: [
                      Text(aWelcomeTitle,
                          style: Theme.of(context).textTheme.displayMedium),
                      Text(aWelcomeSubTitle,
                          style: Theme.of(context).textTheme.bodyLarge,
                          textAlign: TextAlign.center),
                    ],
                  ),
                  Column(
                    children: [
                      Row(
                        children: [
                          Expanded(
                            child: OutlinedButton(
                              onPressed: () => Get.to(() => const LoginScreen()),
                              //onPressed: () {},
                              child: Text(aLogin.toUpperCase()),
                            ),
                          ),
                          const SizedBox(width: 10.0),
                          Expanded(
                            child: ElevatedButton(
                              onPressed: () => Get.to(() => const SignupScreen()),
                              //onPressed: () {},
                              child: Text(aSignup.toUpperCase()),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          ElevatedButton(
                            onPressed: () => Get.offAll(() => const PlacesScreen()),
                            //onPressed: () {},
                            child: Padding(
                              padding: const EdgeInsets.symmetric(horizontal: 16.0),
                              child: Text(aGuest.toUpperCase()),
                            ),
                          ),
                        ],
                      ),
                    ],
                  )
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
