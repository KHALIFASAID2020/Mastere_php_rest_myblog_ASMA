<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Tweet.php';
  //http://localhost/php_rest_myblog-master/api/tweet/read_single.php?id=1
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $tweet = new Tweet($db);

  // Get ID
  $tweet->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $tweet->read_single();

  // Create array
  $tweet_arr = array(
    'user' => $tweet->user,
    'id'=>$tweet->id,
   'description'=>$tweet->description,
    'longitude'=>$tweet->longitude,
    'latitude'=>$tweet->latitude,
    'photo_user'=>$tweet->photo_user
  );

  // Make JSON
  print_r(json_encode($tweet_arr));