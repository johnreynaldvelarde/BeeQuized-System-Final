<footer>
    <!-- Footer content can be added here -->
</footer>
</div>
</body>
    <!-- Important -->
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/socket/socket.io.js"></script>

<script>

    var socket = io('http://localhost:3000', {transports: ['websocket', 'polling', 'flashsocket'] });

    document.addEventListener('DOMContentLoaded', function() {
        let quizmasterItem = document.getElementById('quizmaster-item');
        let waitingMessage = document.getElementById('waitingMessage');
        let loadingSpinner = document.getElementById('loadingSpinner');

        fetchQuizMasters();
        
        function fetchQuizMasters() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', window.location.href + '?action=get_quiz_master', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const quizMasters = JSON.parse(xhr.responseText);
                    displayQuizMasters(quizMasters);
                } else {
                    console.error('Failed to fetch quiz masters');
                    displayNoQuizMasters();
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
                displayNoQuizMasters();
            };

            xhr.send();
        }

        function displayQuizMasters(quizMasters) {
            quizmasterItem.innerHTML = '';

            if (quizMasters.length > 0) {
                quizMasters.forEach(quizMaster => {
                    const quizmasterCard = `
                        <div class="player-item box me-2 mb-2 bg-white rounded d-flex align-items-center p-3" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <img src="<?= ASSETS ?>quizbee/images/nature_background.jpg" alt="Quiz Master" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 15px;">
                            <p style="font-size: 24px; color: #007bff; margin: 0;"><strong>${quizMaster.quizmaster_name}</strong></p>
                        </div>
                    `;
                    quizmasterItem.insertAdjacentHTML('beforeend', quizmasterCard);
                });

                quizmasterItem.classList.remove('d-none');
                waitingMessage.style.display = 'none'; // Hide the waiting message

            } else {
                displayNoQuizMasters();
            }

            // Hide the loading spinner
            loadingSpinner.style.display = 'none';
        }

        function displayNoQuizMasters() {
            quizmasterItem.innerHTML = '<p>No quiz masters available</p>';
            loadingSpinner.style.display = 'none'; // Hide the loading spinner
            waitingMessage.style.display = 'block'; // Show the waiting message
        }

        // Listen for 'newQuizMaster' event
        
        socket.on('newQuizMaster', function(quizMasterName) {
            fetchQuizMasters();
        });
        
    });
</script>
</html>


