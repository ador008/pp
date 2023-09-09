<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="signup.css" />
    <title>Sign Up</title>
  </head>
  <body>
    <a href="home.php">
        <img src="logo.png" alt="Logo" />
      </a>
    <form action="signupprocess.php" method="post">
      <h4>Welcome to LearningHub Community</h4>
      
      <input type="text" name="full_name" placeholder="Full Name" />
      <input type="email" name="email" placeholder="Email" />
      <input type="password" name="password" placeholder="Password" />
      <input
        type="password"
        name="confirm_password"
        placeholder="Confirm Password"
      />

      <!-- Add a dropdown to select semesters -->
      <select name="semester" id="semesters" >
        <option>Select Semester</option>
        <option value="1">1st Semester</option>
        <option value="2">2nd Semester</option>
        <option value="3">3rd Semester</option>
        <option value="4">4th Semester</option>
        <option value="5">5th Semester</option>
        <option value="6">6th Semester</option>
        <option value="7">7th Semester</option>
        <option value="8">8th Semester</option>
      </select>

      <button type="submit">Sign Up</button>

      <div class="signin-content">
        Already have an account?
        <a href="signin.php">Sign In</a>
      </div>
    </form>
  </body>
</html>
