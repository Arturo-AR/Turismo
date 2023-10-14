import 'package:flutter/material.dart';
import 'package:exploring/src/constants/colors.dart';

class ATextFormFieldTheme {
  ATextFormFieldTheme._();

  static InputDecorationTheme lightInputDecorationTheme = InputDecorationTheme(
    prefixIconColor: aSecondaryColor,
    suffixIconColor: aSecondaryColor,
    floatingLabelStyle: const TextStyle(color: aSecondaryColor),
    border: OutlineInputBorder(
      borderRadius: BorderRadius.circular(15),
    ),
    focusedBorder: OutlineInputBorder(
      borderRadius: BorderRadius.circular(15),
      borderSide: const BorderSide(width: 2, color: aSecondaryColor),
    ),
  );

  static InputDecorationTheme darkInputDecorationTheme = InputDecorationTheme(
    prefixIconColor: aPrimaryColor,
    suffixIconColor: aPrimaryColor,
    floatingLabelStyle: const TextStyle(color: aPrimaryColor),
    border: OutlineInputBorder(
      borderRadius: BorderRadius.circular(15),
    ),
    focusedBorder: OutlineInputBorder(
      borderRadius: BorderRadius.circular(15),
      borderSide: const BorderSide(width: 2, color: aPrimaryColor),
    ),
  );
}
