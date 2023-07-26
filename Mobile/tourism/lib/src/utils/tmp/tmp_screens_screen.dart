import 'package:flutter/material.dart';
import 'package:get/get.dart';

class TmpScreensScreen extends StatelessWidget {
  const TmpScreensScreen({
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
              Text("Screens"),
              /*ElevatedButton(onPressed: () => Get.to(() => const SplashScreen()), child: const Text("Splash")),
              ElevatedButton(onPressed: () => Get.to(() => const LoginScreen()), child: const Text("Login")),
              ElevatedButton(onPressed: () => Get.to(() => const SignupScreen()), child: const Text("SignUp")),
              ElevatedButton(onPressed: () => Get.to(() => const CalendarScreen()), child: const Text("Calendar")),
              ElevatedButton(onPressed: () => Get.to(() => const PatientsListScreen()), child: const Text("Patients List")),
              ElevatedButton(onPressed: () => Get.to(() => const PatientDetailsScreen()), child: const Text("Patient Detail")),
              ElevatedButton(onPressed: () => Get.to(() => const AddAppointmentScreen()), child: const Text("Add Appointment")),
              ElevatedButton(onPressed: () => Get.to(() => const AddPatientScreen()), child: const Text("Add Patient")),
              ElevatedButton(onPressed: () => Get.to(() => const AppointmentDetailScreen()), child: const Text("Appointment detail")),
              ElevatedButton(onPressed: () => Get.to(() => const ProfileScreen()), child: const Text("Profile")),*/
            ],
          ),
        ),
      ),
    );
  }
}