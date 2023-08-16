import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:tourism/src/utils/theme/theme.dart';
import 'package:tourism/src/utils/tmp/main_tmp_screen.dart';

class App extends StatelessWidget {
  const App({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      /// -- README(Docs[3]) -- Bindings
      //initialBinding: InitialBinding(),
      themeMode: ThemeMode.system,
      theme: AAppTheme.lightTheme,
      darkTheme: AAppTheme.darkTheme,
      debugShowCheckedModeBanner: false,
      home: const Scaffold(body: Center(child: TmpScreen())),
    );
  }
}
