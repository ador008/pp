<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="podcast.css" />
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
    <div class="section">
      <h2>Recommender for You</h2>
      <div class="video-list">
        <div class="video-item">
          <a href="https://www.youtube.com/watch?v=4HbOzg4aWFk&list=PLeZMjV76KKKVxUvqqofY9VQZYBP5MPKW4" target="_blank">
            <img src="https://i.ytimg.com/vi/4HbOzg4aWFk/hqdefault.jpg?sqp=-oaymwEbCKgBEF5IVfKriqkDDggBFQAAiEIYAXABwAEG&rs=AOn4CLCxU9YKk3C-Ewf5Y0TITFCrciZO1g" alt="Video Thumbnail" />
          </a>
          <div class="video-info">
            <h3 class="video-title" id="video-title">Loading...</h3>
            <p class="video-channel" id="video-channel">Loading...</p>

          </div>
        </div>
        <!-- Add more video items as needed -->
      </div>
    </div>
    <div class="section">
      <h2>You May Also Watch</h2>
      <div class="video-list">
        <div class="video-item">
          <a href="https://www.youtube.com/watch?v=t0vo7LmHrD8" target="_blank">
            <img src="https://i.ytimg.com/an_webp/t0vo7LmHrD8/mqdefault_6s.webp?du=3000&sqp=CKaHkKYG&rs=AOn4CLD9uIC-SItkZDmrIeu7mNMw4HV-ug" alt="Video Thumbnail" />
          </a>
          <div class="video-info">
          <h3 class="video-title" id="video-title">Loading...</h3>
            <p class="video-channel" id="video-channel">Loading...</p>
          </div>
        </div>
        <!-- Add more video items as needed -->
      </div>
    </div>
    <div class="section">
      <h2>Recently Viewed</h2>
      <div class="video-list">
        <div class="video-item">
          <a href="https://www.youtube.com/watch?v=eKqY-oP1d_Y" target="_blank">
            <img src="https://i.ytimg.com/vi/eKqY-oP1d_Y/hq720.jpg?sqp=-oaymwEcCOgCEMoBSFXyq4qpAw4IARUAAIhCGAFwAcABBg==&rs=AOn4CLAhPToDJ8WcQ3dgxRGyXK7Aec9dsQ" alt="Video Thumbnail" />
          </a>
          <div class="video-info">
          <h3 class="video-title" id="video-title">Loading...</h3>
            <p class="video-channel" id="video-channel">Loading...</p>
          </div>
        </div>
        <!-- Add more video items as needed -->
      </div>
    </div>
  </div>

  <script>
      // Function to fetch video details using the YouTube Data API
      async function getVideoDetails() {
        // Replace the YouTube video URL with your desired video URL
        const videoUrl = "https://www.youtube.com/watch?v=4HbOzg4aWFk&list=PLeZMjV76KKKVxUvqqofY9VQZYBP5MPKW4";

        // Parse the video ID from the URL
        const videoId = videoUrl.split("v=")[1].split("&")[0];

        // Replace YOUR_API_KEY with your actual API key
        const apiKey = "AIzaSyANIjKl5mVzCOQQlxbNMutC6SP7lT_Y-9Y";
        const apiUrl = `https://www.googleapis.com/youtube/v3/videos?part=snippet&id=${videoId}&key=${apiKey}`;

        try {
          // Fetch video details from the YouTube API
          const response = await fetch(apiUrl);
          const data = await response.json();

          // Extract video title and channel name from the API response
          const videoTitle = data.items[0].snippet.title;
          const channelName = data.items[0].snippet.channelTitle;

          // Update the video title and channel name in the HTML
          document.getElementById("video-title").textContent = videoTitle;
          document.getElementById("video-channel").textContent = channelName;
        } catch (error) {
          console.error("Error fetching video details:", error);
        }
      }

      // Call the function to get video details when the page loads
      getVideoDetails();
    </script>


</body>
</html>