import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

// Route arguments
class ScreenArguments {
  final String routeId;

  ScreenArguments(this.routeId);
}

class RoutesScreen extends StatelessWidget {
  late Future futureRoutes;

  RoutesScreen({Key? key}) : super(key: key) {
    futureRoutes = fetchRoutes();
    print(futureRoutes);
  }

  Future<http.Response> fetchRoutes() async {
    return http.get(
        Uri.parse('http://groningermuseum.tkturbo.nl:12345/api/routes/get'));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
            title: FutureBuilder(
                future: futureRoutes,
                builder:
                    (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
                  if (snapshot.hasData) {
                    print(snapshot.data.body);
                    return Text('Routelijst');
                  } else {
                    return Text('Routelijst (offline)');
                  }
                })),
        body: FutureBuilder(
            future: futureRoutes,
            builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {

              var specialRouteContainer = Container(
                  margin:
                  const EdgeInsets.only(top: 10, left: 10, right: 10),
                  child: ElevatedButton(
                    onPressed: () {
                      Navigator.pushNamed(
                        context,
                        '/route',
                        arguments: {'routeName': 'Erfgoed Zwart'},
                      );
                    },
                    child: const Text('Erfgoed Zwart',
                        style: TextStyle(fontSize: 30.0)),
                    style: ElevatedButton.styleFrom(
                      minimumSize: const Size(200, 100),
                    ),
                    //         ))
                  ));

              if (snapshot.hasData) {
                var routes = json.decode(snapshot.data.body);
                print(routes[0]);
                return ListView(children: [
                  for (int i = 0; i < routes.length; i++)
                    Container(
                        margin:
                        const EdgeInsets.only(top: 10, left: 10, right: 10),
                        child: ElevatedButton(
                          onPressed: () {
                            Navigator.pushNamed(
                              context,
                              '/route',
                              arguments: {'routeName': routes[i]['name']},
                            );
                          },
                          child: Text(routes[i]['name'],
                              style: const TextStyle(fontSize: 30.0)),
                          style: ElevatedButton.styleFrom(
                            minimumSize: const Size(200, 100),
                          ),
                          //         ))
                        )),
                  specialRouteContainer
                ]);
              } else {
                return ListView(children: [
                  for (int i = 0; i < 5; i++)
                    Container(
                        margin:
                            const EdgeInsets.only(top: 10, left: 10, right: 10),
                        child: ElevatedButton(
                          onPressed: () {
                            Navigator.pushNamed(
                              context,
                              '/route',
                              arguments: {'routeName': 'Route ' + i.toString()},
                            );
                          },
                          child: Text('Route ' + i.toString(),
                              style: TextStyle(fontSize: 30.0)),
                          style: ElevatedButton.styleFrom(
                            minimumSize: Size(200, 100),
                          ),
                          //         ))
                        )),
                  specialRouteContainer
                ]);
              }
            }));
  }
}
