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

  static List<PlaceModel> listNetwork = [
    PlaceModel("https://blog.vivaaerobus.com/wp-content/uploads/2020/08/que-hacer-en-yucatan.jpg", "???", "???"),
    PlaceModel("https://cbb.edu.pe/wp-content/uploads/2023/01/Cuales-son-los-mejores-lugares-turisticos-del-Peru-que-mas-se-visitan.jpg", "???", "???"),
    PlaceModel("https://cdn.inteligenciaviajera.com/wp-content/uploads/2020/04/sitios-turisticos-2.jpg", "Templo del Amparo", "Templo en la plaza principal"),
    PlaceModel("https://esta.click/templates/yootheme/cache/77/viajar_a_California-773f9d54.jpeg", "???", "???"),
    PlaceModel("https://www.nextibs.com/wp-content/uploads/2019/02/colosseum-3012088_1920.jpg", "Vista Bella", "Una Alberca muy perrona"),
    PlaceModel("https://uneg.edu.mx/wp-content/uploads/2023/04/P10-1-min.jpg", "???", "???"),
    PlaceModel("https://content.skyscnr.com/m/25adda91669a1d75/original/GettyImages-466024975_doc.jpg", "???", "???"),
    PlaceModel("https://www.mexicodesconocido.com.mx/wp-content/uploads/2021/05/aguascalientes-7-imperdibles.jpg", "Plaza de toros", "Plaza de toros de huandacareo"),
  ];
}
