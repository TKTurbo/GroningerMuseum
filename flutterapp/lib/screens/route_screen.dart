import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

class RouteScreen extends StatelessWidget {
  const RouteScreen({Key? key}) : super(key: key);

  static const locationDirection = 0; // Direction the user should move to

  // Fetch the route from the API
  fetchRoute() async {
    var url = Uri.https('http://localhost:8080/', '/', {'q': '{http}'});
    var response = await http.get(url);
    print(response.body);
  }

  @override
  Widget build(BuildContext context) {
    final args = ModalRoute.of(context)!.settings.arguments as ScreenArguments; // Get screen args

    var route = fetchRoute();
    print(route);

    return Scaffold(
      appBar: AppBar(
        title: Text('GMS - Route: ' + args.routeId),
      ),
      body: Center(
        child: Compass()
      ),
    );
  }
}
