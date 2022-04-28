import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_compass/flutter_compass.dart';
import 'dart:math' as math;

class Compass extends StatelessWidget {
  static const locationDirection = 0; // Direction the user should move to
  var cleanFacingDirection = 0.0; // TODO: make jittery movements caused by improper sensors work

  Widget build(BuildContext context) {

    return StreamBuilder<CompassEvent>(
      stream: FlutterCompass.events,
      builder: (context, snapshot) {
        if (snapshot.hasError) {
          return Text('Error reading heading: ${snapshot.error}');
        }

        // TODO: permissions
        if (snapshot.connectionState == ConnectionState.waiting) {
          return const Center(
            child: CircularProgressIndicator(),
          );
        }

        double? direction = snapshot.data!.heading;

        // if direction is null, then device does not support this sensor
        // show error message
        if (direction == null) {
          return const Center(
            child: Text("Device does not have sensors !"),
          );
        }

        return Material(
          shape: CircleBorder(),
          clipBehavior: Clip.antiAlias,
          elevation: 16.0,
          child: Container(
            margin: const EdgeInsets.only(top: 10),
            padding: EdgeInsets.all(8.0),
            alignment: Alignment.center,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: getDirectionColorFeedback(locationDirection, direction),
            ),
            child: Transform.rotate(
              angle: (direction * (math.pi / 180) * -1),
              child: const Icon(
                Icons.arrow_upward,
                color: Colors.black,
                size: 264.0,
              ),
            ),
          ),
        );
      },
    );
  }

  getDirectionColorFeedback(locationAt, pointingAt) {
    // Gets arrow color depending on how close the user is to the right direction
    // locationAt is the angle from point a to point b
    // pointingAt is the current direction the user is pointing at

    var diff = (locationAt + pointingAt).abs(); // absolute difference between the location angle and the pointing angle
    // debugPrint('locationAt: ' + locationAt.toString());
    // debugPrint('pointingAt: ' + pointingAt.toString());
    // debugPrint('diff: ' + diff.toString());

    if (diff < 10) {
      // green
      return Colors.green;
    } else if(diff < 20) {
      // orange
      return Colors.orange;
    } else {
      // red
      return Colors.red;
    }

  }
}