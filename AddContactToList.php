<?php

/*
  AddContactToList.php
  Version 1.1

  Usage:
  - Fill in fields below with your own URL, listID and API Key
  - Debug mode dumps response from Active Campaign to screen. To enable debug: change $debug value to true
*/

$url = 'https://your.ac.api.url';
$listID = 74;
$debug = false;

$params = array(
    'api_key'      => 'xxxx',
    'api_action'   => 'contact_add',
    'api_output'   => 'serialize',
);
$post = array(
    "email"                    => @$_GET["cw_order_email"],
    "first_name"               => @$_GET["cw_order_firstname"],
    "last_name"                => @$_GET["cw_order_lastname"],
    "phone"                    => "",
    "orgname"                  => "",
    "tags"                     => "",

    "p[" . $listID . "]"                   => $listID,
    "status[[" . $listID . "]]"            => 1,
    "instantresponders[[" . $listID . "]]" => 1,
);

$query = "";
foreach( $params as $key => $value ) $query .= urlencode($key) . "=" . urlencode($value) . "&";
$query = rtrim($query, "& ");

$data = "";
foreach( $post as $key => $value ) $data .= urlencode($key) . "=" . urlencode($value) . "&";
$data = rtrim($data, "& ");

$url = rtrim($url, "/ ");

if ( !function_exists("curl_init") ) die("CURL not supported. (introduced in PHP 4.0.2)");

if ( $params["api_output"] == "json" && !function_exists("json_decode") ) {
  die("JSON not supported. (introduced in PHP 5.2.0)");
}

$api = $url . "/admin/api.php?" . $query;

$request = curl_init($api);
curl_setopt($request, CURLOPT_HEADER, 0);
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($request, CURLOPT_POSTFIELDS, $data);
curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

$response = (string)curl_exec($request);
curl_close($request);

$result = unserialize($response);

// For debugging purposes
if ($debug) { echo "<pre>"; print_r($result); echo "</pre>"; }


// Let"s check result code.
if (!$result["result_code"] & (@$_GET["cw_order_firstname"] != "" && @$_GET["cw_order_lastname"] != "")) {
    // Result was 0 (fail) and because we are already here we know that we have Curl so lets modify contact instead of add.

    // Let"s get ID from result
    $userID = $result[0][id];

    // Change API Action
    $params["api_action"] = "contact_edit";

    // Rebuild $post
    $post = array(
        "id"                       => $userID,
        "email"                    => @$_GET["cw_order_email"],
        "first_name"               => @$_GET["cw_order_firstname"],
        "last_name"                => @$_GET["cw_order_lastname"],
        "phone"                    => "",
        "orgname"                  => "",
        "tags"                     => "",

        "p[" . $listID . "]"                   => $listID,
        "status[" . $listID . "]"              => 1,
        "instantresponders[" . $listID . "]"   => 1,
    );

    // Rebuild POST data and parameters
    $query = "";
    foreach( $params as $key => $value ) $query .= urlencode($key) . "=" . urlencode($value) . "&";
    $query = rtrim($query, "& ");

    $data = "";
    foreach( $post as $key => $value ) $data .= urlencode($key) . "=" . urlencode($value) . "&";
    $data = rtrim($data, "& ");

    $api = $url . "/admin/api.php?" . $query;

    // Execute new request
    $request = curl_init($api);
    curl_setopt($request, CURLOPT_HEADER, 0);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($request, CURLOPT_POSTFIELDS, $data);
    curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

    $response = (string)curl_exec($request);
    curl_close($request);

    $result = unserialize($response);

    // For debugging purposes
    if ($debug) { echo "<pre>"; print_r($result); echo "</pre>"; }

}

?>
