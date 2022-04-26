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
        title: const Text('GMS - Routeselectie'),
      ),
      body: Wrap(

        children: [
          for (int i=0; i<10; i++)
          ElevatedButton(
          onPressed: () {
            Navigator.pushNamed(
              context,
              '/route',
              arguments: ScreenArguments(
                'Testing',
              ),
            );
          },
          child: const Text('Route 1', style: TextStyle(fontSize: 30.0)),
          style: ElevatedButton.styleFrom(
            minimumSize: Size(200, 100),
          ),
        )

        ]
      ),
    );
  }
}
