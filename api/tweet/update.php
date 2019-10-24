<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Tweet.php';
//http://localhost/php_rest_myblog-master/api/tweet/update.php
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $tweet = new Tweet($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
 /*  $tweet->id = $data->id;
  $tweet->longitude = $data->longitude; */
  $tweet->id = $data->id;
  $tweet->description = $data->description;
  $tweet->user= $data->user;
  $tweet->longitude= $data->longitude;
  $tweet->latitude= $data->latitude;
  $tweet->photo_user= $data->photo_user;

 /*  $post->id = $data->id;

  $post->title = $data->title; */
  // Update post
  if($tweet->update()) {
    echo json_encode(
      array('message' => 'Tweet Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Tweet Not Updated')
    );
  }

