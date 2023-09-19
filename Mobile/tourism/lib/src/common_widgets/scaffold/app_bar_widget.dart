import 'package:exploring/src/constants/colors.dart';
import 'package:flutter/material.dart';

class AAppBarWidget extends StatelessWidget implements PreferredSizeWidget{
  const AAppBarWidget({
    super.key,
    required this.title,
  });

  final String title;

  @override
  Widget build(BuildContext context) {
    return AppBar(
      title: Text(title),
      backgroundColor: aPrimaryColor,
    );
  }

  @override
  Size get preferredSize => const Size.fromHeight(kToolbarHeight);
}