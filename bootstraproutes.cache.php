<?php return array (
  0 => 
  array (
    'GET' => 
    array (
      '/api2' => 'route0',
      '/api2/' => 'route0',
      '/api2/products' => 'route1',
      '/api2/employees/' => 'route2',
    ),
    'POST' => 
    array (
      '/api2/employees/' => 'route4',
    ),
  ),
  1 => 
  array (
    'GET' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/api2/products/([^/]+)|/api2/employees/([^/]+)())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'route1',
            1 => 
            array (
              'limit' => 'limit',
            ),
          ),
          3 => 
          array (
            0 => 'route3',
            1 => 
            array (
              'id' => 'id',
            ),
          ),
        ),
      ),
    ),
  ),
);