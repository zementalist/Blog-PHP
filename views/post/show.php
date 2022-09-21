<?php

include_once "../../inc/header.php";
include "../../database/post.php";

$redirect = true;
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $post = findPostById($id);
    $tags = getPostTags($id);

    $post["tags"] = $tags;

    $related_posts = getRelatedPosts($post["id"], $tags);

    
    if($post) {
        $redirect = false;
    }

}

if($redirect) {
    header("HTTP/1.1 404",true, 404);
    header("location: /blogger/views/404.php");
}

?>




<section class="mt-4">
    <!--Grid row-->
    <div class="row">

        <!--Grid column-->
        <div class="col-md-8 mb-4">
            <h3 class="my-2"><?= $post["title"] ?></h3>
            <?php foreach($post["tags"] as $tag) { ?>
                <span class="badge badge-primary"><?= $tag ?></span>
            <?php } ?>
            <br>
            <small id="article-meta">By
                <strong>
                    <a href="/user">
                        @<?= $post["username"] ?>
                    </a>
                </strong>
                , on <?= date("Y-m-d", strtotime($post["created_at"])) ?>
            </small>

            <!--Featured Image-->
            <div class="card my-4 mb-4">

                <img src="/blogger/public/<?= $post["image"] ?>">

            </div>
            <!--/.Featured Image-->

            <!-- CR(UD) Form -->

            <?php if(isset($_SESSION["user"]) && $_SESSION["user"]["id"] == $post["user_id"]) { ?>
                <div class="card my-4 mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="/blogger/views/post/edit.php?id=<?= $post["id"] ?>"><button class="btn btn-primary" style="width:100%;">Edit</button></a>
                        </div>
                        <div class="col-md-6">
                            <form action="/blogger/controller/post.php" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="post_id" value="<?= $post["id"] ?>">
                                <input type="submit" style="width:100%;" class="btn btn-danger" name="post-delete-form"
                                    value="DELETE">
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!--/ CR(UD) Form -->
            <!--Card-->
            <div class="card mb-4">

                <!--Card content-->
                <div class="card-body"><?= $post["body"] ?></div>

            </div>
            <!--/.Card-->

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-4 mb-4">

            <!--/.Card : Dynamic content wrapper-->

            <!--Card-->
            <div class="card mb-4 wow fadeIn">

                <div class="card-header">Related articles</div>

                <!--Card content-->
                <div class="card-body">
                    <!-- If there are related posts -->
                    <?php foreach($related_posts as $rpost) { ?>
                        <ul class="list-unstyled">
                            <!-- Loop over posts -->
                            <li class="media related-post">
                                <div class="media-body">
                                    <a href="/blogger/views/post/show.php?id=<?=$rpost["id"]?>">
                                        <h5 class="mt-0 mb-1 font-weight-bold"><?= $rpost["title"] ?></h5>
                                    </a>
                                    <?= substr($rpost["body"], 0, 20) ?>...
                                </div>
                            </li>
                        </ul>
                    <?php } ?>
                    <?php if(count($related_posts) == 0){ ?>
                        <h4>There are no related posts!</h4>
                    <?php } ?>
                </div>

            </div>
            <!--/.Card-->

        </div>
        <!--Grid column-->

    </div>
    <!--Grid row-->

</section>
<!--Section: Post-->

<?php

include_once "../../inc/footer.php";

?>