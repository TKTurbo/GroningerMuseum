import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

// Route arguments
class ScreenArguments {
  final String routeId;

  ScreenArguments(this.routeId);
}

class RoutesScreen extends StatelessWidget {
  const RoutesScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('GR. Museum - Routeselectie'),
      ),
      body: ListView(children: [
        for (int i = 0; i < 50; i++)
          Container(
              margin: const EdgeInsets.only(top: 10, left: 10, right: 10),
              child: ElevatedButton(
                onPressed: () {
                  Navigator.pushNamed(
                    context,
                    '/route',
                    arguments: ScreenArguments(
                      'Route ' + i.toString(),
                    ),
                  );
                },
                child: Text('Route ' + i.toString(), style: TextStyle(fontSize: 30.0)),
                style: ElevatedButton.styleFrom(
                  minimumSize: Size(200, 100),
                ),
              ))
      ]),
    );
  }
}
