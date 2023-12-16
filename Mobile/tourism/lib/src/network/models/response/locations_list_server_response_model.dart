class LocationServerResponse {
  late int? locationId;
  late String? locationName;

  LocationServerResponse({
    this.locationId,
    this.locationName,
  });

  factory LocationServerResponse.fromJsonMap(Map<String, dynamic> json) {
    LocationServerResponse locationListResponse = LocationServerResponse(
      locationId: json['locationId'] ?? -1,
      locationName: json['locationName'] ?? '',
    );
    return locationListResponse;
  }
}