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
      body: Center(
        child: ElevatedButton(
          onPressed: () {
            Navigator.pushNamed(
              context,
              '/route',
              arguments: ScreenArguments(
                'JA MOI',
              ),
            );
          },
          child: const Text('Route 1', style: TextStyle(fontSize: 30.0)),
          style: ElevatedButton.styleFrom(
            minimumSize: Size(200, 100),
          ),
        ),
      ),
    );
  }
}
