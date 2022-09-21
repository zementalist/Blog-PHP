<?php

include "db.php";

function create_user($username, $email, $password) {
    global $conn;
    $query = "INSERT INTO users(username, email, password) ";
    $query .= " VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();

    if($conn->connect_error)
        return 0;
    
    return $conn->insert_id;
}

function getUserByEmail($email) {
    global $conn;
    $query = "SELECT * FROM users WHERE email = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    return $user;
}

?>