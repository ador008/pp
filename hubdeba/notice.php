<?php
// Start the session
session_start();

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

// Fetch notices from the database
$sql = "SELECT * FROM notice ORDER BY date DESC ";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="notice.css" />
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

        if ($_SESSION["user_type"] == 2){
          
        
        ?>
        <li><a href="authorization.php">Authorization</a></li>
      <?php }} ?>

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
        if ($_SESSION["user_type"] > 0) {?>

<div class="new-notice">
    <a href="new_notice.php" class="add">+ Add New Notice</a>
</div> <?php } }?>

<?php
// Check if the "success" parameter is present in the URL
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div id="success-message-container" class="successful-message" style="display: none;">
    Notice updated successfully!
</div>';
}
?>

        <table>
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Download Link</th>
                    
                    <?php 
        if (isset($_SESSION["user_type"])) {
        if ($_SESSION["user_type"] > 0) {?>
                    <th>Delete Notice</th>
                    <th>Edit Notice</th>
                    <?php } }?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display notices from the database
                if ($result->num_rows > 0) {
                    $inc=1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $inc . "</td>";
                        $inc++;
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td><a href='download.php?file=" . urlencode($row['download']) . "'>Download</a></td>";

                        if (isset($_SESSION["user_type"])) {
                            if ($_SESSION["user_type"] > 0) {
                                echo "<td><a href='delete_notice.php?id=" . urlencode($row['id']) . "'>Delete</a></td>";
                                echo "<td><a href='edit_notice.php?id=" . $row['id'] . "&return_url=" . urlencode($_SERVER['REQUEST_URI']) . "'>Edit</a></td>";
                            }
                        }
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No notices available.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <script>
    // Show the success message initially
    const successMessage = document.getElementById('success-message-container');
    successMessage.style.display = 'block';

    // Add a click event listener to hide the message when clicked anywhere on the page
    document.addEventListener('click', function() {
        successMessage.style.display = 'none';
    });

    // Add an unload event listener to hide the message when the page is refreshed
    window.addEventListener('beforeunload', function() {
        successMessage.style.display = 'none';
    });
</script>
    </div>
</body>

</html>

<?php
$conn->close();
?>
