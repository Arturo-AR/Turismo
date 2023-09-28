import 'package:exploring/src/common_widgets/scaffold/app_bar_widget.dart';
import 'package:exploring/src/common_widgets/scaffold/drawer_widget.dart';
import 'package:exploring/src/constants/colors.dart';
import 'package:exploring/src/features/core/controllers/qr_scanner_controller.dart';
import 'package:exploring/src/features/core/models/place_model.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class PlacesScreen extends StatelessWidget {
  PlacesScreen({Key? key}) : super(key: key);
  final controller = Get.put(QrScannerController());

  @override
  Widget build(BuildContext context) {
    //Variables
    //final txtTheme = Theme.of(context).textTheme;
    final isDark = MediaQuery.of(context).platformBrightness ==
        Brightness.dark; //Dark mode

    final list = PlaceModel.list;

    return SafeArea(
      child: Scaffold(
        appBar: const AAppBarWidget(
          title: "Places",
        ),
        drawer: const ANavigationDrawer(),
        floatingActionButton: FloatingActionButton(
          backgroundColor: isDark ? aPrimaryColor : aSecondaryColor,
          foregroundColor: isDark ? aDarkColor : aWhiteColor,
          onPressed: () {
            controller.scanQR();
          },
          child: const Icon(Icons.qr_code_scanner),
        ),
        body: GridView.builder(
          shrinkWrap: true,
          padding: const EdgeInsets.only(left: 15, right: 15, bottom: 65),
          itemCount: list.length,
          itemBuilder: (ctx, i) => GestureDetector(
            onTap: () {
              print("Se clico en $i");
            },
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
        ),
      ),
    );
  }
}

class PlaceItem extends StatelessWidget {
  PlaceItem({super.key, required this.place});

  final PlaceModel place;
  final list = PlaceModel.list;

  @override
  Widget build(BuildContext context) {
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
                  child: Image.asset(
                    place.image,
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
  }
}