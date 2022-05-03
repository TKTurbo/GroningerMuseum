import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;

import '../widgets/compass.dart';

// TODO: should be stateful
class RouteScreen extends StatefulWidget {
  var route;

//   Future<http.Response> fetchRoute() async {
//     return http.get(Uri.parse('http://192.168.178.64:8080/'));
//   }
//
//   RouteScreen({Key? key}) : super(key: key) {
// // works somehow? TODO: make cleaner when errors
//     route = fetchRoute().then((resp) {
//       route = convert.jsonDecode(resp.body);
//     });
//   }

  @override
  RouteScreenState createState() => RouteScreenState();
}

class RouteScreenState extends State<RouteScreen> {
  static const locationDirection = 0; // Direction the user should move to
  int selectedIndex = 0;
  var hoi = 'moi';

  void onItemTapped(int index) {
    setState(() {
      selectedIndex++;
    });
    // print(index);
    // setState(() {
    //   if (index == 0 && selectedIndex > 0) {
    //     selectedIndex--;
    //   } else if (index == 2 && selectedIndex < 6) {
    //     selectedIndex++;
    //   } else {
    //     print(selectedIndex);
    //   }
    // });
  }

  @override
  Widget build(BuildContext context) {
    final args = ModalRoute.of(context)!.settings.arguments
        as ScreenArguments; // Get screen args

    return Scaffold(
      appBar: AppBar(
          // title: Text('Route: ' + 'dsasddsa'),
          title: FutureBuilder(
        future: widget.route,
        builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
          if (widget.route == null) {
            return Text('Route aan het laden...');
          } else {
            // return Text('Route: ' +
            //     widget.route['meta']['route_name'] +
            //     ' | Lengte: ' +
            //     widget.route['path'].length.toString());
            return Text('moi');
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
            label: selectedIndex.toString(),
            backgroundColor: Colors.black,
          ),
          const BottomNavigationBarItem(
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
        selectedFontSize: 26,
        unselectedFontSize: 26,
      ),
    );
  }
}
