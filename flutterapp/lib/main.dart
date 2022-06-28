import 'dart:ui';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/home_screen.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:fluttermockup/screens/route_screen.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  // Application root
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: "Groninger Museum Navigator",
      theme: ThemeData(primarySwatch: Colors.orange),
      darkTheme: ThemeData(
          brightness: Brightness.dark, primarySwatch: Colors.orange),
      // Routing
      initialRoute: '/',
      routes: {
        '/': (context) => const HomeScreen(),
        '/routes': (context) => RoutesScreen(),
        '/route': (context) => RouteScreen(),
      },

    );
  }
}