class User {
  final String? id;
  final String fullName;
  final String email;
  final String phoneNo;
  final String password;

  /// Constructor
  const User(
      {this.id, required this.email, required this.password, required this.fullName, required this.phoneNo});

  /// convert model to Json structure so that you can it to store data in Firesbase
  toJson() {
    return {
      "FullName": fullName,
      "Email": email,
      "Phone": phoneNo,
      "Password": password,
    };
  }

}
