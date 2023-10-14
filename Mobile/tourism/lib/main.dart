import 'package:exploring/src/repository/authentication_repository/authentication_repository.dart';
import 'package:flutter/material.dart';
import 'package:exploring/app.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';

Future<void> main() async {
  //WidgetsBinding widgetsBinding = WidgetsFlutterBinding.ensureInitialized();

  /// -- README(Update[]) -- GetX Local Storage
  // Todo: Add Local Storage
  await GetStorage.init(); // se agrego

  /// -- README(Docs[1]) -- Await Splash until other items Load
  //FlutterNativeSplash.preserve(widgetsBinding: widgetsBinding);

  /// -- README(Docs[2]) -- Initialize Firebase & Authentication Repository
  /*await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform)
      .then((_) => Get.put(AuthenticationRepository()));*/
  Get.put(AuthenticationRepository());  // se agrego
  /// -- Main App Starts here (app.dart) ...
  runApp(const App());
}