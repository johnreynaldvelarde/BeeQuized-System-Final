<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data['page_title'] . " | " . "Quiz Bee System"?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?=ASSETS?>quizbee/css/main_corner.css" />
    <link rel="stylesheet" href="<?=ASSETS?>quizbee/css/index-style.css" />
    
</head>

<body style="min-height: 100vh; display: flex; flex-direction: column; background: linear-gradient(to right, #2d388a, #00aeef), url('<?= ASSETS ?>quizbee/images/7941359.jpg'); background-blend-mode: multiply; background-size: cover;">

    <div class="d-flex align-items-center justify-content-center vh-100">
        
    <div class="container">
        <!-- Initially shown, hidden after 5 seconds -->
        <ul id="hidden-list" class="fade-list">
            <li style="--i: 1">B</li>
            <li style="--i: 2">E</li>
            <li style="--i: 3">E</li>
            <li style="--i: 4">Q</li>
            <li style="--i: 5">U</li>
            <li style="--i: 6">I</li>
            <li style="--i: 7">Z</li>
            <li style="--i: 8">E</li>
            <li style="--i: 9">D</li>
        </ul>

        <!-- Initially hidden, shown after 5 seconds -->
        <div id="form-container" class="row mt-4 justify-content-center fade-form" style="display: none;">
            <div class="col-md-6">
                    <div class="containers" style="background: linear-gradient(to right, #6454F0, #3499FF), url('<?= ASSETS ?>quizbee/images/rough_background.jpg'); background-blend-mode: multiply; background-size: cover; padding: 50px; border-radius: 10px;">
                        <h1 class="text-center mb-4" style="color: white; font-weight: 600; margin-top: 30px;">Welcome to BeeQuized</h1>
                        <form method="post" id="getcode-form" class="input-code">
                            <div class="input-group mb-3">
                                <input type="text" id="getcode" name="getcode" class="form-control form-control-lg" placeholder="Enter your code" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-lg floating-btn" onclick="readEvent()">Enter Code</button>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <span class="or" style="color: white; font-weight: 600;">or</span>
                            </div>
                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-success btn-lg floating-btn" onclick="openLogin()">Login</a>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="login-popup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="closeLogin()">&times;</span>
                <h2 id="popup-header" style="font-weight: 900; background: linear-gradient(to right, #2d388a, #00aeef); -webkit-background-clip: text; color: transparent;">Welcome to BeeQuized</h2>
                <div class="button-box">
                    <div id="btn"></div>
                    <button type="button" class="toggle-btn" data-form="login-form" onclick="toggleForm('login-form')">Log In</button>
                    <button type="button" class="toggle-btn" data-form="registration-form" onclick="toggleForm('registration-form')">Register</button>
                </div>

                <!-- Login Form -->
                <form method="post" id="login-form" class="input-login" style="display: none">
                    <input type="text" id="login-username" name="username" class="input-popup" placeholder="Username" required />
                    <input type="password" id="login-password" name="password" class="input-popup" placeholder="Password" required />
                    <button type="button" class="login-btn" onclick="login()">Login</button>
                </form>

                <!-- Registration Form -->
                <form method="post" id="registration-form" class="input-register" style="display: none">
                    <input type="text" id="username" name="username" class="input-popup" placeholder="Username" required />
                    <input type="email" id="email" name="email" class="input-popup" placeholder="Email" required />
                    <input type="password" id="password" name="password" class="input-popup" placeholder="Password" required />
                    <button type="button" class="register-btn" onclick="register()">Register</button>
                </form>
            </div>
        </div>
        <!-- Overlay -->
        <div id="overlay" class="overlay"></div>
    </div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(to right, #ef4136, #fbb040);">
                <img src="<?= ASSETS ?>quizbee/images/warning_icon.png" class="error-icon" alt="Error Icon" style="width: 30px; height: 30px;">
                <h5 class="ms-2 modal-title" id="errorModalLabel">Warning</h5>
            </div>
            <div class="modal-body" id="errorMessage">
                <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                    <p><?php echo $_SESSION['error']; ?></p>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(to right, #4caf50, #2196f3)">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
    
<?php $this->view("base/footer",$data);?>
