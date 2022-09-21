<?php

require_once "inc/header.php";
require "database/post.php";

if(isset($_GET["search"])) {
    $search = $_GET["search"];
    $posts = searchPosts($search);
}
else
    $posts = getAllPosts();


?>

<?php if(count($posts) == 0) { ?>

    <div class="text-center">
        <h2>There are not posts.</h2>

    </div>

<?php } ?>
<div class="row justify-content-center">

<?php foreach($posts as $post) { ?>
        <div class="col-md-6 col-lg-4">
            <div class="card-content">
                <div class="card-img">
                    <img src="/blogger/public/<?= $post["image"] ?>" alt="">
                    <span class="username">
                        <h4> <a href="#" class="username_url">@<?= $post["username"] ?></a></h4>
                    </span>
                </div>
                <div class="card-desc text-center">
                    <h3><?= $post["title"] ?></h3>
                    <p><?= substr($post["body"], 0, 30) ?>...</p>
                    <a href="/blogger/views/post/show.php?id=<?= $post["id"] ?>" class="btn-card">Read</a>
                </div>
            </div>
        </div>
<?php } ?>
</div>

<?php

require_once "inc/footer.php";

?>