import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:tourism/src/common_widgets/buttons/clickable_richtext_widget.dart';
import 'package:tourism/src/common_widgets/form/form_divider_widget.dart';
import 'package:tourism/src/common_widgets/form/form_header_widget.dart';
import 'package:tourism/src/common_widgets/form/social_footer.dart';
import 'package:tourism/src/constants/images_strings.dart';
import 'package:tourism/src/constants/text_strings.dart';
import 'package:tourism/src/features/authentication/screens/login/login_screen.dart';
import 'package:tourism/src/features/authentication/screens/singup/widgets/signup_form_widget.dart';

class SignupScreen extends StatelessWidget {
  const SignupScreen({Key? key}) : super(key: key);

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
                const FormHeaderWidget(
                    image: aAppImage, title: aSignUpTitle, subTitle: aSignUpSubTitle, imageHeight: 0.1),
                const SignUpFormWidget(),
                //const AFormDividerWidget(),
                //SocialFooter(text1: aAlreadyHaveAnAccount, text2: aLogin, onPressed: () => Get.off(() => const LoginScreen())),
                ClickableRichTextWidget(
                  text1: aAlreadyHaveAnAccount.tr,
                  text2: aLogin.tr,
                  onPressed: () => Get.off(() => const LoginScreen()),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
