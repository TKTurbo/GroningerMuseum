import 'dart:async';
import 'dart:convert';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'package:flutter_vibrate/flutter_vibrate.dart';
import '../widgets/compass.dart';

class RouteScreen extends StatefulWidget {
  @override
  RouteScreenState createState() => RouteScreenState();
}

class RouteScreenState extends State<RouteScreen> {
  static const locationDirection = 0; // Direction the user should move to
  int selectedIndex = 0;
  var route;
  late Future futureRoute;
  var backupRoute =
      '{"meta":{"route_name":"Mock","version":"1.0"},"path":[{"name":"Kunstwerk","to_next":120},{"name":"Gang 1","to_next":20},{"name":"Gang 2","to_next":90},{"name":"Beeld","to_next":0},{"name":"Gang 3","to_next":270},{"name":"Expositie","to_next":null}]}';
  var compass;
  var previousVibrationDelay;
  bool endloop = false;
  bool couldNotConnect = false;

  @override
  void initState() {
    super.initState();
    route = json.decode(backupRoute);
    futureRoute = fetchRoute();
    bool shouldVibrate = true; // TODO: check if can and should vibrate
    compass = Compass(route['path'][selectedIndex]['to_next']);
    doVibrate();
  }

  @override
  void dispose() {
    super.dispose();
    endloop = true;
  }

  Future<http.Response> fetchRoute() async {
    return http.get(Uri.parse('http://192.168.178.64:8080/'));
  }

  void onItemTapped(int index) {
    setState(() {
      if (index == 0 && selectedIndex > 0) {
        selectedIndex--;
      } else if (index == 2 && selectedIndex < route['path'].length - 1) {
        selectedIndex++;
      } else if (index == 1) {
        // TODO: explain selected index in route
        print(route['path'][selectedIndex]);
      }
      compass = Compass(route['path'][selectedIndex]['to_next']);
    });
  }

  doVibrate() async {
    while (true) {
      await Future.delayed(Duration(milliseconds: getVibrationDelay()), () {
        Vibrate.feedback(FeedbackType.medium);
      });
      if (endloop) {
        break;
      }
    }
  }

  getVibrationDelay() {
    // TODO: should be independent because code reusing
    var locationAt = route['path'][selectedIndex]['to_next'];
    var pointingAt;

    if (compass == null || locationAt == null) {
      return 75;
    } else {
      pointingAt = compass.facing;
    }
    var diff = (locationAt - pointingAt).abs();

    if (diff < 10) {
      // green
      return 150;
    } else if (diff < 20) {
      // orange
      return 500;
    } else {
      // red
      return 1000;
    }
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
            route = json.decode(snapshot.data.body);
            var routeLength = route['path'].length - 1;
            return Text('Route: ' +
                route['meta']['route_name'] +
                ' | Lengte: ' +
                selectedIndex.toString() +
                '/' +
                routeLength.toString());
          } else if (snapshot.hasError) {
            print(snapshot.error);
            return Text('Offline: Mock route');
          } else {
            route = json.decode(backupRoute);
            var routeLength = route['path'].length - 1;
            return Text('Backuproute: ' +
                route['meta']['route_name'] +
                ' | Lengte: ' +
                selectedIndex.toString() +
                '/' +
                routeLength.toString());
          }
        },
      )),
      body: Center(
          child: route['path'][selectedIndex]['to_next'] == null?
          const Text('Route compleet!', style: TextStyle(fontSize: 30.0)) :
          compass
      ),
      bottomNavigationBar: BottomNavigationBar(
        items: <BottomNavigationBarItem>[
          const BottomNavigationBarItem(
            icon: Icon(Icons.arrow_back),
            label: 'Vorige',
            backgroundColor: Colors.green,
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.arrow_downward),
            label: route['path'][selectedIndex]['name'],
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
