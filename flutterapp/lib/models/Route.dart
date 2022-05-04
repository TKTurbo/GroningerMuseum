class Route {
  final String name;
  final path;

  const Route({
    required this.name,
    required this.path,
  });

  factory Route.fromJson(Map<String, dynamic> json) {
    return Route(
      name: json['meta']['route_name'],
      path: json['path'],
    );
  }
}