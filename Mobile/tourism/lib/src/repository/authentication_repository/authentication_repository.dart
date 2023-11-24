import 'package:exploring/src/network/models/request/login_server_request_model.dart';
import 'package:exploring/src/features/authentication/models/user_model.dart';
import 'package:exploring/src/features/authentication/screens/welcome/welcome_screen.dart';
import 'package:exploring/src/features/core/screens/places_screen.dart';
import 'package:exploring/src/network/auth_remote_datasource.dart';
import 'package:exploring/src/network/models/response/login_server_response_model.dart';
import 'package:exploring/src/network/models/main_server_response_model.dart';
import 'package:get/get.dart';

class AuthenticationRepository extends GetxController {
  static AuthenticationRepository get instance => Get.find();

  AuthRemoteDataSource authRemoteDataSource = AuthRemoteDataSource();

  /// Variables
  late final Rx<User?> _user;

  /// Getters
  User? get user => _user.value;

  int get getUserID => user?.userId ?? -1;

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

  /* ---------------------------- Email & Password sign-in ---------------------------------*/

  /// [EmailAuthentication] - LOGIN
  ///


  Future<MainServerResponse<LoginServerResponse>> login(
      LoginServerRequest loginRequestBody) {
    print("Entro al repository");
    return authRemoteDataSource.login(loginRequestBody);
  }

}
