<?php

$host = "localhost"; // 127.0.0.1
$username = "root";
$password = "";
$db = "blogger";

$conn = new mysqli($host, $username, $password, $db);


//  Create users table

// $query = "CREATE TABLE users (
// id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
// username VARCHAR(121),
// email VARCHAR(121),
// password VARCHAR(121),
// created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
// updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP()
// )";

// $query = "CREATE TABLE posts (
//     id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
//     title VARCHAR(121),
//     body TEXT,
//     image VARCHAR(121),
//     user_id INTEGER UNSIGNED,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),

//     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
// )";

// $query = "CREATE TABLE tags (
//     id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
//     title VARCHAR(30)
// )";

$query = "CREATE TABLE posts_tags (
    post_id INTEGER UNSIGNED,
    tag_id INTEGER UNSIGNED,

    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE SET NULL
)";

$result = $conn->query($query); // true or false
if($result === FALSE)
    echo "FAILED TO create tags table";
else
    echo "posts_tags Table is created";
    



?>