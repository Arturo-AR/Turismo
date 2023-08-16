import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:tourism/src/constants/colors.dart';

/* -- Light & Dark Text Themes -- */
class ATextTheme {
  ATextTheme._(); //To avoid creating instances

  /* -- Light Text Theme -- */
  static TextTheme lightTextTheme = TextTheme(
    displayLarge: GoogleFonts.poppins(fontSize: 28.0, fontWeight: FontWeight.bold, color: aDarkColor),
    displayMedium: GoogleFonts.poppins(fontSize: 24.0, fontWeight: FontWeight.w700, color: aDarkColor),
    displaySmall: GoogleFonts.poppins(fontSize: 24.0, fontWeight: FontWeight.normal, color: aDarkColor),
    headlineMedium: GoogleFonts.poppins(fontSize: 18.0, fontWeight: FontWeight.w600, color: aDarkColor),
    headlineSmall: GoogleFonts.poppins(fontSize: 18.0, fontWeight: FontWeight.normal, color: aDarkColor),
    titleLarge: GoogleFonts.poppins(fontSize: 14.0, fontWeight: FontWeight.w600, color: aDarkColor),
    bodyLarge: GoogleFonts.poppins(fontSize: 14.0, color: aDarkColor),
    bodyMedium: GoogleFonts.poppins(fontSize: 14.0, color: aDarkColor.withOpacity(0.8)),
  );

  /* -- Dark Text Theme -- */
  static TextTheme darkTextTheme = TextTheme(
    displayLarge: GoogleFonts.poppins(fontSize: 28.0, fontWeight: FontWeight.bold, color: aWhiteColor),
    displayMedium: GoogleFonts.poppins(fontSize: 24.0, fontWeight: FontWeight.w700, color: aWhiteColor),
    displaySmall: GoogleFonts.poppins(fontSize: 24.0, fontWeight: FontWeight.normal, color: aWhiteColor),
    headlineMedium: GoogleFonts.poppins(fontSize: 18.0, fontWeight: FontWeight.w600, color: aWhiteColor),
    headlineSmall: GoogleFonts.poppins(fontSize: 18.0, fontWeight: FontWeight.normal, color: aWhiteColor),
    titleLarge: GoogleFonts.poppins(fontSize: 14.0, fontWeight: FontWeight.w600, color: aWhiteColor),
    bodyLarge: GoogleFonts.poppins(fontSize: 14.0, color: aWhiteColor),
    bodyMedium: GoogleFonts.poppins(fontSize: 14.0, color: aWhiteColor.withOpacity(0.8)),
  );
}