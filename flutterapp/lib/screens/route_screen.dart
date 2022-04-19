import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

class RouteScreen extends StatelessWidget {
  const RouteScreen({Key? key}) : super(key: key);

  static const locationDirection = 0; // Direction the user should move to

  fetchRoute() async {
    var url =
    Uri.https('www.googleapis.com', '/books/v1/volumes', {'q': '{http}'});

    // Await the http get response, then decode the json-formatted response.
    var response = await http.get(url);
    if (response.statusCode == 200) {
      var jsonResponse =
      convert.jsonDecode(response.body) as Map<String, dynamic>;
      var itemCount = jsonResponse['totalItems'];
      print('Number of books about http: $itemCount.');
    } else {
      print('Request failed with status: ${response.statusCode}.');
    }
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
