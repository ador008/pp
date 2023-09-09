<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="home.css" />
  <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet"> -->
  <script src="https://kit.fontawesome.com/c57ecf9603.js" crossorigin="anonymous"></script>

</head>

<body>
  <div class="top">
    <div class="logo">
      <a href="home.php">
        <img src="logo.png" alt="Logo" />
      </a>
    </div>
    <ul class="navbar">

      <?php
      if (isset($_SESSION["user_type"])) {

        if ($_SESSION["user_type"] == 2) {


      ?>
          <li><a href="authorization.php">Authorization</a></li>
      <?php }
      } ?>

      <li class="dropdown">
        <a href="semester.php">Semester</a>
        <ul class="dropdown-content">
        </ul>
      </li>
      <?php
      if (isset($_SESSION["user_id"])) {
      ?>
        <li><a href="suggestion.php">Suggestion</a></li>
      <?php } ?>
      <li><a href="notice.php">Notice Board</a></li>
      <?php
      if (isset($_SESSION["user_id"])) {
      ?>
        <li><a href="video.php">Videos</a></li>
        <li><a href="podcast.php">Podcast</a></li>
      <?php } ?>
      <li class="dropdown">
        <a href="#">Others</a>
        <ul class="dropdown-content">
          <?php
          if (isset($_SESSION["user_id"])) {
          ?>
            <li><a href="feedback.php">Feedback</a></li>
          <?php } ?>
          <li><a href="help.php">Help</a></li>
          <li><a href="teachers.php">Teachers Portal</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </li>
    </ul>
    <?php
    if (isset($_SESSION["user_id"])) {
    ?>
      <div class="account-settings">
        <a class="account">
          <i class="fa-solid fa-user"></i>
        </a>
        <div class="user-account-items">
          <div class="acct-name">
          <i class="fa-solid fa-person"></i>
            <?php echo $_SESSION["user_name"]; ?>
          </div>

          <div class="horizontal-line"></div>

          <a class="type" href="account.php">
            <div class="logo"><i class="fa-solid fa-user-pen"></i></div>
            <div class="name">Manage Account</div>
          </a>
          <a class="type" href="change_password.php">
            <div class="logo"><i class="fa-solid fa-key"></i></div>
            <div class="name">Change Password</div>
          </a>
          <div class="horizontal-line"></div>

          <?php
          if (isset($_SESSION["user_type"])) {
            if ($_SESSION["user_type"] > 0) { ?>
              <a class="type" href="new_question.php">
                <div class="logo"><i class="fa-solid fa-book"></i></i></div>
                <div class="name"> Add New Question</div>
              </a>
              <a class="type" href="new_chapter.php">
                <div class="logo"><i class="fa-solid fa-pen"></i></div>
                <div class="name"> Add New Chapter</div>
              </a>
              <a class="type" href="new_notice.php">
                <div class="logo"><i class="fa-solid fa-bullhorn"></i></div>
                <div class="name"> Add New Notice</div>
              </a>
              <a class="type" href="new_podcast.php">
                <div class="logo"><i class="fa-solid fa-music"></i></div>
                <div class="name"> Add New Podcast</div>
              </a>
              <div class="horizontal-line"></div>
              <a class="type" href="check_contact.php">
                <div class="logo"><i class="fa-solid fa-user"></i></div>
                <div class="name"> Check Contact</div>
              </a>
          <?php }
          } ?>
          <div class="horizontal-line"></div>

          <a class="type logout" href="signout.php">
            <div class="logo "><i class="fa-solid fa-right-from-bracket"></i></div>
            <div class="name">Logout</div>
          </a>
        </div>
      </div>
    <?php } else {
    ?>
      <a href="signin.php" class="sign-in">
        <button>
          Sign In
        </button>
      </a>
    <?php
    }
    ?>
    <script src="home.js"></script>
  </div>
  <div class="bottom" style="background-image: url('background.jpg');">
    <div class="search-bar">
      <form action="search_page.php" method="post">
        <!-- Use your custom SVG icon for the search button -->
        <button type="submit">
          <img src="magnifying-glass-solid.svg" alt="Search" />
        </button>
        <input type="text" name="search" placeholder="Search..." />
      </form>
    </div>
  </div>
</body>

</html>