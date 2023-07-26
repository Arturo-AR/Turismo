import 'package:flutter/material.dart';

class TmpThemeItemsScreen extends StatelessWidget {
  const TmpThemeItemsScreen({
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: SafeArea(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisAlignment: MainAxisAlignment.center,
            children: const [
              Text("Theme Items"),
            ],
          ),
        ),
      ),
    );
  }
}