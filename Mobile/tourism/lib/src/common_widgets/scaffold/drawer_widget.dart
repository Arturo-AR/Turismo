import 'package:exploring/src/constants/colors.dart';
import 'package:exploring/src/features/authentication/screens/welcome/welcome_screen.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class ANavigationDrawer extends StatelessWidget {
  const ANavigationDrawer({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: ListView(
        padding: EdgeInsets.zero,
        children: [
          const UserAccountsDrawerHeader(
            accountName: Text("Arturo Anguiano",style: TextStyle(color: Colors.black),),
            accountEmail: Text("arturo@gmail.com",style: TextStyle(color: Colors.black)),
            /*currentAccountPicture: CircleAvatar(
              child: ClipOval(child: Image.asset(aProfileImage),),
            ),*/
            decoration: BoxDecoration(
              color: aPrimaryColor,
              //image: DecorationImage(image: AssetImage(aHeaderBg), fit: BoxFit.cover)
            ),
          ),
          ListTile(
            leading: const Icon(Icons.place),
            title: const Text("Places"),
            onTap: () {},
          ),
          const Divider(),
          ListTile(
            leading: const Icon(Icons.logout),
            title: const Text("LogOut"),
            onTap: () {
              Get.to(() => const WelcomeScreen());
            },
          ),
        ],
      ),
    );
  }
}
