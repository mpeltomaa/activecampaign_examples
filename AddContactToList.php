<?php

/*
  AddContactToList.php
  Version 1.0

  Usage:
  - Fill in fields below with your own URL and API Key
  - In post array you find p[xx], status[xx] and instantresponders[xx]. Replace XX with your list ID
*/

$url = 'https://your.ac.api.url';

$params = array(
    'api_key'      => 'xxxx',
    'api_action'   => 'contact_add',
    'api_output'   => 'serialize',
);

$post = array(
    'email'                    => @$_GET['cw_order_email'],
    'first_name'               => @$_GET['cw_order_firstname'],
    'last_name'                => @$_GET['cw_order_lastname'],
    'phone'                    => '',
    'orgname'                  => '',
    'tags'                     => '',

    'p[xx]'                   => 0,  // Replace 0 with your list ID
    'status[xx]'              => 1,
    'instantresponders[xx]' => 1,
);

// *** NO NEED TO TOUCH LINES BELOW *** //

$query = "";
foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
$query = rtrim($query, '& ');

$data = "";
foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
$data = rtrim($data, '& ');

$url = rtrim($url, '/ ');

if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
  if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
    die('JSON not supported. (introduced in PHP 5.2.0)');
  }

  $api = $url . '/admin/api.php?' . $query;

  $request = curl_init($api);
  curl_setopt($request, CURLOPT_HEADER, 0);
  curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($request, CURLOPT_POSTFIELDS, $data);
  curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

  $response = (string)curl_exec($request);

  curl_close($request);
?>
