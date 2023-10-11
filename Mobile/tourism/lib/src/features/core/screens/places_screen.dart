import 'package:exploring/src/common_widgets/scaffold/app_bar_widget.dart';
import 'package:exploring/src/common_widgets/scaffold/drawer_widget.dart';
import 'package:exploring/src/constants/colors.dart';
import 'package:exploring/src/constants/text_strings.dart';
import 'package:exploring/src/features/core/controllers/places_controller.dart';
import 'package:exploring/src/features/core/controllers/qr_scanner_controller.dart';
import 'package:exploring/src/features/core/models/place_model.dart';
import 'package:exploring/src/features/core/screens/place_details_screen.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class PlacesScreen extends StatelessWidget {
  PlacesScreen({Key? key}) : super(key: key);
  final controller = Get.put(QrScannerController());
  final placeController = Get.put(PlacesController());

  //final controllerPlaces = Get.put(PlacesController());

  @override
  Widget build(BuildContext context) {
    //Variables
    //final txtTheme = Theme.of(context).textTheme;
    final isDark = MediaQuery.of(context).platformBrightness ==
        Brightness.dark; //Dark mode

    //final list = PlaceModel.listNetwork;

    return Scaffold(
      appBar: const AAppBarWidget(
        title: "Places",
      ),
      drawer: const ANavigationDrawer(),
      floatingActionButton: FloatingActionButton(
        backgroundColor: isDark ? aPrimaryColor : aSecondaryColor,
        foregroundColor: isDark ? aDarkColor : aWhiteColor,
        onPressed: () {
          //controller.listNetwork[2].discovered = !controller.listNetwork[2].discovered;
          controller.scanQR();
        },
        child: const Icon(Icons.qr_code_scanner),
      ),
      body: Obx(() {
        return GridView.builder(
          shrinkWrap: true,
          padding: const EdgeInsets.only(left: 15, right: 15, bottom: 65),
          itemCount: controller.listNetwork.length,
          itemBuilder: (context, i) {
            final myObject = controller.listNetwork[i];
            return GestureDetector(
              onTap: () {
                placeController.placeDetail = i;
                if(myObject.discovered){
                  Get.to(() => PlaceDetailsScreen());
                }else{
                  showDialog(
                    context: context,
                    builder: (BuildContext context) => AlertDialog(
                      title: const Text("???"),
                      content: const Text("Lugar aun no descubierto"),
                      actions: <Widget>[
                        /*TextButton(
                          onPressed: () => Navigator.pop(context, 'Cancel'),
                          child: const Text('Cancel'),
                        ),*/
                        TextButton(
                          onPressed: () {
                            //controller.unLockPlace(i, !myObject.discovered);
                            Navigator.pop(context, 'OK');
                          },
                          child: const Text('OK'),
                        ),
                      ],
                    ),
                  );
                }

              } /*showDialog(
                context: context,
                builder: (BuildContext context) => AlertDialog(
                  title: myObject.discovered
                      ? Text(myObject.title)
                      : const Text("???"),
                  content: myObject.discovered
                      ? Text(myObject.description)
                      : const Text("Lugar aun no descubierto"),
                  actions: <Widget>[
                    TextButton(
                      onPressed: () => Navigator.pop(context, 'Cancel'),
                      child: const Text('Cancel'),
                    ),
                    TextButton(
                      onPressed: () {
                        //controller.unLockPlace(i, !myObject.discovered);
                        Navigator.pop(context, 'OK');
                      },
                      child: const Text('OK'),
                    ),
                  ],
                ),
              )*/,
              child: Card(
                child: Container(
                  height: 230,
                  decoration:
                      BoxDecoration(borderRadius: BorderRadius.circular(20)),
                  margin: const EdgeInsets.all(5),
                  padding: const EdgeInsets.all(5),
                  child: Stack(
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.stretch,
                        children: [
                          Expanded(
                            child: Image.network(
                              myObject.discovered
                                  ? myObject.image
                                  : aLockedImage,
                              fit: BoxFit.cover,
                            ),
                          ),
                          Text(
                            myObject.discovered ? myObject.title : "???",
                            style: const TextStyle(
                              fontSize: 18,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          Row(
                            children: [
                              Flexible(
                                child: Text(
                                  myObject.discovered
                                      ? myObject.description
                                      : "???",
                                  style: const TextStyle(
                                      fontWeight: FontWeight.bold,
                                      fontSize: 15,
                                      overflow: TextOverflow.ellipsis),
                                ),
                              ),
                            ],
                          )
                        ],
                      ),
                    ],
                  ),
                ),
              ) /*PlaceItem(
                  place: myObject,
                )*/
              ,
            );
          },
          gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: 2,
            childAspectRatio: 1.0,
            crossAxisSpacing: 0.0,
            mainAxisSpacing: 5,
            mainAxisExtent: 264,
          ),
        );
      }),

      /*Obx(() {
        return */ /*GridView.builder(
          shrinkWrap: true,
          padding: const EdgeInsets.only(left: 15, right: 15, bottom: 65),
          itemCount: list.length,
          itemBuilder: (ctx, i) => GestureDetector(
            onTap: () => showDialog(
              context: context,
              builder: (BuildContext context) => AlertDialog(
                title: list[i].discovered
                    ? Text(list[i].title)
                    : const Text("???"),
                content: list[i].discovered
                    ? Text(list[i].description)
                    : const Text("Lugar aun no descubierto"),
                actions: <Widget>[
                  TextButton(
                    onPressed: () => Navigator.pop(context, 'Cancel'),
                    child: const Text('Cancel'),
                  ),
                  TextButton(
                    onPressed: () {
                      controllerPlaces.unLockPlace(i, !list[i].discovered);
                      Navigator.pop(context, 'OK');
                    },
                    child: const Text('OK'),
                  ),
                ],
              ),
            ),
            child: PlaceItem(
              place: list[i],
            ),
          ),
          gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: 2,
            childAspectRatio: 1.0,
            crossAxisSpacing: 0.0,
            mainAxisSpacing: 5,
            mainAxisExtent: 264,
          ),
        );*/ /*
      }),*/
    );
  }
}

class PlaceItem extends StatelessWidget {
  PlaceItem({super.key, required this.place});

  final PlaceModel place;

  @override
  Widget build(BuildContext context) {
    return Obx(() {
      return Card(
        child: Container(
          height: 230,
          decoration: BoxDecoration(borderRadius: BorderRadius.circular(20)),
          margin: const EdgeInsets.all(5),
          padding: const EdgeInsets.all(5),
          child: Stack(
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  Expanded(
                    child: Image.network(
                      place.discovered ? place.image : aLockedImage,
                      fit: BoxFit.cover,
                    ),
                  ),
                  Text(
                    place.title,
                    style: const TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  Row(
                    children: [
                      Flexible(
                        child: Text(
                          place.description,
                          style: const TextStyle(
                              fontWeight: FontWeight.bold,
                              fontSize: 15,
                              overflow: TextOverflow.ellipsis),
                        ),
                      ),
                    ],
                  )
                ],
              ),
            ],
          ),
        ),
      );
    });
  }
}
