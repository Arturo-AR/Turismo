import 'package:flutter/material.dart';
import 'package:tourism/app.dart';

Future<void> main() async {
  //WidgetsBinding widgetsBinding = WidgetsFlutterBinding.ensureInitialized();

  /// -- README(Update[]) -- GetX Local Storage
  // Todo: Add Local Storage

  /// -- README(Docs[1]) -- Await Splash until other items Load
  //FlutterNativeSplash.preserve(widgetsBinding: widgetsBinding);

  /// -- README(Docs[2]) -- Initialize Firebase & Authentication Repository
  /*await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform)
      .then((_) => Get.put(AuthenticationRepository()));*/

  /// -- Main App Starts here (app.dart) ...
  runApp(const App());
}