import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

class RouteScreen extends StatelessWidget {
  RouteScreen({Key? key}) : super(key: key);

  static const locationDirection = 0; // Direction the user should move to

  // Fetch the route from the API
  fetchRoute() async {
    var url = Uri.parse('http://192.168.178.64:8080/');
    var response = http.get(url);
    return 'lol';
    return response;
  }

  @override
  Widget build(BuildContext context) {
    final args = ModalRoute.of(context)!.settings.arguments as ScreenArguments; // Get screen args

    var route;
    // fetchRoute().then((fetchedRoute) {
    //   route = fetchedRoute;
    // });

    route = fetchRoute();

    // route = fetchRoute();
    print('moi');
    print(route);

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
