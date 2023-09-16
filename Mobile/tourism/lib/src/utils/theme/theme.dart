import 'package:flutter/material.dart';
import 'package:exploring/src/utils/theme/widget_themes/elevated_button_theme.dart';
import 'package:exploring/src/utils/theme/widget_themes/outlined_button_theme.dart';
import 'package:exploring/src/utils/theme/widget_themes/text_field_theme.dart';
import 'package:exploring/src/utils/theme/widget_themes/text_theme.dart';

class AAppTheme {
  AAppTheme._();

  static ThemeData lightTheme = ThemeData(
    brightness: Brightness.light,
    textTheme: ATextTheme.lightTextTheme,
    elevatedButtonTheme: AElevatedButtonTheme.lightElevatedButtonTheme,
    outlinedButtonTheme: AOutlinedButtonTheme.lightOutlinedButtonTheme,
      inputDecorationTheme: ATextFormFieldTheme.lightInputDecorationTheme,
    /*appBarTheme: TAppBarTheme.lightAppBarTheme,
    elevatedButtonTheme: TElevatedButtonTheme.lightElevatedButtonTheme,
    outlinedButtonTheme: TOutlinedButtonTheme.lightOutlinedButtonTheme,
    inputDecorationTheme: TTextFormFieldTheme.lightInputDecorationTheme,*/
  );

  static ThemeData darkTheme = ThemeData(
    brightness: Brightness.dark,
    textTheme: ATextTheme.darkTextTheme,
    elevatedButtonTheme: AElevatedButtonTheme.darkElevatedButtonTheme,
    outlinedButtonTheme: AOutlinedButtonTheme.darkOutlinedButtonTheme,
      inputDecorationTheme: ATextFormFieldTheme.darkInputDecorationTheme,
    /*appBarTheme: TAppBarTheme.darkAppBarTheme,
    elevatedButtonTheme: TElevatedButtonTheme.darkElevatedButtonTheme,
    outlinedButtonTheme: TOutlinedButtonTheme.darkOutlinedButtonTheme,
    inputDecorationTheme: TTextFormFieldTheme.darkInputDecorationTheme,*/
  );
}
