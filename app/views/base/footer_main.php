<footer>
    <!-- Footer content can be added here -->
</footer>
</div>
</body>
    <!-- Important -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>

<script>
    let subMenu = document.getElementById("subMenu");
    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

    function generateCodes() {
        document.getElementById('quizMasterCode').value = 'QM' + Math.random().toString(36).substr(2, 9);
        document.getElementById('participantCode').value = 'PC' + Math.random().toString(36).substr(2, 9);
        document.getElementById('audienceCode').value = 'AC' + Math.random().toString(36).substr(2, 9);
    }

    document.getElementById('createQuizForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    document.getElementById('loading').style.display = 'flex'; // Show the loading animation

        // Submit the form data using AJAX
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, true);
        xhr.onload = function() {
            //document.getElementById('loading').style.display = 'none';
            if (xhr.status === 200) {
                setTimeout(function() {
                    //showNotification('Quiz event created successfully!');
                    window.location.href = "<?php echo ROOT . 'create_question'; ?>";
                }, 1000); 
            } else {
                // Handle errors here
                document.getElementById('loading').style.display = 'none'; // Hide the loading animation
                alert('An error occurred while creating the quiz.');
            }
        };
        xhr.send(formData);
    });
    
</script>
</html>


