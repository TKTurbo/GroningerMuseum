import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

// TODO: should be stateful
class RouteScreen extends StatefulWidget {
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

  @override
  State<RouteScreen> createState() => RouteScreenState();
}

class RouteScreenState extends State<RouteScreen> {
  static const locationDirection = 0; // Direction the user should move to
  var selectedIndex = 0;
  var hoi = 'moi';

  void onItemTapped(int index) {
    if (index == 0 && selectedIndex > 0) {
      // widget.selectedIndex--;
      // setState(() {
      //   selectedIndex--;
      // });
    } else if (index == 2 && selectedIndex < widget.route['path'].length) {
      // widget.selectedIndex++;
      setState(() {
        selectedIndex = 400;
      });
    }
    print('adssaddsadsa');
    print(selectedIndex);
  }

  @override
  Widget build(BuildContext context) {
    selectedIndex = widget.selectedIndex;
    final args = ModalRoute.of(context)!.settings.arguments
        as ScreenArguments; // Get screen args

    return Scaffold(
      appBar: AppBar(
          // title: Text('Route: ' + 'dsasddsa'),
          title: FutureBuilder(
        future: widget.route,
        builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
          print(widget.route);
          if (widget.route == null) {
            return Text('Route aan het laden...');
          } else {
            return Text('Route: ' +
                widget.route['meta']['route_name'] +
                ' | Lengte: ' +
                widget.route['path'].length.toString());
          }
        },
      )),
      body: Center(child: Compass()),
      bottomNavigationBar: BottomNavigationBar(
        items: <BottomNavigationBarItem>[
          const BottomNavigationBarItem(
            icon: Icon(Icons.arrow_back),
            label: 'Vorige',
            backgroundColor: Colors.green,
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.arrow_downward),
            label: widget.selectedIndex.toString(),
            backgroundColor: Colors.black,
          ),
          const BottomNavigationBarItem(
            icon: Icon(Icons.arrow_forward),
            label: 'Volgende',
            backgroundColor: Colors.blue,
          ),
        ],
        currentIndex: widget.selectedIndex,
        selectedItemColor: Colors.green[800],
        // TODO: dirty fix
        unselectedItemColor: Colors.green[800],
        onTap: onItemTapped,
        selectedFontSize: 26,
        unselectedFontSize: 26,
      ),
    );
  }
}
