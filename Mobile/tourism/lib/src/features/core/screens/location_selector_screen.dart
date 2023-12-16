import 'package:exploring/src/features/core/controllers/location_selector_controller.dart';
import 'package:exploring/src/features/core/screens/places_screen.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../../../common_widgets/scaffold/app_bar_widget.dart';

class LocationSelectorScreen extends StatelessWidget {
  LocationSelectorScreen({Key? key}) : super(key: key);
  final locationSelectorController = Get.put(LocationSelectorController());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: const AAppBarWidget(
        title: "Seleccione...",
      ),
      body: Obx(
        () {
          var locationsList = locationSelectorController.locationsList;

          return locationsList.isEmpty
              ? const Center(child: CircularProgressIndicator())
              : ListView.builder(
                  shrinkWrap: true,
                  padding: const EdgeInsets.only(left: 30, right: 30, top: 40),
                  itemCount: locationsList.length,
                  itemBuilder: (context, i) {
                    final myObject = locationsList[i];
                    return InkWell(
                      onTap: () {
                        locationSelectorController.getLocationList(myObject.id);
                        //locationSelectorController.locationIndex.value += 1;
                        /*if (locationSelectorController.locationIndex.value ==
                            0) {
                          locationSelectorController.locationIndex.value = 1;
                        } else if (locationSelectorController
                                .locationIndex.value ==
                            1) {
                          locationSelectorController.locationIndex.value = 2;
                        } else {
                          Get.off(PlacesScreen());
                        }*/
                      },
                      child: Card(
                        child: Container(
                          decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(20)),
                          margin: const EdgeInsets.all(5),
                          padding: const EdgeInsets.all(5),
                          child: Stack(
                            alignment: Alignment.center,
                            children: [
                              Column(
                                children: [
                                  Text(
                                    myObject.name,
                                    style: const TextStyle(
                                      fontSize: 18,
                                      fontWeight: FontWeight.bold,
                                    ),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                      ),
                    );
                  },
                );
        },
      ),
    );
  }
}
