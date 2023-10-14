import 'package:exploring/src/common_widgets/scaffold/app_bar_widget.dart';
import 'package:exploring/src/features/core/controllers/places_controller.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class PlaceDetailsScreen extends StatelessWidget {
  PlaceDetailsScreen({Key? key}) : super(key: key);
  final placeController = Get.put(PlacesController());

  @override
  Widget build(BuildContext context) {
    //var isDark = MediaQuery.of(context).platformBrightness == Brightness.dark;
    return Scaffold(
      appBar: AAppBarWidget(
        title: placeController.listNetwork[placeController.placeDetail].title,
      ),
      body: SingleChildScrollView(
        child: Container(
          padding: const EdgeInsets.all(20),
          child: Column(
            children: [
              Image.network(
                placeController.listNetwork[placeController.placeDetail].image,
                fit: BoxFit.cover,
              ),
              Text(placeController.listNetwork[placeController.placeDetail].description)
              /* /// -- IMAGE with ICON
              const ImageWithIcon(),
              const SizedBox(height: 10),
              Text(tProfileHeading, style: Theme.of(context).textTheme.headlineMedium),
              Text(tProfileSubHeading, style: Theme.of(context).textTheme.bodyMedium),
              const SizedBox(height: 20),

              /// -- BUTTON
              TPrimaryButton(
                  isFullWidth: false,
                  width: 200,
                  text: tEditProfile,
                  onPressed: () => Get.to(() => UpdateProfileScreen())
              ),
              const SizedBox(height: 30),
              const Divider(),
              const SizedBox(height: 10),

              /// -- MENU
              ProfileMenuWidget(title: "Settings", icon: LineAwesomeIcons.cog, onPress: () {}),
              ProfileMenuWidget(title: "Billing Details", icon: LineAwesomeIcons.wallet, onPress: () {}),
              ProfileMenuWidget(
                  title: "User Management", icon: LineAwesomeIcons.user_check, onPress: () => Get.to(() => AllUsers())),
              const Divider(),
              const SizedBox(height: 10),
              ProfileMenuWidget(title: "Information", icon: LineAwesomeIcons.info, onPress: () {}),
              ProfileMenuWidget(
                title: "Logout",
                icon: LineAwesomeIcons.alternate_sign_out,
                textColor: Colors.red,
                endIcon: false,
                onPress: () => _showLogoutModal(),
              ),*/
            ],
          ),
        ),
      ),
    );
  }

/*  _showLogoutModal() {
    Get.defaultDialog(
      title: "LOGOUT",
      titleStyle: const TextStyle(fontSize: 20),
      content: const Padding(
        padding: EdgeInsets.symmetric(vertical: 15.0),
        child: Text("Are you sure, you want to Logout?"),
      ),
      confirm: TPrimaryButton(
        isFullWidth: false,
        onPressed: () => AuthenticationRepository.instance.logout(),
        text: "Yes",
      ),
      cancel: SizedBox(width: 100, child: OutlinedButton(onPressed: () => Get.back(), child: const Text("No"))),
    );
  }*/
}
