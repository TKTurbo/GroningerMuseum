import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert' as convert;
import 'package:fluttermockup/models/Route.dart' as Route;

import '../widgets/compass.dart';

// TODO: should be stateful
class RouteScreen extends StatefulWidget {
  @override
  RouteScreenState createState() => RouteScreenState();
}

class RouteScreenState extends State<RouteScreen> {
  static const locationDirection = 0; // Direction the user should move to
  int selectedIndex = 0;
  var hoi = 'moi';
  var route;
  late Future futureRoute;

  @override
  void initState() {
    super.initState();
    futureRoute = fetchRoute();
  }

  // RouteScreenState() {
  //   route = fetchRoute().then((resp) {
  //     route = convert.jsonDecode(resp.body);
  //   });
  //
  //   print(32987231987321321);
  //
  //   print(route);
  // }

  Future<http.Response> fetchRoute() async {
    // final response = await http.get(Uri.parse('http://192.168.178.64:8080'));
    //
    // if (response.statusCode == 200) {
    //   // If the server did return a 200 OK response,
    //   // then parse the JSON.
    //   return Route.fromJson(jsonDecode(response.body));
    // } else {
    //   // If the server did not return a 200 OK response,
    //   // then throw an exception.
    //   throw Exception('Failed to load album');
    // }
    return http.get(Uri.parse('http://192.168.178.64:8080/'));
  }

//   RouteScreen({Key? key}) : super(key: key) {
// // works somehow? TODO: make cleaner when errors
//     route = fetchRoute().then((resp) {
//       route = convert.jsonDecode(resp.body);
//     });
//   }

  void onItemTapped(int index) {
    setState(() {
      if (index == 0 && selectedIndex > 0) {
        selectedIndex--;
      } else if (index == 2 && selectedIndex < 6) {
        selectedIndex++;
      } else if (index == 1) {
        // TODO: explain selected index in route
        print(selectedIndex);
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    final args = ModalRoute.of(context)!.settings.arguments
        as ScreenArguments; // Get screen args

    return Scaffold(
      appBar: AppBar(
          // title: Text('Route: ' + 'dsasddsa'),
          title: FutureBuilder(
        future: futureRoute,
        builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
          if (snapshot.hasData) {
            var route = json.decode(snapshot.data.body);
            return Text('Route: ' +
                route['meta']['route_name'] +
                ' | Lengte: ' + selectedIndex.toString() + '/' + route['path'].length.toString());
          } else if(snapshot.hasError) {
            return Text('${snapshot.error}');
          } else {
            return Text('Route aan het laden...');
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
        currentIndex: 0,
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
