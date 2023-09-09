<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to signin page
if (!isset($_SESSION["user_id"])) {
  header("Location: signin.php");
  exit();
}

// Replace these variables with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "hub";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $name = $_POST["Name"];
  $contact = $_POST["Contact_Number"];
  $email = $_POST["Email"];
  $message = $_POST["Message"];

  // Prepare and execute the SQL query to insert feedback into the database
  $insertSQL = "INSERT INTO feedback (name, contact, email, message) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($insertSQL);
  $stmt->bind_param("ssss", $name, $contact, $email, $message);

  if ($stmt->execute()) {
    // Feedback successfully inserted
    $confirmation_message = "Message Submitted Successfully!";
  } else {
    // Handle error
    $error_message = "Error: " . $stmt->error;
  }

  // Close the database connection
  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="contact.css" />
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

  <?php
  // Display confirmation message if feedback is submitted successfully
  if (isset($confirmation_message)) {
    echo "<p>$confirmation_message</p>";
  }
  ?>

  <div class="bottom">

    <div class="arch_contact_us_duplicate">
      <div class="responsive-container-block big-container">
        <div class="responsive-container-block container">
          <div class="responsive-cell-block wk-mobile-12 wk-desk-5 wk-tab-10 wk-ipadp-5" id="ih6s">
            <p class="text-blk section-head">
              Contact Us
            </p>
            <p class="text-blk section-subhead">
              Share anything with us.our team will reach you out soon.
            </p>
          </div>
          <div class="responsive-cell-block wk-ipadp-6 wk-mobile-12 wk-desk-5 wk-tab-9" id="i6df">
            <div class="form-wrapper">
              <form action="process_feedback.php" method="POST">
                <input class="input input-element" name="Name" placeholder="Name">
                <input class="input input-element" name="Contact_Number" placeholder="Contact Number">
                <input class="input input-element" name="Email" placeholder="Email">
                <textarea class="textinput input-element" name="Message" placeholder="Message"></textarea>
                <button class="button" type="submit"> <!-- Add type="submit" to the button -->
                  Send
                </button>
              </form>
            </div>
            <div class="social-media-icon-container">
              <div class="icon-block social-icon">
                <svg height="37.7" id="ihxs6" viewBox="0 0 37.701 37.7" width="37.701" xmlns="http://www.w3.org/2000/svg">
                  <path d="M32.178,0H5.523A5.529,5.529,0,0,0,0,5.522V32.178A5.529,5.529,0,0,0,5.523,37.7H16.641V24.372H12.223V17.746h4.418V13.254a6.634,6.634,0,0,1,6.627-6.627h6.7v6.627h-6.7v4.492h6.7l-1.1,6.627h-5.6V37.7h8.91A5.529,5.529,0,0,0,37.7,32.178V5.522A5.529,5.529,0,0,0,32.178,0Zm0,0">
                  </path>
                </svg>
              </div>
              <div class="icon-block social-icon">
                <svg height="37.7" id="inclm" viewBox="0 0 37.701 37.7" width="37.701" xmlns="http://www.w3.org/2000/svg">
                  <path d="M37.587,11.078A13.839,13.839,0,0,0,36.711,6.5a9.238,9.238,0,0,0-2.174-3.339A9.241,9.241,0,0,0,31.2.989,13.837,13.837,0,0,0,26.622.114C24.612.022,23.969,0,18.85,0s-5.762.022-7.772.113A13.841,13.841,0,0,0,6.5.99,9.239,9.239,0,0,0,3.164,3.164,9.24,9.24,0,0,0,.989,6.5a13.838,13.838,0,0,0-.875,4.576C.022,13.088,0,13.73,0,18.85s.022,5.762.114,7.772A13.835,13.835,0,0,0,.99,31.2a9.237,9.237,0,0,0,2.174,3.339A9.236,9.236,0,0,0,6.5,36.71a13.832,13.832,0,0,0,4.576.876c2.011.092,2.653.113,7.772.113s5.762-.022,7.772-.113A13.834,13.834,0,0,0,31.2,36.71,9.637,9.637,0,0,0,36.711,31.2a13.834,13.834,0,0,0,.876-4.576c.091-2.011.113-2.653.113-7.772s-.022-5.761-.113-7.772ZM34.194,26.467a10.429,10.429,0,0,1-.649,3.5,6.242,6.242,0,0,1-3.578,3.578,10.43,10.43,0,0,1-3.5.649c-1.987.091-2.584.11-7.617.11s-5.63-.019-7.617-.11a10.433,10.433,0,0,1-3.5-.649,5.842,5.842,0,0,1-2.167-1.41,5.839,5.839,0,0,1-1.41-2.167,10.429,10.429,0,0,1-.649-3.5c-.091-1.988-.11-2.584-.11-7.617s.019-5.629.11-7.617a10.437,10.437,0,0,1,.649-3.5,5.844,5.844,0,0,1,1.41-2.168,5.836,5.836,0,0,1,2.168-1.41,10.428,10.428,0,0,1,3.5-.649c1.988-.091,2.584-.11,7.617-.11h0c5.033,0,5.63.019,7.617.11a10.431,10.431,0,0,1,3.5.649,5.845,5.845,0,0,1,2.167,1.41,5.836,5.836,0,0,1,1.41,2.168,10.42,10.42,0,0,1,.649,3.5c.091,1.988.11,2.584.11,7.617S34.285,24.479,34.194,26.467Zm0,0" transform="translate(0 0)">
                  </path>
                  <path d="M134.219,124.539a9.68,9.68,0,1,0,9.68,9.68A9.68,9.68,0,0,0,134.219,124.539Zm0,15.963a6.283,6.283,0,1,1,6.284-6.284A6.283,6.283,0,0,1,134.219,140.5Zm0,0" transform="translate(-115.369 -115.369)">
                  </path>
                  <path d="M366.454,90.888a2.262,2.262,0,1,1-2.262-2.262A2.262,2.262,0,0,1,366.454,90.888Zm0,0" transform="translate(-335.279 -82.1)">
                  </path>
                </svg>
              </div>
              <div class="icon-block social-icon">
                <svg height="33.932" id="ijipc" viewBox="0 0 41.754 33.932" width="41.754" xmlns="http://www.w3.org/2000/svg">
                  <path d="M66.857,38.045a17.092,17.092,0,0,1-4.92,1.347A8.589,8.589,0,0,0,65.7,34.654a17.149,17.149,0,0,1-5.44,2.078,8.573,8.573,0,0,0-14.6,7.814A24.317,24.317,0,0,1,28.009,35.6,8.575,8.575,0,0,0,30.66,47.032a8.506,8.506,0,0,1-3.88-1.073c0,.036,0,.073,0,.109a8.571,8.571,0,0,0,6.872,8.4,8.6,8.6,0,0,1-3.868.148,8.575,8.575,0,0,0,8,5.949A17.293,17.293,0,0,1,25.1,64.111a24.231,24.231,0,0,0,13.13,3.849c15.756,0,24.373-13.053,24.373-24.373,0-.371-.008-.741-.025-1.108a17.371,17.371,0,0,0,4.275-4.434Z" transform="translate(-25.103 -34.028)">
                  </path>
                </svg>
              </div>
              <div class="icon-block social-icon">
                <svg height="37.649" id="ij4qf" viewBox="0 0 39.398 37.649" width="39.398" xmlns="http://www.w3.org/2000/svg">
                  <path d="M66.466,47.05V61.618H58.02V48.026c0-3.413-1.219-5.743-4.278-5.743a4.62,4.62,0,0,0-4.332,3.088,5.781,5.781,0,0,0-.28,2.058V61.617H40.684s.113-23.02,0-25.4h8.447v3.6c-.017.028-.041.056-.056.083h.056v-.083a8.386,8.386,0,0,1,7.612-4.2c5.557,0,9.723,3.631,9.723,11.432ZM31.848,23.969c-2.889,0-4.78,1.9-4.78,4.388a4.374,4.374,0,0,0,4.669,4.39h.055c2.946,0,4.778-1.951,4.778-4.39a4.388,4.388,0,0,0-4.722-4.388ZM27.57,61.618h8.444v-25.4H27.57Z" transform="translate(-27.068 -23.969)">
                  </path>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>