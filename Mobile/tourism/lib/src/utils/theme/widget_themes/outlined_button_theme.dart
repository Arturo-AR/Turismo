/* -- Light & Dark Outlined Button Themes -- */
import 'package:flutter/material.dart';
import 'package:exploring/src/constants/colors.dart';

class AOutlinedButtonTheme {
  AOutlinedButtonTheme._(); //To avoid creating instances


  /* -- Light Theme -- */
  static final lightOutlinedButtonTheme  = OutlinedButtonThemeData(
    style: OutlinedButton.styleFrom(
      foregroundColor: aSecondaryColor,
      side: const BorderSide(color: aSecondaryColor),
      padding: const EdgeInsets.symmetric(vertical: 20),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
    ),
  );

  /* -- Dark Theme -- */
  static final darkOutlinedButtonTheme = OutlinedButtonThemeData(
    style: OutlinedButton.styleFrom(
      foregroundColor: aWhiteColor,
      side: const BorderSide(color: aWhiteColor),
      padding: const EdgeInsets.symmetric(vertical: 20),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
    ),
  );
}
