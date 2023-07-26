import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:tourism/src/utils/tmp/tmp_items_screen.dart';
import 'package:tourism/src/utils/tmp/tmp_screens_screen.dart';

class TmpScreen extends StatelessWidget {
  const TmpScreen({
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        body: SingleChildScrollView(
          child: Container(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text("Temp Screen"),
                ElevatedButton(onPressed: () => Get.to(() => const TmpThemeItemsScreen()), child: const Text("Theme Items")),
                ElevatedButton(onPressed: () => Get.to(() => const TmpScreensScreen()), child: const Text("Screens")),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
