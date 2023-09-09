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

// Get notice ID from URL
$noticeId = $_GET["id"];

// Fetch existing notice details from the database
$sql = "SELECT * FROM notice WHERE id = '$noticeId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row["title"];
    $file = $row["download"];
} else {
    // Handle error, notice not found
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $updatedTitle = $_POST["title"];
    $updatedFile = $_POST["file"];

    // Update notice details in the database
    $updateSQL = "UPDATE notice SET title = '$updatedTitle', download = '$updatedFile' WHERE id = '$noticeId'";

    if ($conn->query($updateSQL) === TRUE) {
        // Redirect back to the specified return URL after successful update
        $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : 'notice.php';
        header("Location: " . $return_url . "?success=1"); // Adding "?success=1" to the URL
        exit();
    } else {
        // Handle error
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="edit_notice.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c57ecf9603.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <form action="edit_notice.php?id=<?php echo $noticeId; ?>" method="post" class="account-form" id="edit-form">
            <!-- Add this hidden input field to capture the return URL -->
            <input type="hidden" name="return_url" value="<?php echo $_GET['return_url']; ?>">
            <div class="form-group">
                <label for="title">Notice Title</label>
                <input type="text" name="title" id="title" value="<?php echo $title; ?>" />
            </div>

            <div class="form-group">
                <label for="file">PDF Download</label>
                <input type="text" name="file" id="file" value="<?php echo $file; ?>" />
            </div>

            <button type="submit" class="submit-button">Save Changes</button>
        </form>

        <!-- Successfully updated message (initially hidden) -->
        <div class="successful-message" style="display: none;">
            Successfully updated!
        </div>

        <script>
            $(document).ready(function() {
                // Check if the "success" parameter is present in the URL
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('success')) {
                    // Show the success message
                    $('.successful-message').fadeIn().delay(2000).fadeOut();
                }

                // Handle form submission using AJAX
                $('#edit-form').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission
                    var form = e.target;

                    // Perform form submission using AJAX
                    $.ajax({
                        url: form.action,
                        method: 'POST',
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        success: function() {
                            // Redirect back to the specified return URL after successful update
                            var returnUrl = form.querySelector('input[name="return_url"]').value;
                            window.location.href = returnUrl + "?success=1"; // Adding "?success=1" to the URL
                        },
                        error: function() {
                            // Handle error
                        }
                    });
                });
            });
        </script>

    </div>
</body>

</html>

