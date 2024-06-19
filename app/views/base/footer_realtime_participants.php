<footer>
    <!-- Footer content can be added here -->
</footer>
</body>
    <!-- Important -->
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/socket/socket.io.js"></script>

<script>

    //let socket = io();
    let socket = io('http://localhost:3000', {transports: ['websocket', 'polling', 'flashsocket'] });

    const choicesContainer = document.querySelector('.choices');
    let selectedChoiceText = null;
    let questionId = null;
    let basePoints = 0;
    let correctAnswer = '';

    // Warn the user before they leave the page
    
    window.addEventListener('beforeunload', function (e) {
        var confirmationMessage = 'Are you sure you want to leave? Your progress may be lost.';
        e.returnValue = confirmationMessage; 
        return confirmationMessage;       
    });

    // Disable back and forward navigation
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };

    socket.on('startQuestion', function(questionId) {

        console.log(`Received new question start event for question ID: ${questionId}`);

        // Fetch updated questions and start countdown
        fetchQuestionsAndCountdown();
    });

    // Function to fetch questions and start countdown
    function fetchQuestionsAndCountdown() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', window.location.href + '?action=get_category_and_questions', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                
                if (response.success) {
                    console.log("Questions fetched successfully:", response.questions);

                    // Handle the questions (start countdown and show questions)
                    startCountdownAndShowQuestions(response.questions);

                } else {
                    //console.error('Failed to fetch questions:', response.message);

                    showLoadingAnimationAndWaitingText();
                }
            } else {
                console.error('Request failed with status:', xhr.status);
            }
        };

        xhr.onerror = function() {
            console.error('Request failed');
        };

        xhr.send();
    }

    // Function to show loading animation and waiting text
    function showLoadingAnimationAndWaitingText() {
        document.querySelector('#loadingAnimation').style.display = 'block';
        document.querySelector('#waitingText').style.display = 'block';
        document.querySelector('#upperTimer').style.display = 'none';
        document.querySelector('#imageQuestion').style.display = 'none';
        document.querySelector('#questionContainer').style.display = 'none';
    }

    // Function to start countdown and display questions
    function startCountdownAndShowQuestions(questions) {
        // Hide the loading animation and waiting text
        document.querySelector('#loadingAnimation').style.display = 'none';
        document.querySelector('#waitingText').style.display = 'none';
        document.querySelector('#upperTimer').style.display = 'none';
        document.querySelector('#imageQuestion').style.display = 'none';
        document.querySelector('#questionContainer').style.display = 'none';
        
        // Show the countdown message
        const countdownElement = document.querySelector('#countdownMessage');
        countdownElement.style.display = 'block';

        let countdown = 3;
        countdownElement.querySelector('h2').innerText = countdown;

        const countdownInterval = setInterval(() => {
            countdown--;
            if (countdown > 0) {
                countdownElement.querySelector('h2').innerText = countdown;
            } else {
                clearInterval(countdownInterval);
                // Show the questions after countdown
                countdownElement.querySelector('h2').innerText = 'Go!';
                setTimeout(() => {
                    showQuestions(questions);
                    countdownElement.style.display = 'none'; 
                }, 500);
            }
        }, 500);
    }

    function showQuestions(questions) {
        // Assuming the first question for this example
        const question = questions[0];

        // Display the question image
        const imageQuestionElement = document.querySelector('#imageQuestion');
        if (question.question_image) {
            imageQuestionElement.querySelector('img').src = question.question_image;
            imageQuestionElement.style.display = 'block';
            document.querySelector('#questionContainer').style.display = 'block';
        } else {
            imageQuestionElement.style.display = 'none';
        }

        // Convert timer format HH:MM:SS to total seconds
        const totalSeconds = parseTimerToSeconds(question.timer);
        
        // Display the timer
        const timerElement = document.querySelector('#upperTimer');
        timerElement.innerText = totalSeconds + ' seconds';
        timerElement.style.display = 'block';

        // Display the choices
        const choicesContainer = document.querySelector('.choices');
        const choiceLabels = ['A', 'B', 'C', 'D'];
        const choices = [question.choice_1, question.choice_2, question.choice_3, question.choice_4];

        choicesContainer.innerHTML = ''; // Clear existing choices

        choices.forEach((choice, index) => {
            const colDiv = document.createElement('div');
            colDiv.classList.add('col-md-6', 'mb-3');

            const choiceDiv = document.createElement('div');
            choiceDiv.classList.add('choice', 'p-4', 'text-center', 'border', 'rounded');
            choiceDiv.dataset.choice = choiceLabels[index];

            // input
            const inputElement = document.createElement('input');
            inputElement.type = 'radio';
            inputElement.id = 'choice' + choiceLabels[index];
            inputElement.name = 'choices';
            inputElement.classList.add('form-control', 'choice-input', 'd-none');
            inputElement.dataset.questionId = question.id; // Store question_id in data attribute
            questionId = question.id;

            // label
            const labelElement = document.createElement('label');
            labelElement.htmlFor = inputElement.id;
            labelElement.classList.add('text-white', 'fs-3');
            labelElement.innerText = choice;

            choiceDiv.appendChild(inputElement);
            choiceDiv.appendChild(labelElement);
            colDiv.appendChild(choiceDiv);
            choicesContainer.appendChild(colDiv);

             // Add click event listener to each choice
            choiceDiv.addEventListener('click', function() {

                selectedChoiceText = choice;  // Store the actual choice text
                questionId = inputElement.dataset.questionId;
                basePoints = question.base_points;
                correctAnswer = question.correct_answer;

                console.log(`Question ID: ${questionId}, Selected Choice: ${selectedChoiceText}`);
                console.log(basePoints);
                console.log(correctAnswer);
             
                // Clear selected class from all choices and check the clicked choice
                choicesContainer.querySelectorAll('.choice').forEach(function(c) {
                    c.classList.remove('selected');
                });
                choiceDiv.classList.add('selected');
            });
        });

        countdownTimer(totalSeconds);
    }

    // parse timer format HH:MM:SS to total seconds
    function parseTimerToSeconds(timer) {
        const parts = timer.split(':');
        return parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + parseInt(parts[2]);
    }

    // run countdown timer
    function countdownTimer(totalSeconds) {
        let countdown = totalSeconds;

        const countdownInterval = setInterval(() => {
            countdown--;

            // Update timer display
            const timerElement = document.querySelector('#upperTimer');
            timerElement.innerText = countdown + ' seconds';

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                timerElement.innerText = '0 seconds';
                showResult();
            }
        }, 800); 
    }

    // show modal if the answer is correct or not
    function modalShow(){

        const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
        const resultMessageElement = document.getElementById('resultMessage');
        const resultScoreElement = document.getElementById('resultScore');
        const correctAnswerMessageElement = document.getElementById('correctAnswerMessage');
        const modalHeaderElement = document.querySelector('#resultModal .modal-header');

        if (selectedChoiceText) {
            if (selectedChoiceText === correctAnswer) {
                resultMessageElement.innerText = 'Correct Answer!';
                resultScoreElement.innerText = 'Your Score: ' + basePoints;
                correctAnswerMessageElement.innerText = '';
                modalHeaderElement.classList.add('correct');
                modalHeaderElement.classList.remove('wrong');
            } else {
                resultMessageElement.innerText = 'Wrong Answer!';
                resultScoreElement.innerText = 'Your Score: 0';
                correctAnswerMessageElement.innerText = 'The correct answer is: ' + correctAnswer;
                modalHeaderElement.classList.add('wrong');
                modalHeaderElement.classList.remove('correct');
            }
        } else {
            resultMessageElement.innerText = 'No answer given';
            resultScoreElement.innerText = 'Your Score: 0';
            modalHeaderElement.classList.add('wrong');
            modalHeaderElement.classList.remove('correct');
        }

        resultModal.show();
    }

    function showResult() {

        if (selectedChoiceText === correctAnswer) {
            basePoints = basePoints; 
        } else {
            basePoints = 0; 
        }
       

        setTeamScore(questionId, basePoints);
        modalShow();
        console.log("Showing result or moving to the next question...");

    }

    function setTeamScore(questionID, score) {

        if (questionId === null) {
            console.error('No question ID selected.');
            return; 
        }

        const formData = new FormData();
        formData.append('action', 'set_team_score'); 
        formData.append('questionID', questionID); 
        formData.append('score', score || 0); 

        const xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    console.log('Team score updated successfully');

                    socket.emit('updateTeamScore', score);

                    fetchQuestionsAndCountdown();

                } else {
                    console.error('Failed to update team score:', response.error);
                    
                }
            } else {
                console.error('Request failed with status:', xhr.status);
               
            }
        };

        xhr.onerror = function() {
            console.error('Request failed');
            
        };

        xhr.send(formData); 
    }

    fetchQuestionsAndCountdown();

    
        
    

</script>
</html>