class User {
  final int userId;
  final String userFirstName;
  final String userLastName;
  final String userEmail;
  final String userPassword;
  final String userPhoneNumber;
  final int userAge;

  /// Constructor
  const User({
    required this.userId,
    required this.userFirstName,
    required this.userLastName,
    required this.userEmail,
    required this.userPassword,
    required this.userPhoneNumber,
    required this.userAge,
  });

  /// convert model to Json structure so that you can it to store data
  toJson() {
    return {
      "userId": userId,
      "userFirstName": userFirstName,
      "userLastName": userLastName,
      "userEmail": userEmail,
      "userPassword": userPassword,
      "userPhoneNumber": userPhoneNumber,
      "userAge": userAge,
    };
  }
}
