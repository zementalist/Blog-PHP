<?php

include "db.php";

function create_post($title, $body, $image, $user_id) {
    global $conn;

    $query = "INSERT INTO posts(title, body, image, user_id) ";
    $query .= "VALUES(?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $title, $body, $image, $user_id);
    $stmt->execute();

    if($conn->error) {
        return 0;
    }
    return $conn->insert_id;

}

function findPostById($id) {
    global $conn;
    $query = "SELECT posts.id, posts.title, posts.body, posts.image, posts.user_id, posts.created_at, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row;
}

function getAllPosts() {
    global $conn;
    $query = "SELECT posts.id, posts.title, posts.body, posts.image, users.username  FROM posts JOIN users ON posts.user_id = users.id";
    $result = $conn->query($query);
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    return $posts;
}

function update_post($title, $body, $image, $post_id) {
    global $conn;
    $query = "UPDATE posts SET ";
    $query .= "title = ?, ";
    $query .= "body = ?, ";
    $query .= "image = ? ";
    $query .= "WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $title, $body, $image, $post_id);
    $stmt->execute();

    if($conn->error)
        return false;
    return true;
}

function deletePost($id) {
    global $conn;
    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if($conn->error)
        return false;
    return true;
}

function searchPosts($keyword) {
    // username, title, body
    global $conn;
    $query = "SELECT posts.id, posts.title, posts.image, posts.body, users.username FROM posts JOIN users ON posts.user_id = users.id ";
    $query .= " WHERE users.username LIKE ? OR posts.title LIKE ? OR posts.body LIKE ? ";

    $keyword = "%$keyword%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $keyword, $keyword, $keyword);
    $stmt->execute();

    if($conn->error)
        return [];
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    return $posts;

}

function getPostTags($post_id) {
    global $conn;

    $post = findPostById($post_id);

    $query = "SELECT tags.title FROM posts JOIN posts_tags ON posts.id = posts_tags.post_id JOIN tags ON posts_tags.tag_id = tags.id WHERE posts.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();

    if($conn->error)
        return [];
    $result = $stmt->get_result();
    // $stmt->close();
    $tags = $result->fetch_all(MYSQLI_NUM);
    // if(count($tags) > 0)
    //     $tags = $tags[;
    if(count($tags) > 0)
        $tags = array_map(function($item) {
            return $item[0];
        }, $tags);
    return $tags;
}

function getRelatedPosts($post_id, $tags) {
    // $tags = ["psychology", "nature"]
    $str = "(";
    foreach($tags as $tag){
        $str .= "'$tag',";
    }
    $str = substr($str, 0, strlen($str)-1);
    $str .= ")";
    
    global $conn;

    $query = "SELECT posts.id, posts.title, posts.body FROM posts JOIN posts_tags ON posts.id = posts_tags.post_id JOIN tags ON posts_tags.tag_id = tags.id ";
    $query .= " WHERE tags.title IN $str AND posts.id != $post_id";

    $result = $conn->query($query);

    if($conn->error)
        return [];
    return $result->fetch_all(MYSQLI_ASSOC);

}

?>