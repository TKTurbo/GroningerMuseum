import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class HomeScreen extends StatelessWidget {
  const HomeScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Groninger Museum Navigator'),
      ),
      body: Center(
        // Route button
        child: ElevatedButton(
          onPressed: () {
            Navigator.pushNamed(context, '/routes');
          },
          child: const Text('Routeselectie', style: TextStyle(fontSize: 30.0)),
          style: ElevatedButton.styleFrom(
            minimumSize: Size(200, 100),
          ),
        ),
      ),
    );
  }
}
