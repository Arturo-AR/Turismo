import 'package:flutter/material.dart';
import 'package:exploring/src/constants/colors.dart';
import 'package:exploring/src/constants/text_strings.dart';

class AFormDividerWidget extends StatelessWidget {
  const AFormDividerWidget({
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final isDark = MediaQuery.of(context).platformBrightness == Brightness.dark;
    return Row(
      children: [
        Flexible(child: Divider(thickness: 1, indent: 50, color: Colors.grey.withOpacity(0.3), endIndent: 10)),
        Text(aOR, style: Theme.of(context).textTheme.bodyLarge!.apply(color: isDark ? aWhiteColor.withOpacity(0.5) : aDarkColor.withOpacity(0.5))),
        Flexible(child: Divider(thickness: 1, indent: 10, color: Colors.grey.withOpacity(0.3), endIndent: 50)),
      ],
    );
  }
}
