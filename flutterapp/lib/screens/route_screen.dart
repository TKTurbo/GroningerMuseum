import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_compass/flutter_compass.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'dart:math' as math;

import '../widgets/compass.dart';

class RouteScreen extends StatelessWidget {
  const RouteScreen({Key? key}) : super(key: key);

  static const locationDirection = 0; // Direction the user should move to

  @override
  Widget build(BuildContext context) {
    final args = ModalRoute.of(context)!.settings.arguments as ScreenArguments; // Get screen args

    return Scaffold(
      appBar: AppBar(
        title: Text('GMS - Route: ' + args.routeId),
      ),
      body: Center(
        child: Compass()
      ),
    );
  }
}