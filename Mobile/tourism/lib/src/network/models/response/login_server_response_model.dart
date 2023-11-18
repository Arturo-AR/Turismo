class LoginServerResponse {
  late int? userId;
  late String? userName;

  LoginServerResponse({
    this.userId,
    this.userName,
  });

  factory LoginServerResponse.fromJsonMap(Map<String, dynamic> json) {
    LoginServerResponse loginResponse = LoginServerResponse(
      userId: json['user_id'] ?? -1,
      userName: json['user_name'] ?? '',
    );

    return loginResponse;
  }
}
