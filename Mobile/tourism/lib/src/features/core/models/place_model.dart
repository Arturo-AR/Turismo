import 'package:exploring/src/constants/images_strings.dart';

class PlaceModel {
  final String image;
  final String title;
  final String description;

  PlaceModel(
    this.image,
    this.title,
    this.description,
  );

  static List<PlaceModel> list = [
    PlaceModel(aUnDiscoveredPlace, "???", "???"),
    PlaceModel(aUnDiscoveredPlace, "???", "???"),
    PlaceModel(aTemple, "Templo del Amparo", "Templo en la plaza principal"),
    PlaceModel(aUnDiscoveredPlace, "???", "???"),
    PlaceModel(aPool, "Vista Bella", "Una Alberca muy perrona"),
    PlaceModel(aUnDiscoveredPlace, "???", "???"),
    PlaceModel(aUnDiscoveredPlace, "???", "???"),
    PlaceModel(aEsperanza, "Plaza de toros", "Plaza de toros de huandacareo"),
  ];
}
