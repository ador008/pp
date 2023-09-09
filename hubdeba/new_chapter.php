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
    if (isset($_POST["subject_button"])) {

        $subject = $_POST["subject_1"];
        $semester = $_POST["semester_1"];
        $updateSQL = "INSERT INTO semester (subject, semester_no) VALUES ('$subject', '$semester' )";
        if ($conn->query($updateSQL) === TRUE) {
            // Redirect to account page after successful update
            $error_message = "New Subject Added Successfully !";
        } else {
            // Handle error
        }
     
    }
    if (isset($_POST["chapter_button"])) {
        $subject = $_POST["subject"];
        $chapter = $_POST["chapter"];
    
        // Get the count of chapters for the given subject
        $chapterCountQuery = "SELECT COUNT(*) AS chapter_count FROM chaptername WHERE subject = '$subject'";
        $chapterCountResult = $conn->query($chapterCountQuery);
    
        if ($chapterCountResult->num_rows > 0) {
            $row = $chapterCountResult->fetch_assoc();
            $chapter_count = $row["chapter_count"] + 1; // Increment by 1 for the new chapter
        } else {
            // If no chapters are found, start with chapter number 1
            $chapter_count = 1;
        }
    
        $updateSQL = "INSERT INTO chaptername (subject, chapter, chapter_number) VALUES ('$subject', '$chapter', '$chapter_count')";
        
        if ($conn->query($updateSQL) === TRUE) {
            $error_message = "New Chapter Added Successfully!";
        } else {
            // Handle error
        } 
        
    }
}    

$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="new_chapter.css" />
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet"> -->
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
        <div class="forms">



            <form action="new_chapter.php" method="post" class="account-form">
                <div class="successful">

                    <?php
                    if (isset($error_message)) {
                        if (isset($_POST["subject_button"])) {
                        echo $error_message;
                    }}
                    ?>
                </div>
                <h2>
                    New Subject
                </h2>
                <div class="form-group">
                    <label for="semester_1">Semester</label>
                    <select name="semester_1" id="semester_1">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subject_1">Subject</label>
                    <input name="subject_1" type="text" id="subject_1" />

                </div>



                <button type="submit" name="subject_button" class="submit-button">Save Changes</button>
            </form>
            <form action="new_chapter.php" method="post" class="account-form">
                <div class="successful">
                    <?php
                    if (isset($error_message)) {
                        if (isset($_POST["chapter_button"])) {
                        echo $error_message;
                    }}
                    ?>
                </div>
                <h2>
                    New Chapter
                </h2>

                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select name="semester" id="semester">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <select name="subject" id="subject">
                        <!-- Options will be dynamically loaded using AJAX -->
                    </select>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#semester').on('change', function() {
                            var semester = $(this).val();

                            // Use AJAX to fetch subjects based on the selected semester
                            $.ajax({
                                url: 'get_subjects.php', // This is the PHP script that will fetch subjects
                                method: 'POST',
                                data: {
                                    semester: semester
                                },
                                success: function(data) {
                                    $('#subject').html(data);
                                }
                            });
                        });
                    });
                </script>


                <div class="form-group">
                    <label for="chapter">Chapter</label>
                    <input type="text" name="chapter" id="chapter" />


                </div>


                <button type="submit" name="chapter_button" class="submit-button">Save Changes</button>
            </form>
        </div>
    </div>

</body>

</html>