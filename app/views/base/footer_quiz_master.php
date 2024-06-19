<footer>
    <!-- Footer content can be added here -->
</footer>
</body>
    <!-- Important -->
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/socket/socket.io.js"></script>

<script>

    //var socket = io('http://localhost:3000');
    //var io = io('http://localhost:3000', {transports: ['websocket', 'polling', 'flashsocket'] });
    //--var server = "http://localhost:3000";

    //var io = io('http://localhost:3000', {transports: ['websocket', 'polling', 'flashsocket'] });

    

    function validateInput(event) {
        const input = event.target;
        if (input.value.trim() === '') {
            input.classList.add('border-danger');
        } else {
            input.classList.remove('border-danger');
        }
    }

    function clearFields() {
        document.getElementById('quizmasterForm').reset();
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('border-danger');
        });
    }

    function saveQuizmaster() {
        
        const quizmasterName = document.getElementById('quizmasterName');
        let valid = true;
        let errorMessages = [];

        if (quizmasterName.value.trim() === '') {
            quizmasterName.classList.add('border-danger');
            errorMessages.push('Please enter quizmaster name.');
            valid = false;
        } else {
            quizmasterName.classList.remove('border-danger');
        }

        if (!valid) {
            document.getElementById('errorMessage').innerHTML = errorMessages.join('<br>');
            $('#errorModal').modal('show');
            return;
        }

        const quizmasterData = {
            name: quizmasterName.value
        };

        //io.emit("newQuizMaster", quizmasterName);

        const formData = new FormData();
        formData.append('action', 'set_quizmaster');
        formData.append('quizmasterName', quizmasterName.value);

        document.getElementById('loading').style.display = 'flex';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {

                    setTimeout(function() { 
                            window.location.href = "<?php echo ROOT . 'realtime_quizmaster'; ?>";
                    }, 1000);

                } else {
                    //alert('Error: ' + response.error);
                    document.getElementById('errorMessage').innerHTML = 'Error: ' + response.error;
                    $('#errorModal').modal('show');
                }
            } else {
                //alert('Error saving quiz master name.');
                document.getElementById('errorMessage').innerHTML = 'Error saving quiz master name.';
                $('#errorModal').modal('show');
            }
        };

        xhr.onerror = function() {
            //alert('Request failed.');
            document.getElementById('loading').style.display = 'none';
            document.getElementById('errorMessage').innerHTML = 'Request failed.';
            $('#errorModal').modal('show');
        };

        xhr.send(formData);
    }

</script> 
</html>