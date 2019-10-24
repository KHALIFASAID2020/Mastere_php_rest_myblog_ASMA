<?php 
  class Tweet {
    // DB stuff
    private $conn;
    private $table = 'tweet';

    // Post Properties
    public $id;
    public $user;
    public $description;
    public $longitude;
    public $latitude;
    public $photo_user;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function read_single() {
      // Create query
      $query = 'SELECT *  FROM ' . $this->table . ' 
                                WHERE
                                 id = ?
                                LIMIT 0,1';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->user = $row['user'];
      $this->id = $row['id'];
      $this->description = $row['description'];
      $this->longitude = $row['longitude'];
      $this->latitude = $row['latitude'];
      $this->photo_user = $row['photo_user'];

}

public function update() {
  // Create query
  $query = 'UPDATE ' . $this->table . '
                        SET description = :description,
                        user = :user,
                        longitude = :longitude,
                        latitude = :latitude,
                        photo_user = :photo_user WHERE id = :id';


                     /*    $tweet->id = $data->id;
                        $tweet->description = $data->description;
                        $tweet->user=$date->user;
                        $tweet->longitude=$date->longitude;
                        $tweet->latitude=$date->latitude;
                        $tweet->photo_user=$date->photo_user; */


  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->photo_user = htmlspecialchars(strip_tags($this->photo_user));
  $this->latitude = htmlspecialchars(strip_tags($this->latitude));
  $this->longitude = htmlspecialchars(strip_tags($this->longitude));
  $this->user = htmlspecialchars(strip_tags($this->user));
  $this->description = htmlspecialchars(strip_tags($this->description));
  $this->id = htmlspecialchars(strip_tags($this->id));
 /*  $this->body = htmlspecialchars(strip_tags($this->body));
  $this->author = htmlspecialchars(strip_tags($this->author));
  $this->category_id = htmlspecialchars(strip_tags($this->category_id));
  $this->id = htmlspecialchars(strip_tags($this->id)); */

  // Bind data
  $stmt->bindParam(':description', $this->description);
  $stmt->bindParam(':photo_user', $this->photo_user);
  $stmt->bindParam(':latitude', $this->latitude);
  $stmt->bindParam(':user', $this->user);
  $stmt->bindParam(':longitude', $this->longitude);
  $stmt->bindParam(':id', $this->id);
/*   $stmt->bindParam(':body', $this->body);
  $stmt->bindParam(':author', $this->author);
  $stmt->bindParam(':category_id', $this->category_id);
  $stmt->bindParam(':id', $this->id); */

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
}



}