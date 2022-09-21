<?php
if(!isset($_SESSION))
    session_start();

include "../helper/validation.php";

include "../database/post.php";

if(isset($_POST["post-create-form"])) {
    $path = "/blogger";
    $message = "Post is create successfully";

    // Validate
    $form_is_valid = checkForm($_POST, ["title", "body"]); // title, body, image
    
    if($form_is_valid) {
        $title = $_POST["title"];
        $body = $_POST["body"];
        $image = $_FILES["image"];
        $post_is_valid = checkLength($title, 5, 50) && checkLength($body, 5, 65000);

        if($post_is_valid) {
            
            $oldPath = $image["tmp_name"];
            $filename = $image["name"];
            $new_path = "../public/$filename";
            move_uploaded_file($oldPath, $new_path);

            $user_id = $_SESSION["user"]["id"];
            $post_id = create_post($title, $body, $filename, $user_id);
            if($post_id == 0) {
                $message = "Something went wrong.";
                $path = "/blogger/views/post/create.php";
            }
            else {
                $path = "/blogger/views/post/show.php?id=$post_id";
            }
        }
        else {
            $message = "Invalid data.";
            $path = "/blogger/views/post/create.php";
        }
    }
    else {
        $message = "Invalid data.";
        $path = "/blogger/views/post/create.php";
    }
    // message: invalid, location: create.php
    $_SESSION["message"] = $message;
    header("location: $path");
}


if(isset($_POST["post-update-form"])) {
    $message = "Unable to update post.";
    $path = "/blogger";
    if(isset($_SESSION["user"])) {
        $form_is_valid = checkForm($_POST, ["title", "body", "image", "post_id"]);
        // Get post by id
        if($form_is_valid) {
            $post_id = $_POST['post_id'];
            $title = $_POST["title"];
            $body = $_POST["body"];
            $image = $_POST["image"];

            $post = findPostById($post_id);

            if($post) {
                $post_is_valid = checkLength($title, 5, 50) && checkLength($body, 5, 65000);
                if($post_is_valid) {
                    $is_updated = update_post($title, $body, $image, $post_id);
                    $path = "/blogger/views/post/show.php?id=$post_id";
                    $message = "Post is updated successfully.";
                }
                else {
                    $message = "Invalid data.";
                    $path = "/blogger/views/post/edit.php?id=$post_id";
                }
            }
            else {
                $message = "404 Post is not FOUND";
            }
        }

        // Check post.user_id == sesssion.user.id
    }
    else {
        $_SESSION["message"] = "403 Unauthorized Access.";
        header("HTTP/1.1 403", true, 403);
        header("location: /blogger");
    }

    $_SESSION["message"] = $message;
    header("location: $path");
}

if(isset($_POST["post-delete-form"])) {
    $message = "Unable to delete post.";
    $path = "/blogger";
    if(isset($_POST["_method"]) && $_POST["_method"] == "DELETE") {
        if(isset($_SESSION["user"]) && isset($_POST["post_id"])) {
            $post_id = $_POST["post_id"];
            $post = findPostById($post_id);
            if($post) {
                if($_SESSION["user"]["id"] == $post["user_id"]) {
                    $is_deleted = deletePost($post_id);
                    if($is_deleted) {
                        $message = "Post is DELETED Successfully";
                    }
                }
                else {
                    $_SESSION["message"] = "403 Unauthorized Access.";
                    header("HTTP/1.1 403", true, 403);
                    header("location: /blogger");
                }
            }
            else {
                $message = "404 Post is not FOUND";
            }
        }
    }
    $_SESSION["message"] = $message;
    header("location: $path");
}

?>