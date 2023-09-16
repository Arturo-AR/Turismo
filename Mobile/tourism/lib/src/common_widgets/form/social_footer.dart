import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:exploring/src/common_widgets/buttons/clickable_richtext_widget.dart';
import 'package:exploring/src/common_widgets/buttons/social_button.dart';
import 'package:exploring/src/constants/colors.dart';
import 'package:exploring/src/constants/images_strings.dart';
import 'package:exploring/src/constants/text_strings.dart';

class SocialFooter extends StatelessWidget {
  const SocialFooter({
    Key? key,
    this.text1 = aDontHaveAnAccount,
    this.text2 = aSignup,
    required this.onPressed,
  }) : super(key: key);

  final String text1, text2;
  final VoidCallback onPressed;

  @override
  Widget build(BuildContext context) {
    //final controller = Get.put(LoginController());
    return Container(
      padding: const EdgeInsets.only(top: 20 * 1.5, bottom: 20),
      child: Column(
        children: [
          /*Obx(
                () => TSocialButton(
              image: tGoogleLogo,
              background: tGoogleBgColor,
              foreground: tGoogleForegroundColor,
              text: '${tConnectWith.tr} ${tGoogle.tr}',
              isLoading: controller.isGoogleLoading.value ? true : false,
              onPressed: controller.isFacebookLoading.value || controller.isLoading.value
                  ? () {}
                  : controller.isGoogleLoading.value
                  ? () {}
                  : () => controller.googleSignIn(),
            ),
          ),*/
          ASocialButton(
            image: aGoogleLogo,
            background: aGoogleBgColor,
            foreground: aGoogleForegroundColor,
            text: '${aConnectWith.tr} ${aGoogle.tr}',
            //isLoading: controller.isGoogleLoading.value ? true : false,
            /*onPressed: controller.isFacebookLoading.value || controller.isLoading.value
                ? () {}
                : controller.isGoogleLoading.value
                ? () {}
                : () => controller.googleSignIn(),*/
            onPressed: (){},
          ),
          const SizedBox(height: 10),
          /*Obx(
                () => TSocialButton(
              image: tFacebookLogo,
              foreground: tWhiteColor,
              background: tFacebookBgColor,
              text: '${tConnectWith.tr} ${tFacebook.tr}',
              isLoading: controller.isFacebookLoading.value ? true : false,
              onPressed: controller.isGoogleLoading.value || controller.isLoading.value
                  ? () {}
                  : controller.isFacebookLoading.value
                  ? () {}
                  : () => controller.facebookSignIn(),
            ),
          ),*/
          ASocialButton(
            image: aFacebookLogo,
            foreground: aWhiteColor,
            background: aFacebookBgColor,
            text: '${aConnectWith.tr} ${aFacebook.tr}',
            //isLoading: controller.isFacebookLoading.value ? true : false,
            /*onPressed: controller.isGoogleLoading.value || controller.isLoading.value
                ? () {}
                : controller.isFacebookLoading.value
                ? () {}
                : () => controller.facebookSignIn(),*/
            onPressed: (){},
          ),
          const SizedBox(height: 20 * 2),
          ClickableRichTextWidget(
            text1: text1.tr,
            text2: text2.tr,
            onPressed: onPressed,
          ),
        ],
      ),
    );
  }
}
