class LoginServerRequest {
  String userEmail;
  String userPassword;

  LoginServerRequest(this.userEmail, this.userPassword);

  Map<String, dynamic> toJson() => {
        'user_email': userEmail,
        'user_password': userPassword,
      };
}
