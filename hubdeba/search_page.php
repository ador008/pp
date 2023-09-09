<?php
// Start the session
session_start();
// Connect to the database
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$database = "hub";
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// SQL query to fetch questions data
$sql = "SELECT
s.question_name,
s.subject,
s.pdf_download,
s.video_link,
c.chapter,
sem.semester_no

FROM
subject AS s
JOIN
chaptername AS c ON s.subject = c.subject AND c.chapter_number = s.chapter 
JOIN
semester AS sem ON s.subject = sem.subject
WHERE
        s.question_name LIKE '%$search%'
        OR s.subject LIKE '%$search%'
        OR c.chapter LIKE '%$search%'";
// Modify this query according to your database structure
$result_table = $conn->query($sql);

// Display data in the table rows
$serial = 1;

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="search_page.css" />
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
        <div class="search-bar">
            <form action="search_page.php" method="post">
                <!-- Use your custom SVG icon for the search button -->
                <button type="submit">
                    <img src="magnifying-glass-solid.svg" alt="Search" />
                </button>
                <input type="text" name="search" placeholder="Search..." />
            </form>
        </div>
        <div class="questions">
            <div class="label">
                Questions
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Ser</th>
                        <th>Question</th>
                        <th>Chapter name</th>
                        <th>Subject name</th>
                        <th>Semester</th>
                        <th>PDF download</th>
                        <th>Video link</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP code to fetch and display data from the database -->
                    <?php

                    while ($row = $result_table->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>$serial</td>";

                        // Highlight the matching word in the question_name
                        $questionName = str_ireplace($search, "<span class='highlight'>$search</span>", $row['question_name']);
                        echo "<td>{$questionName}</td>";

                        // Highlight the matching word in the chapter
                        $chapter = str_ireplace($search, "<span class='highlight'>$search</span>", $row['chapter']);
                        echo "<td>{$chapter}</td>";

                        // Highlight the matching word in the subject
                        $subject = str_ireplace($search, "<span class='highlight'>$search</span>", $row['subject']);
                        echo "<td>{$subject}</td>";

                        echo "<td>{$row['semester_no']}</td>";

                        // ... (same for other table cells)

                        echo "<td><a href='{$row['pdf_download']}'>Download PDF</a></td>";
                        echo "<td><a href='{$row['video_link']}'>Watch Video</a></td>";
                        echo "</tr>";
                        $serial++;
                    }

                    ?>
                </tbody>
            </table>
        </div>


        <div class="podcast">
            <div class="label">
                Podcasts
            </div>
            <div class="podcast-content">
                <table>
                    <thead>
                        <tr>
                            <th>Ser</th>
                            <th>Episode Name</th>
                            <th>Audio</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Modify the SQL query to fetch podcast data
                        $podcast_sql = "SELECT * FROM podcast WHERE episodename LIKE '%$search%' OR audio LIKE '%$search%'";
                        $podcast_result = $conn->query($podcast_sql);

                        $serial = 1;
                        while ($podcast_row = $podcast_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>$serial</td>";

                            // Highlight the matching word in the episode name
                            $episodeName = str_ireplace($search, "<span class='highlight'>$search</span>", $podcast_row['episodename']);
                            echo "<td>{$episodeName}</td>";

                            echo "<td><audio controls><source src='music/{$podcast_row['audio']}' type='audio/mpeg'>Your browser does not support the audio element.</audio></td>";
                            echo "<td><a href='download.php?file=" . urlencode("music/" . $podcast_row['audio']) . "'>Download</a></td>";
                            echo "</tr>";
                            $serial++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="notice">
            <div class="label">
                Notices
            </div>
            <div class="notice-content">
                <table>
                    <thead>
                        <tr>
                            <th>Ser</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Modify the SQL query to fetch notice data
                        $notice_sql = "SELECT * FROM notice WHERE title LIKE '%$search%'";
                        $notice_result = $conn->query($notice_sql);

                        $serial = 1;
                        while ($notice_row = $notice_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>$serial</td>";

                            // Highlight the matching word in the notice title
                            $noticeTitle = str_ireplace($search, "<span class='highlight'>$search</span>", $notice_row['title']);
                            echo "<td>{$noticeTitle}</td>";

                            echo "<td>{$notice_row['date']}</td>";
                            echo "<td><a href='{$notice_row['download']}'>Download</a></td>";
                            echo "</tr>";
                            $serial++;
                        }
                        // Close the database connection
                        $conn->close();
                        ?>
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

        
        </div>

</body>

</html>