import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

class RouteScreen extends StatelessWidget {
  // RouteScreen({Key? key}) : super(key: key);

  void initState() {
    print('Halloemn');
  }

  static const locationDirection = 0; // Direction the user should move to
  var route;

  Future<http.Response> fetchRoute() async {
    return http.get(Uri.parse('http://192.168.178.64:8080/'));
  }

  RouteScreen({Key? key}) : super(key: key) {
    print('eerst');
    fetchRoute().then((resp) {
      print('moi');
      route = convert.jsonDecode(resp.body);
    });
    print('moi2');
  }

  @override
  Widget FutureBuilder(BuildContext context) {

    print('tweed');
    print(route);

    final args = ModalRoute.of(context)!.settings.arguments as ScreenArguments; // Get screen args

    return Scaffold(
      appBar: AppBar(
        title: Text('Route: ' + 'dsasddsa'),
      ),
      body: Center(
        child: Compass()
      ),
    );
  }
}
