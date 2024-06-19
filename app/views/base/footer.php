<footer>
    <!-- Footer content can be added here -->
</footer>
</body>
    <!-- Important -->
    <script src="<?=ASSETS?>quizbee/scripts/main.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/socket/socket.io.js"></script>

<script>

function readEvent() {
    var getcode = document.getElementById('getcode').value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "get_code/index", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            if (response.success) {
                if (response.redirectUrl) {
                    window.location.href = response.redirectUrl;
                }
            } else {
                document.getElementById('errorMessage').innerText = response.error;
                $('#errorModal').modal('show');
            }
        }
    };

    xhr.send("getcode=" + encodeURIComponent(getcode));
}

function login() {
    var username = document.getElementById('login-username').value;
    var password = document.getElementById('login-password').value;

    if (!username || !password) {
        document.getElementById('errorMessage').innerText = "Please provide both username and password.";
        $('#errorModal').modal('show');
        return;
    }

    var formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    formData.append('action', 'login');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                window.location.href = response.redirectUrl;
            } else {
                document.getElementById('errorMessage').innerText = response.error;
                $('#errorModal').modal('show');
            }
        } else {
            document.getElementById('errorMessage').innerText = "An error occurred. Please try again.";
            $('#errorModal').modal('show');
        }
    };

    xhr.onerror = function() {
        document.getElementById('errorMessage').innerText = "An error occurred. Please try again.";
        $('#errorModal').modal('show');
    };

    xhr.send(formData);
}


function register() {
    var username = document.getElementById('username').value.trim();
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value.trim();

    if (!username || !email || !password) {
        showErrorModal("All fields are required. Please fill out the username, email, and password.");
        return;
    }

    if (!email.includes('@')) {
        document.getElementById('errorMessage').innerText = "Please provide a valid email address.";
        $('#errorModal').modal('show');
        return;
    }

    if (password.length < 8) {
        document.getElementById('errorMessage').innerText = "Password must be at least 8 characters long.";
        $('#errorModal').modal('show');
        return;
    }

    var formData = new FormData();
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('action', 'register');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {

                    document.getElementById('successMessage').innerText = "Registration successful! You can now log in.";
                    $('#successModal').modal('show');

                    // Clear the input fields
                    document.getElementById('username').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('password').value = '';

                    setTimeout(function() {
                        window.location.href = response.redirectUrl;
                    }, 2000);

                } else {
                    showErrorModal('Registration failed: ' + response.error);
                }
            } catch (e) {
                console.error('Error parsing JSON response: ' + e);
            }
        } else {
            console.error('Request failed. Status: ' + xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Network error occurred.');
    };

    xhr.send(formData);
}

function showErrorModal(message) {
    document.getElementById('errorMessage').innerText = message;
    $('#errorModal').modal('show');
}

function showSuccessModal(message) {
    document.getElementById('successMessage').innerText = message;
    $('#successModal').modal('show');
}

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.getElementById('hidden-list').classList.add('fade-out');

        setTimeout(function() {
            document.getElementById('hidden-list').style.display = 'none';
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('form-container').classList.add('fade-in');
        }, 500); 
    }, 500);

    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
        $('#errorModal').modal('show');
    <?php endif; ?>
});
   
</script>
</html>    