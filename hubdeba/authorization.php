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

// Fetch user's information from the database
$userID = $_SESSION["user_id"];
$sql = "SELECT * FROM user WHERE id = '$userID'";
$result = $conn->query($sql);
$userData = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data

    $email = $_POST["email"];

    // Update user information in the database
    $updateSQL = "UPDATE user SET 
                  type = 1
                 
                  WHERE email = '$email'";

    if ($conn->query($updateSQL) === TRUE) {
        // Redirect to account page after successful update
        $error_message = "Authorized Successfully !";
    } else {
        // Handle error
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="authorization.css" />
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
    <div class="bottom">

        <?php
        if (isset($_SESSION["user_type"])) {
            if ($_SESSION["user_type"] == 2) { ?>
                <div class="buttons">

                    <div class="new-question">
                        <a href="unauthorize.php" class="add">- Unauthorize An Admin</a>
                    </div>

                    <div class="new-chapter">
                        <a href="deleteuser.php" class="add">x Delete User</a>
                    </div>
                </div> <?php }
                } ?>


        <form action="authorization.php" method="post" class="account-form">
            <div class="successful">
                <?php
                if (isset($error_message)) {
                    echo $error_message;
                }
                ?>
            </div>
            <?php
            $sql = "SELECT email FROM user WHERE type = 0";

            // Execute the query and get the result set
            $result = $conn->query($sql);
            ?>

            <div class="form-group">
                <label for="email">Authorize as an Admin</label>
                <select name="email" id="email">
                    <?php
                    // Loop through the result set and create an option for each email
                    while ($row = $result->fetch_assoc()) {
                        $email = $row["email"];
                        echo "<option value=\"$email\">$email</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="submit-button">Authorize</button>
        </form>
    </div>

</body>

</html>
<?php
// Close the database connection
$conn->close();
?>