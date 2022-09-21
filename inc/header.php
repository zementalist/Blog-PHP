<?php

if(!isset($_SESSION))
  session_start();

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="/blogger/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/blogger/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="/blogger/assets/css/layout.css">

  <script src="/blogger/assets/js/jquery.min.js"></script>
  <script src="/blogger/assets/js/bootstrap.min.js"></script>
</head>
<body>
  <!--Main Navigation-->
  <header>

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark scrolling-navbar">
      <div class="container">

        <!-- Brand -->
        <a class="navbar-brand waves-effect" href="/blogger">
          <strong class="blue-text">Blogger</strong>
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <!-- Left -->
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link waves-effect" href="/blogger">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>

            <?php if(isset($_SESSION["user"])) { ?>
              <li class="nav-item">
                <a class="nav-link waves-effect" href="/blogger/views/post/create.php">Create Post</a>
              </li>

              <li class="nav-item">
                <a class="nav-link waves-effect" href="/?posts_by_uid=">My Posts</a>
              </li>
            <?php } ?>

            <li class="nav-item">
              <form action="" method="GET">
                <input type="text" name="search" class="form-control" placeholder="Search">
              </form>
            </li>
          </ul>

          <?php if(!isset($_SESSION["user"])) { ?>
          <!-- Right -->
          <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
              <a href="/blogger/views/auth/login.php" class="nav-link waves-effect">Login</a>
            </li>
            <li class="nav-item">
              <a href="/blogger/views/auth/register.php" class="nav-link waves-effect">Register</a>
            </li>
          </ul>

          <?php } else { ?>

          <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
              <a href="#" class="nav-link waves-effect">
                Welcome <?= $_SESSION["user"]["username"] ?>
              </a>
            </li>
            <li class="nav-item">
              <form action="/blogger/controller/auth.php" method="post">
                <input type="hidden" name="logout" value="logout">
                <button type='submit' class="nav-link waves-effect bg-transparent border-0" style="cursor:pointer;">Logout</button>
              </form>
              
            </li>
          </ul>

          <?php } ?>

        </div>

      </div>
    </nav>
    <!-- Navbar -->

  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 pt-5">
    <div class="container">
      <!-- Alert Message -->

      <?php if(!empty($_SESSION["message"])) { ?>
        <div class="alert alert-info text-center">
          <?= $_SESSION["message"] ?>
        </div>
      <?php } ?>
      <!-- End message -->

<?php
$_SESSION["message"] = "";
?>

