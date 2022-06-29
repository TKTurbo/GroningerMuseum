import 'dart:async';
import 'dart:convert';
import 'dart:io';
import 'dart:math';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermockup/screens/routes_screen.dart';
import 'package:http/http.dart' as http;
import 'package:flutter_vibrate/flutter_vibrate.dart';
import 'package:just_audio/just_audio.dart';
import '../widgets/compass.dart';
import 'package:surround_sound/surround_sound.dart';
import 'package:flutter_blue/flutter_blue.dart';

class RouteScreen extends StatefulWidget {
  var args;

  RouteScreen(this.args, {Key? key});

  @override
  RouteScreenState createState() => RouteScreenState(args);
}

class RouteScreenState extends State<RouteScreen> {
  RouteScreenState(args) {
    print(args);
    arguments = args;
    // arguments = json.decode(args);
    // print(arguments);
  }

  static const locationDirection = 0; // Direction the user should move to
  int selectedIndex = 0;
  var route;
  late Future futureRoute;
  var backupRoute =
      '{"meta":{"route_name":"Mock","version":"1.0"},"path":[{"name":"Kunstwerk","to_next":120, "beaconUuid": "4fafc201-1fb5-459e-8fcc-c5c9c331914b"},{"name":"Gang 1","to_next":20},{"name":"Gang 2","to_next":90},{"name":"Beeld","to_next":0},{"name":"Gang 3","to_next":270},{"name":"Expositie","to_next":null}]}';
  var erfgoedZwartRoute =
      '{"meta":{"route_name":"Erfgoed Zwart","version":"1.0"},"path":[{"name":"Start","to_next":120,"beaconUuid":"4fafc201-1fb5-459e-8fcc-c5c9c331914b","audioFileName":"1_intro.mp3"},{"name":"DrieKoningen","to_next":20,"audioFileName":"2_DrieKoningen.mp3"},{"name":"Houwink","to_next":90,"audioFileName":"3_Houwink.mp3"},{"name":"Schay","to_next":0,"audioFileName":"4_Schay.mp3"},{"name":"Lintelo","to_next":270,"audioFileName":"5_Lintelo.mp3"},{"name":"Swinderen","to_next":120,"audioFileName":"6_Swinderen.mp3"},{"name":"Vrijheidsboom","to_next":40,"audioFileName":"7_Vrijheidsboom.mp3"},{"name":"Sichterman","to_next":null,"audioFileName":"8_Sichterman.mp3"}]}';
  var compass;
  bool endloop = false;
  bool couldNotConnect = false;
  var soundController = SoundController();

  double volume = 0.1;
  double freq = 200.0;

  var distanceCMtoNearestPoint = null;

  final String testServiceUuid = '4fafc201-1fb5-459e-8fcc-c5c9c331914b';
  final FlutterBlue flutterBlue = FlutterBlue.instance;

  var arguments;

  bool isErfgoed = false;

  var changeAudioFile = true;
  var playing = false;
  var player = AudioPlayer();

  @override
  void initState() {
    player = AudioPlayer();
    super.initState();

    if (arguments['routeName'] == 'Erfgoed Zwart') {
      route = json.decode(erfgoedZwartRoute);
      futureRoute = http.get(Uri.parse('http://127.1.2.3/')); //
      isErfgoed = true;
    } else {
      route = json.decode(backupRoute);
      futureRoute = fetchRoute();
    }

    bool shouldVibrate = true; // TODO: check if can and should vibrate
    compass = Compass(route['path'][selectedIndex]['to_next']);

    // doVibrate();
    //
    // setStream(getScanStream());
  }

  @override
  void dispose() {
    endloop = true;
    soundController.stop();
    removePlayer();
    print('SHOULASTOPPED!!');
    super.dispose();
    dispose();
  }

  Future<http.Response> fetchRoute() async {
    return http.get(Uri.parse('http://192.168.178.64:8080/'));
  }

  removePlayer() async {
    player.stop();
    // player = null;
    playing = false;
    changeAudioFile = true;
  }

  void onItemTapped(int index) {
    setState(() {
      if (index == 0 && selectedIndex > 0) {
        selectedIndex--;
        distanceCMtoNearestPoint = null;
        removePlayer();
      } else if (index == 2 && selectedIndex < route['path'].length - 1) {
        selectedIndex++;
        distanceCMtoNearestPoint = null;
        removePlayer();
      } else if (index == 1) {
        // TODO: explain selected index in route
        // print(route['path'][selectedIndex]);

        if (isErfgoed) {
          playStop(route['path'][selectedIndex]['audioFileName']);
        }
      }
      compass = Compass(route['path'][selectedIndex]['to_next']);
    });
  }

  playStop(filename) async {

    if(changeAudioFile) {
      // player = AudioPlayer();
      await player.setUrl(// Load a URL
          'asset:///assets/audiotour/' +
              filename); // Schemes: (https: | file: | asset: )
      await player.setVolume(2);
    }

    changeAudioFile = false;

    if (playing) {
      await player.stop();
      playing = false;
    } else {
      await player.play();
      playing = true;
    }
  }

  doVibrate() async {
    vibrateEdgeFeedback();
    while (true) {
      await Future.delayed(Duration(milliseconds: getVibrationDelay()), () {
        var soundFrom =
            route['path'][selectedIndex]['to_next'] - compass.facing + 90;
        soundController.setPosition(1 * cos(soundFrom * (pi / 180)), 0.2,
            1 * sin(soundFrom * (pi / 180))); // TODO: refactor
        Vibrate.feedback(FeedbackType.medium);
      });
      if (endloop) {
        break;
      }
    }
  }

  vibrateEdgeFeedback() async {
    var previousDelay = null;
    while (true) {
      await Future.delayed(Duration(milliseconds: 100), () {
        var currentDelay = getVibrationDelay();
        // Vibrate.feedback(FeedbackType.success);

        if (previousDelay != null && previousDelay != currentDelay) {
          Vibrate.feedback(FeedbackType.warning);
        }
        previousDelay = currentDelay;
      });
      if (endloop) {
        break;
      }
    }
  }

  getVibrationDelay() {
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

  stopFrequency() async {
    await soundController.stop();
  }

  doScan() async {
    while (true) {
      flutterBlue.startScan(timeout: Duration(seconds: 2));
      await Future.delayed(Duration(seconds: 2), () {
        // print(flutterBlue.isScanning);
        flutterBlue.stopScan();
      });
      if (endloop) {
        break;
      }
    }
  }

  Stream<ScanResult> getScanStream() {
    return FlutterBlue.instance.scan(timeout: Duration(seconds: 5));
  }

  void setStream(Stream<ScanResult> stream) async {
    stream.listen((event) {
      var currentServiceUuid = route['path'][selectedIndex]['beaconUuid'];
      if (event.advertisementData.serviceUuids.isNotEmpty &&
          currentServiceUuid != null) {
        if (event.advertisementData.serviceUuids[0] == currentServiceUuid) {
          var N = 2;
          var mpower = -69;
          num distanceCM = pow(10, ((mpower - event.rssi)) / (10 * N)) * 100;
          setState(() {
            distanceCMtoNearestPoint = distanceCM;
          });
          checkIfNear();
          // print('Routepoint ${event.device.name} found! rssi: ${event.rssi}. Approx. distance: ${distanceCM} cm');
        }
      }
    }, onDone: () async {
      // Scan is finished ****************
      await FlutterBlue.instance.stopScan();
      setStream(getScanStream()); // New scan
    }, onError: (Object e) {
      print('Error while scanning: ' + e.toString());
    });
  }

  void checkIfNear() {
    if (distanceCMtoNearestPoint < 10) {
      Vibrate.vibrate();
      setState(() {
        selectedIndex++;
        distanceCMtoNearestPoint = null;
        compass = Compass(route['path'][selectedIndex]['to_next']);
        removePlayer();
      });
    }
  }

//   updateSoundLocation() async {
//     while (true) {
//       await Future.delayed(const Duration(milliseconds: 100), () {
//         soundController.setPosition(1 * cos(compass.facing), 0.2, 1 * sin(compass.facing)); // TODO: refactor
//       });
//       if (endloop) {
//         break;
//       }
//     }
// }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
          // title: Text('Route: ' + 'dsasddsa'),
          title: FutureBuilder(
        future: futureRoute,
        builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
          if (snapshot.hasData) {
            // route = json.decode(snapshot.data.body);
            var routeLength = route['path'].length - 1;
            return Text(route['meta']['route_name'] +
                ' | Lengte: ' +
                selectedIndex.toString() +
                '/' +
                routeLength.toString());
          } else {
            // route = json.decode(backupRoute);
            var routeLength = route['path'].length - 1;
            return Text(route['meta']['route_name'] +
                ' | Lengte: ' +
                selectedIndex.toString() +
                '/' +
                routeLength.toString());
          }
        },
      )),
      body: (ListView(children: [
        Center(
            child: route['path'][selectedIndex]['to_next'] == null
                ? const Text('Route compleet!',
                    style: TextStyle(fontSize: 30.0))
                : compass),
        // isErfgoed ? Text("True") : Text("False"),
      ])),
      bottomNavigationBar: BottomNavigationBar(
        items: <BottomNavigationBarItem>[
          const BottomNavigationBarItem(
            icon: Icon(Icons.arrow_back),
            label: 'Vorige',
            backgroundColor: Colors.green,
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.arrow_downward),
            label: distanceCMtoNearestPoint == null
                ? route['path'][selectedIndex]['name']
                : route['path'][selectedIndex]['name'] +
                    '\n± ' +
                    distanceCMtoNearestPoint.toStringAsFixed(0) +
                    'cm',
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
