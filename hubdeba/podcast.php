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

// Fetch podcast episodes from the database
$sql = "SELECT * FROM podcast";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="podcast.css" />
     <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet"> -->
  <script src="https://kit.fontawesome.com/c57ecf9603.js" crossorigin="anonymous"></script>
  <script>
        // Function to remove the delete message after a certain time
        function removeDeleteMessage() {
            var deleteMessage = document.getElementById('delete-message');
            if (deleteMessage) {
                setTimeout(function() {
                    deleteMessage.style.display = 'none';
                }, 3000); // Change 3000 to the desired time in milliseconds (3 seconds in this example)
            }
        }

        // Function to hide the delete message when the user clicks anywhere on the page
        document.addEventListener('click', function() {
            var deleteMessage = document.getElementById('delete-message');
            if (deleteMessage) {
                deleteMessage.style.display = 'none';
            }
        });
    </script>

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

  <?php
// Check if there's a delete message in the URL
if (isset($_GET['delete_message'])) {
    $delete_message = $_GET['delete_message'];
}
?>

  <div class="bottom">

  <?php 
        if (isset($_SESSION["user_type"])) {
        if ($_SESSION["user_type"] > 0) {?>

<div class="new-podcast">
    <a href="new_podcast.php" class="add">+ Add New Podcast</a>
</div> <?php } }?>


<?php
if (isset($delete_message)) {
    echo '<div id="delete-message" class="delete-message">' . $delete_message . '</div>';
}
?>



<table class="podcast-table">
    <thead>
        <tr>
            <th>Episode no</th>
            <th>Episode Name</th>
            <th>Play Online</th>
            <th>Download</th>
            <th>Delete Podcast</th> <!-- Added delete column header -->
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['episodename']; ?></td>
                <td>
                    <audio controls>
                        <source src="music/<?php echo $row['audio']; ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </td>
                <td><a href="download.php?file=<?php echo urlencode("music/" . $row['audio']); ?>">Download</a></td>
                <td>
                    <a href="delete_podcast.php?id=<?php echo $row['id']; ?>" class="delete-button">Delete</a>
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </tbody>
</table>
</div>
</body>
</html>

<?php
$conn->close();
?>