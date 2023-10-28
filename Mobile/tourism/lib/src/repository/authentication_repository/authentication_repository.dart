import 'package:exploring/src/features/authentication/screens/welcome/welcome_screen.dart';
import 'package:exploring/src/features/core/screens/places_screen.dart';
import 'package:get/get.dart';
// se agrego este archivo
class AuthenticationRepository extends GetxController {
  static AuthenticationRepository get instance => Get.find();


  int? userId;

  /// Loads when app Launch from main.dart
  @override
  void onReady() {
    //Get UserId from get_storage
    int? userId;
    setInitialScreen(userId);
  }

  /// Setting initial screen
  setInitialScreen(int? userId) async {
    userId == null
        ? Get.offAll(() => const WelcomeScreen())
        : Get.offAll(() => PlacesScreen());

  }

  Future<void> loginWithEmailAndPassword(String email, String password) async {
    userId = 3;
    await Future.delayed(const Duration(milliseconds: 3000));
    print("Entro al login en repositorio despues de un segundo");
    /*try{
      userId.value = 3;
      print("Despues de asignar valor");
      await Future.delayed(const Duration(milliseconds: 3000));
      print("despues de los 3 segundos");
    }catch(e){
      throw e.toString();
    }*/
  }
}