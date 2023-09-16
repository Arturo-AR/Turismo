import 'package:flutter/material.dart';
import 'package:tourism/src/constants/colors.dart';

class AElevatedButtonTheme {
  AElevatedButtonTheme._(); //To avoid creating instances


  /* -- Light Theme -- */
  static final lightElevatedButtonTheme  = ElevatedButtonThemeData(
    style: ElevatedButton.styleFrom(
      elevation: 0,
      foregroundColor: aWhiteColor,
      backgroundColor: aDarkColor,
      side: const BorderSide(color: aDarkColor),
      padding: const EdgeInsets.symmetric(vertical: 20),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
    ),
  );

  /* -- Dark Theme -- */
  static final darkElevatedButtonTheme = ElevatedButtonThemeData(
    style: ElevatedButton.styleFrom(
      elevation: 0,
      foregroundColor: aDarkColor,
      backgroundColor: aPrimaryColor,
      side: const BorderSide(color: aPrimaryColor),
      padding: const EdgeInsets.symmetric(vertical: 20),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
    ),
  );
}
