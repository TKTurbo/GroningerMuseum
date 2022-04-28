import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

// TODO: should be stateful
class RouteScreen extends StatelessWidget {
  // RouteScreen({Key? key}) : super(key: key);

  static const locationDirection = 0; // Direction the user should move to
  var route;
  var selectedIndex = 0;

  Future<http.Response> fetchRoute() async {
    return http.get(Uri.parse('http://192.168.178.64:8080/'));
  }

  RouteScreen({Key? key}) : super(key: key) {
    // works somehow? TODO: make cleaner when errors
    route = fetchRoute().then((resp) {
      route = convert.jsonDecode(resp.body);
    });
  }

  void onItemTapped(int index) {
    if (index == 0 && selectedIndex > 0) {
      selectedIndex--;
    } else if (index == 1 && selectedIndex < route['path'].length) {
      selectedIndex++;
    }
    print(selectedIndex);
  }


  @override
  Widget build(BuildContext context) {
    final args = ModalRoute.of(context)!.settings.arguments
        as ScreenArguments; // Get screen args

    return Scaffold(
      appBar: AppBar(
          // title: Text('Route: ' + 'dsasddsa'),
          title: FutureBuilder(
        future: route,
        builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
          print(route);
          if (route == null) {
            return Text('Route aan het laden...');
          } else {
            return Text('Route: ' + route['meta']['route_name'] + ' | Lengte: ' + route['path'].length.toString());
          }
        },
      )),
      body: Center(child: Compass()),
      bottomNavigationBar: BottomNavigationBar(
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(
            icon: Icon(Icons.arrow_back),
            label: 'Vorige',
            backgroundColor: Colors.green,
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.arrow_forward),
            label: 'Volgende',
            backgroundColor: Colors.blue,
          ),
        ],
        currentIndex: selectedIndex,
        selectedItemColor: Colors.green[800],
        // TODO: dirty fix
        unselectedItemColor: Colors.green[800],
        onTap: onItemTapped,
      ),
    );
  }
}
