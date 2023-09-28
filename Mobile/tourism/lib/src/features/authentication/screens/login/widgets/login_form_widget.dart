import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:exploring/src/constants/text_strings.dart';
import 'package:exploring/src/features/core/screens/places_screen.dart';

class LoginFormWidget extends StatelessWidget {
  const LoginFormWidget({
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    //final controller = Get.put(LoginController());
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 30),
      child: Form(
        //key: controller.loginFormKey,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            /// -- Email Field
            TextFormField(
              //validator: Helper.validateEmail,
              //controller: controller.email,
              decoration:
              const InputDecoration(prefixIcon: Icon(LineAwesomeIcons.user), labelText: aEmail, hintText: aEmail),
            ),
            const SizedBox(height: 10),

            /// -- Password Field
           /* Obx(
                  () => TextFormField(
                controller: controller.password,
                validator: (value) {
                  if (value!.isEmpty) return 'Enter your password';
                  return null;
                },
                obscureText: controller.showPassword.value ? false : true,
                decoration: InputDecoration(
                  prefixIcon: const Icon(Icons.fingerprint),
                  labelText: tPassword,
                  hintText: tPassword,
                  suffixIcon: IconButton(
                    icon: controller.showPassword.value
                        ? const Icon(LineAwesomeIcons.eye)
                        : const Icon(LineAwesomeIcons.eye_slash),
                    onPressed: () => controller.showPassword.value = !controller.showPassword.value,
                  ),
                ),
              ),
            ),*/
            TextFormField(
              //controller: controller.password,
              validator: (value) {
                if (value!.isEmpty) return 'Enter your password';
                return null;
              },
              //obscureText: controller.showPassword.value ? false : true,
              decoration: InputDecoration(
                prefixIcon: const Icon(Icons.fingerprint),
                labelText: aPassword,
                hintText: aPassword,
                suffixIcon: IconButton(
                  icon: const Icon(LineAwesomeIcons.eye),
                  onPressed: () {},
                ),
              ),
            ),
            const SizedBox(height: 10),

            /// -- FORGET PASSWORD BTN
           /* Align(
              alignment: Alignment.centerRight,
              child: TextButton(
                //onPressed: () => ForgetPasswordScreen.buildShowModalBottomSheet(context),
                onPressed: () {},
                child: const Text(aForgetPassword),
              ),
            ),*/

            /// -- LOGIN BTN
            /*Obx(
                  () => TPrimaryButton(
                isLoading: controller.isLoading.value ? true : false,
                text: tLogin.tr,
                onPressed: controller.isFacebookLoading.value || controller.isGoogleLoading.value
                    ? () {}
                    : controller.isLoading.value
                    ? () {}
                    : () => controller.login(),
              ),
            ),*/
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: () => Get.offAll(() => PlacesScreen()),
                child: Text(aLogin.tr.toUpperCase()),
              ),
            )
          ],
        ),
      ),
    );
  }
}
