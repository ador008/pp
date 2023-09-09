<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="signin.css" />
    <title>Signin</title>
  </head>
  <body>
    <a href="home.php">
      <img src="logo.png" alt="Logo" />
    </a>
    <form action="signinprocess.php" method="post">
      <h4>Welcome to LearningHub Community</h4>
      <input type="email" name="email" placeholder="Enter your email" />
      <input type="password" name="pw" placeholder="Enter password" />
      <button type="submit">Sign In</button>

      <div class="signup-content">
        New to LearningHub ?
        <a href="signup.php">Sign Up</a>
      </div>
      <div class="signup-content">
        <a href="forgetpass.php">Forgot your password ?</a>
      </div>
    </form>
  </body>
</html>
