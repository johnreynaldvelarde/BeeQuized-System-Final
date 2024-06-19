<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Get Event Code</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="<?=ASSETS?>quizbee/css/index-style.css" />
    <script src="<?=ASSETS?>quizbee/scripts/main.js"></script>
  </head>
  <body>
    <div class="container">
      <h1>Quiz Bee System</h1>

      <input type="text" placeholder="Enter your code" />
      <a href="#" class="button" onclick="">Enter Code</a>
      <span class="or">or</span>
      <a href="#" class="button" onclick="openLogin()">Login</a>
    </div>

    <!-- Login Popup -->
    <div id="login-popup" class="popup">
      <div class="popup-content">
        <span class="close" onclick="closeLogin()">&times;</span>
        <h2>STI Quiz Bee System</h2>
        <div class="button-box">
          <div id="btn"></div>
          <button
            type="button"
            class="toggle-btn"
            data-form="login-form"
            onclick="toggleForm('login-form')"
          >
            Log In
          </button>
          <button
            type="button"
            class="toggle-btn"
            data-form="registration-form"
            onclick="toggleForm('registration-form')"
          >
            Register
          </button>
        </div>

        <?php if (isset($_GET['success'])){ ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['error'])){ ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        
        <!-- Login Form -->
        <form
          action="conn/login-check.php"
          id="login-form"
          class="input-login"
          style="display: none"
        >
          <input
            type="text"
            name="l_uname"
            class="input-field"
            placeholder="Username"
            required
          />
          <input
            type="password"
            name="l_password"
            class="input-field"
            placeholder="Password"
            required
          />
          <button type="submit" class="login-btn">Login</button>
        </form>

        <!-- Registration Form -->
        <form
          action="conn/register-check.php"
          method="POST"
          id="registration-form"
          class="input-register"
          style="display: none"
        >
          <input
            type="text"
            name="r_uname"
            class="input-field"
            placeholder="Username"
            required
          />
          <input
            type="email"
            name="r_email"
            class="input-field"
            placeholder="Email"
            required
          />
          <input
            type="password"
            name="r_password"
            class="input-field"
            placeholder="Password"
            required
          />
          <button type="submit" class="register-btn" onclick="submitRegistrationForm()">Register</button>
        </form>
      </div>
    </div>
    <!-- Overlay -->
    <div id="overlay" class="overlay"></div>
  </body>
</html>
