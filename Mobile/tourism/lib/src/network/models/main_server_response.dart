class MainServerResponse {
  late String? version;
  late String? platformType;
  late int? userid;
  late String? nombreUsuario;
  late String? message;

  MainServerResponse(
      {this.version,
        this.platformType,
        this.userid,
        this.nombreUsuario,
        this.message});

  factory MainServerResponse.fromJsonMap(Map<String, dynamic> json) {
    MainServerResponse loginResponse = MainServerResponse(
        version: json['version'],
        platformType: json['platformtype'],
        userid: json['user_id'] ?? '',
        nombreUsuario: json['nombre'] ?? '',
        message: json['message']);

    return loginResponse;
  }
}