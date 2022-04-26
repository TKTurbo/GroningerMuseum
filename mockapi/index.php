<?php
$route = file_get_contents('route.json');
header('Content-Type: application/json; charset=utf-8');
echo ($route);