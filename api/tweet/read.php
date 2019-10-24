<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Tweet.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $tweet = new Tweet($db);

  // Blog post query
  $result = $tweet->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $tweets_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
  
      $tweet_item = array(
        'id' => $id,
        'user'=>$user,
        'description' => $description,
        'longitude' => $longitude,
        'latitude' => $latitude,
        'photo_user' => $photo_user
      );

      // Push to "data"
      array_push($tweets_arr, $tweet_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($tweets_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
