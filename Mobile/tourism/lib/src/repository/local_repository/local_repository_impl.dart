import 'package:exploring/src/repository/local_repository_interface/local_repository_interface.dart';
import 'package:shared_preferences/shared_preferences.dart';

const _pref_user_id = 'USERID';
const _pref_username = 'USERNAME';

class LocalRepositoryImpl extends LocalRepositoryInterface {
  @override
  Future<void> clearAllData() async {
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    sharedPreferences.clear();
  }

  @override
  Future<String?> getUserName() async {
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    return sharedPreferences.getString(_pref_username);
  }

  @override
  Future<int?> getUserId() async {
    print("Entro al shared");
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    return sharedPreferences.getInt(_pref_user_id);
  }

  @override
  Future<int> saveUserId(int userId) async {
    print("save $userId");
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    sharedPreferences.setInt(_pref_user_id, userId);
    return userId;
  }



  @override
  Future<String> saveUserName(String userName) async {
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    sharedPreferences.setString(_pref_username,userName);
    return userName;
  }

  /*@override
  Future<bool> isDarkMode() async {
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    return sharedPreferences.getBool(_pref_dark_theme) ?? false;
  }*/

  /*@override
  Future<void> saveDarkMode(bool darkMode) async {
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    sharedPreferences.setBool(_pref_dark_theme, darkMode);
  }*/
}
