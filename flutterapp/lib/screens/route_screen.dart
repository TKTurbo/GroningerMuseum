import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

class RouteScreen extends StatelessWidget {
  // RouteScreen({Key? key}) : super(key: key);

  static const locationDirection = 0; // Direction the user should move to
  var route;

  Future<http.Response> fetchRoute() async {
    return http.get(Uri.parse('http://192.168.178.64:8080/'));
  }

  RouteScreen({Key? key}) : super(key: key) {
    // works somehow? TODO: make cleaner when errors
    route = fetchRoute().then((resp) {
      route = convert.jsonDecode(resp.body);
    });
  }

  @override
  Widget build(BuildContext context) {

    final args = ModalRoute.of(context)!.settings.arguments as ScreenArguments; // Get screen args

    return Scaffold(
      appBar: AppBar(
        // title: Text('Route: ' + 'dsasddsa'),
        title: FutureBuilder(
          future: route,
          builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
            print(route);
            if(route == null) {
              return Text('Route aan het laden...');
            } else {
              return Text('Route: ' + route['meta']['route_name']);
            }
          },
        )
      ),
      body: Center(
        child: Compass()
      ),
    );
  }
}
