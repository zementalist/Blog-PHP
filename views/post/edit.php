<?php
if(!isset($_SESSION)) {
    session_start();
}

include_once "../../inc/header.php";

include_once "../../database/post.php";


$redirect = true;
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $post = findPostById($id);
    
    if($post) {
        $redirect = false;
    }

}

if(!isset($_SESSION["user"]) || $_SESSION["user"]["id"] != $post["user_id"]) {
    $_SESSION["message"] = "403 Unauthorized Acces.";
    header("HTTP/1.1 403", true, 403);
    header("location: /blogger");
}

if($redirect) {
    header("HTTP/1.1 404",true, 404);
    header("location: /blogger/views/404.php");
}

?>


<div class="row">
    <h1>Update Post</h1>
    <div class="col-md-8 col-md-offset-2">
        <br>
        <form action="/blogger/controller/post.php" method="POST" id="postForm">
            <div class="form-group">
                <label for="title">Title <span class="require">*</span></label>
                <input type="text" id="title" value="<?= $post["title"] ?>" class="form-control" required name="title" />
            </div>

            <div class="form-group">
                <label for="image">Image link</label>
                <input type="text" class="form-control" name="image" value="<?= $post["image"] ?>" />
            </div>

            <input type="hidden" name="post_id" value="<?= $post["id"] ?>">

            <div class="form-group">
                <label for="body">Body</label>
                <textarea id="userText" rows="5" class="form-control" required name="body"><?= $post["body"] ?></textarea>
            </div>

            <div class="form-group">
                <input type="submit" name='post-update-form' id="post-btn" class="btn btn-primary" value='Update'>
                <!-- </button> -->
                <a href="/" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>

</div>

<?php
include_once "../../inc/footer.php";

?>