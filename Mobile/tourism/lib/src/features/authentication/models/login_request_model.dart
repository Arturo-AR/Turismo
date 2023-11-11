class LoginRequest {
  String userEmail;
  String userPassword;

  LoginRequest(this.userEmail, this.userPassword);

  Map<String, dynamic> toJson() => {
        'user_email': userEmail,
        'user_password': userPassword,
      };
}
