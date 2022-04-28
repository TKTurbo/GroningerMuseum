import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

class RouteScreen extends StatelessWidget {
  RouteScreen({Key? key}) : super(key: key);

  static const locationDirection = 0; // Direction the user should move to

  Future<http.Response> fetchRoute() {
    return http.get(Uri.parse('http://localhost:8080'));
  }

  @override
  Widget build(BuildContext context) {

    // var route = fetchRoute();
    // print(route);

    fetchRoute().then((resp) {
      print('MOIII');
      print(resp.toString());
    });

    final args = ModalRoute.of(context)!.settings.arguments as ScreenArguments; // Get screen args

    return Scaffold(
      appBar: AppBar(
        title: Text('Route: ' + 1.toString()),
      ),
      body: Center(
        child: Compass()
      ),
    );
  }
}
