import 'package:flutter/material.dart';
import 'package:exploring/src/common_widgets/buttons/button_loading_widget.dart';

class APrimaryButton extends StatelessWidget {
  const APrimaryButton({
    Key? key,
    required this.text,
    required this.onPressed,
    this.isLoading = false,
    this.isFullWidth = true,
    this.width = 100.0,
  }) : super(key: key);

  final String text;
  final VoidCallback onPressed;
  final bool isLoading;
  final bool isFullWidth;
  final double width;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: isFullWidth ? double.infinity : width,
      child: ElevatedButton(
        onPressed: onPressed,
        child: isLoading
            ? const ButtonLoadingWidget()
            : Text(text.toUpperCase()),
      ),
    );
  }
}
