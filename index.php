<?php
if(!isset($_SESSION)) {
    session_start();
    if(!isset($_SESSION["message"]))
        $_SESSION["message"] = "";
}

include "inc/header.php";

include "views/post/index.php";

include "inc/footer.php";

?>