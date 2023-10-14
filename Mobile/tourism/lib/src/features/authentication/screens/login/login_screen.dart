import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:exploring/src/common_widgets/buttons/clickable_richtext_widget.dart';
import 'package:exploring/src/common_widgets/form/form_header_widget.dart';
import 'package:exploring/src/constants/images_strings.dart';
import 'package:exploring/src/constants/text_strings.dart';
import 'package:exploring/src/features/authentication/screens/login/widgets/login_form_widget.dart';
import 'package:exploring/src/features/authentication/screens/singup/signup_screen.dart';

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
                const FormHeaderWidget(image: aAppImage, title: aLoginTitle, subTitle: aLoginSubTitle),
                const LoginFormWidget(),
                //const AFormDividerWidget(),
                //SocialFooter(text1: aDontHaveAnAccount, text2: aSignup, onPressed: () => Get.off(() => const SignupScreen())),
                ClickableRichTextWidget(
                  text1: aDontHaveAnAccount.tr,
                  text2: aSignup.tr,
                  onPressed: () => Get.off(() => const SignupScreen()),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}