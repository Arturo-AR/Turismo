import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:tourism/src/common_widgets/form/form_divider_widget.dart';
import 'package:tourism/src/common_widgets/form/form_header_widget.dart';
import 'package:tourism/src/common_widgets/form/social_footer.dart';
import 'package:tourism/src/constants/images_strings.dart';
import 'package:tourism/src/constants/text_strings.dart';
import 'package:tourism/src/features/authentication/screens/login/widgets/login_form_widget.dart';
import 'package:tourism/src/features/authentication/screens/singup/signup_screen.dart';

class LoginScreen extends StatelessWidget {
  const LoginScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        body: SingleChildScrollView(
          child: Container(
            padding: const EdgeInsets.all(20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const FormHeaderWidget(image: aAppLogo, title: aLoginTitle, subTitle: aLoginSubTitle),
                const LoginFormWidget(),
                const AFormDividerWidget(),
                SocialFooter(text1: aDontHaveAnAccount, text2: aSignup, onPressed: () => Get.off(() => const SignupScreen())),
              ],
            ),
          ),
        ),
      ),
    );
  }
}