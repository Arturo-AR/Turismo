abstract class LocalRepositoryInterface {
  Future<int> saveUserId(int userId);
  Future<int?> getUserId();
  Future<String> saveUserName(String userName);
  Future<String?> getUserName();
  Future<void> clearAllData();
  //Future<void> saveDarkMode(bool darkMode);
  //Future<bool> isDarkMode();
}