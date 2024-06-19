<?php $this->view("quizbee/header",$data);?>

    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="container">
            <h1>BeeQuized System</h1>
            <form method="post" id="getcode-form" class="input-code">
                <input type="text" name="getcode" class="input-field" placeholder="Enter your code" required />
                <button type="submit" class="button">Enter Code</button>
                <span class="or">or</span>
                <a href="#" class="button" onclick="openLogin()">Login</a>
                <br>
                <br>
                <?php check_message()?>
            </form>
        </div>

        <!-- Login Popup -->
        <div id="login-popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeLogin()">&times;</span>
            <h2>BeeQuized System</h2>
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

            <?php check_message()?>
            
            <!-- Login Form -->
            <form
            method="post"
            id="login-form"
            class="input-login"
            style="display: none"
            >
            <input
                type="text"
                name="username"
                class="input-popup"
                placeholder="Username"
                required
            />
            <input
                type="password"
                name="password"
                class="input-popup"
                placeholder="Password"
                required
            />
            <button class="login-btn">Login</button>
            </form>

            <!-- Registration Form -->
            <form
            method="post"
            id="registration-form"
            class="input-register"
            style="display: none"
            >
            <input
                type="text"
                name="username"
                class="input-popup"
                placeholder="Username"
                required
            />
            <input
                type="email"
                name="email"
                class="input-popup"
                placeholder="Email"
                required
            />
            <input
                type="password"
                name="password"
                class="input-popup"
                placeholder="Password"
                required
            />
            <button class="register-btn">Register</button>
            </form>
        </div>
        </div>
        <!-- Overlay -->
        <div id="overlay" class="overlay"></div>




    </div>

<!-- Loading Animation -->
<div id="loading" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(255, 255, 255, 0.8); z-index:9999; flex-direction: column; justify-content:center; align-items:center;">
    <div class="spinner-question"></div>
    <p style="margin-top: 10px;">Loading, please wait...</p>
</div>    

<?php $this->view("quizbee/footer",$data);?>
