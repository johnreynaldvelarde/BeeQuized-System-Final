<footer>
    <!-- Footer content can be added here -->
</footer>
</body>
    <!-- Important -->
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/socket/socket.io.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <!-- Include jsPDF for PDF generation -->
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jspdf.umd.min.js"></script>

    <!-- Include xlsx.full.min.js for Excel generation -->
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

<script>
    

    let currentCategoryId = null;

    let socket = io('http://localhost:3000', {transports: ['websocket', 'polling', 'flashsocket'] });

        const categoryLinks = document.querySelectorAll('.list-group-item');
        

        categoryLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const selectedCategory = this.getAttribute('data-category');

                categoryLinks.forEach(function (link) {
                    link.classList.remove('active');
                });

                this.classList.add('active');
            });
        });

        fetchTeams();
        fetchCategories();
        
        socket.on('updateTeamScore', function(score) {
            console.log(`Received team score: ${score}`);
            fetchTeams();
        });

        function fetchTeams() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', window.location.href + '?action=get_teams', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        displayErrorMessage(response.error);
                    } else {
                        displayTeams(response);
                        displayTeamsScoreLeaderBoard(response);
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

        function displayTeams(teams) {
            const teamList = document.getElementById('team-list');

            // Clear previous content
            teamList.innerHTML = '';

            teams.forEach(team => {
                const totalScore = team.total_score !== undefined ? team.total_score : 0; 

                const teamElement = document.createElement('div');
                teamElement.classList.add('list-group-item', 'd-flex', 'align-items-center', 'me-3', 'mb-3');
                teamElement.innerHTML = `
                    <div class="flex-fill d-flex justify-content-between align-items-center">
                        <span class="me-2">${team.team_name}</span>
                        <span class="badge bg-primary rounded-pill">Score: ${totalScore}</span>
                    </div>
                `;
                teamList.appendChild(teamElement);
            });
        }

        function displayErrorMessage(message) {
            const teamList = document.getElementById('team-list');
            teamList.innerHTML = `<p class="text-danger">${message}</p>`;
        }

        // get category
        function fetchCategories() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', window.location.href + '?action=get_category', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        displayCategoryError(response.error);
                    } else {
                        displayCategories(response);
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

        function displayCategories(categories) {
            const categoryList = document.getElementById('categoryList');

            // Clear previous content
            categoryList.innerHTML = '';

            categories.forEach(category => {
                const categoryElement = document.createElement('div');
                categoryElement.classList.add('category-item', 'box', 'p-3', 'mb-2', 'bg-white', 'rounded');
                categoryElement.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                categoryElement.dataset.categoryId = category.id;

                categoryElement.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p><strong>Name:</strong> ${category.category_name}</p>
                            <p><strong>Base Points:</strong> ${category.base_points}</p>
                        </div>
                        <div>
                            <button class="btn btn-primary mr-2" onclick="selectCategory(${category.id})">Select</button>
                            <!-- <button class="btn btn-danger" onclick="deleteCategory(${category.id})">-</button> -->
                        </div>
                    </div>
                `;

                categoryList.appendChild(categoryElement);
            });
        }

        function displayCategoryError(message) {
            const categoryList = document.getElementById('categoryList');
            categoryList.innerHTML = `<p class="text-danger">${message}</p>`;
        }

        const event_id = <?= json_encode($_SESSION['event_id']); ?>;

        window.addCategory = function() {
            const categoryNameInput = document.getElementById('categoryNameInput');
            const basePointsInput = document.getElementById('basePointsInput');
            const categoryName = categoryNameInput.value.trim();
            const basePoints = basePointsInput.value.trim();

            if (categoryName === '') {
                categoryNameInput.style.borderColor = 'red';
                document.getElementById('categoryNameError').innerText = 'Please enter a category name.';
                return;
            } else {
                categoryNameInput.style.borderColor = '';
                document.getElementById('categoryNameError').innerText = '';
            }

            if (basePoints === '' || isNaN(basePoints)) {
                basePointsInput.style.borderColor = 'red';
                document.getElementById('basePointsError').innerText = 'Please enter a valid number for base points.';
                return;
            } else {
                basePointsInput.style.borderColor = '';
                document.getElementById('basePointsError').innerText = '';
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', window.location.href, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Server response:', response); // Log the full response
                        if (response.success) {
                            fetchCategories(); // Refresh the category list
                            categoryNameInput.value = '';
                            basePointsInput.value = '';
                        } else {
                            console.error('Failed to add category:', response.error);
                        }
                    } catch (e) {
                        console.error('Failed to parse JSON response:', xhr.responseText);
                    }
                } else {
                    console.error('Request failed with status:', xhr.status);
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
            };

            const data = `action=set_category&categoryName=${encodeURIComponent(categoryName)}&basePoints=${encodeURIComponent(basePoints)}`;
            xhr.send(data);
        };


        window.selectCategory = function(categoryId) {

            currentCategoryId = categoryId;
            // Remove active class from all categories
            const categories = document.querySelectorAll('.category-item');
            categories.forEach(category => {
                category.classList.remove('border-primary');
            });

            // Add border class to selected category
            const selectedCategory = document.querySelector(`[data-category-id="${categoryId}"]`);
            if (selectedCategory) {
                selectedCategory.classList.add('border-primary');
            }

            // Fetch and display related questions (sample function)
            fetchQuestions(categoryId);
        }

        function fetchQuestions(categoryId) {
            console.log(`Fetching questions for category ${categoryId}`);
            
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `${window.location.href}?action=get_questions&category_id=${categoryId}`, true);
        
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);

                        if (response.error) {
                            console.error('Error from server:', response.error);
                            clearQuestionsList();
                        } else {
                            displayQuestions(response); // Assuming displayQuestions is defined
                        } 
                    } catch (error) {
                        console.error('Failed to parse JSON response:', error);
                    }
                } else {
                    console.error('Request failed. Status:', xhr.status);
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
            };

            xhr.send();
        }

        // display questions related to category selected by quizmaster
        function displayQuestions(questions) {
            const questionContainer = document.getElementById('question-container');
            questionContainer.innerHTML = ''; // Clear previous questions if any

            if (questions.length === 0) {
                // If no questions, display an alert
                alert('No questions yet for this category.');
                return;
            }

            questions.forEach(question => {
                const questionElement = document.createElement('div');
                questionElement.classList.add('box', 'shadow', 'p-3', 'mb-3', 'bg-white', 'rounded', 'reduced-shadow');

                // Convert HH:MM:SS to total seconds
                const [hours, minutes, seconds] = question.timer.split(':').map(Number);
                const totalSeconds = hours * 3600 + minutes * 60 + seconds;

                // Function to create choice button
                const createChoiceButton = (choiceText, index) => {
                    const isCorrect = question.correct_answer === choiceText;
                    return `
                        <button type="button" 
                                class="list-group-item list-group-item-action answer-btn ${isCorrect ? 'correct-answer' : ''}" 
                                data-question-id="${question.id}" 
                                data-choice-index="${index}">
                            ${choiceText}
                        </button>
                    `;
                };

                 // Determine button state based on question status
                const isQuestionStarted = question.status === 2;
                const buttonDisabled = isQuestionStarted ? 'disabled' : '';

                // Determine button labels based on question status
                let startButtonLabel = 'Start';
                let rankingsButtonLabel = 'Show Rankings';

                if (isQuestionStarted) {
                    startButtonLabel = 'Finish';
                    rankingsButtonLabel = 'Not Available';
                }

                // Construct the inner HTML for each question
                questionElement.innerHTML = `
                    <div class="row">
                        <div class="col-md-4">
                            <img src="${question.question_image}" class="img-fluid mb-3" alt="Question Image" style="max-width: 100%; height: 150px;">
                        </div>
                        <div class="col-md-8 d-flex">
                            <div class="flex-grow-1">
                                <div class="list-group">
                                    ${createChoiceButton(question.choice_1, 0)}
                                    ${createChoiceButton(question.choice_2, 1)}
                                    ${createChoiceButton(question.choice_3, 2)}
                                    ${createChoiceButton(question.choice_4, 3)}
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center ms-3">
                                <input type="number" class="form-control mb-2" id="timer-${question.id}" name="timer" placeholder="Set a timer" min="1" value="${totalSeconds}" readonly>
                                <button class="btn btn-primary mb-2" data-question-id="${question.id}" ${buttonDisabled} onclick="startQuestion(${question.id})">${startButtonLabel}</button>
                                <button class="btn btn-success mb-2" data-question-id="${question.id}" ${buttonDisabled}>${rankingsButtonLabel}</button>
                                <!-- <button class="btn btn-danger mb-2" data-question-id="${question.id}" onclick="deleteQuestion(${question.id})">Delete</button> -->
                            </div>
                        </div>
                    </div>
                `;

                questionContainer.appendChild(questionElement);
            });
        }

        function clearQuestionsList(){
            const questionContainer = document.getElementById('question-container');
            questionContainer.innerHTML = '';
        }


        // function to update question status to 1
        function startQuestion(questionId) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', window.location.href + `?action=update_question_status&question_id=${questionId}`, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {

                            // Emit a socket event to notify participants about the new question
                            socket.emit('startQuestion', questionId);

                            fetchQuestions(currentCategoryId); // Show success message

                            // Start countdown timer and display countdown in modal
                            const timerInput = document.getElementById(`timer-${questionId}`);
                            const totalSeconds = parseInt(timerInput.value);
                            startCountdownModal(totalSeconds, `Question ${questionId}`); // Start countdown and show modal
                           
                        } else {
                            displayErrorModal('Failed to update question status', 'Error');
                        }
                    } catch (error) {
                        console.error('Failed to parse JSON response:', error);
                        displayErrorModal('Failed to parse server response', 'Error');
                    }
                } else {
                    console.error('Request failed. Status:', xhr.status);
                    displayErrorModal('Request failed', 'Error');
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
                displayErrorModal('Request failed', 'Error');
            };
            xhr.send();
        }

        
        // function to start countdown and show modal
        function startCountdownModal(totalSeconds, questionLabel) {
            let secondsRemaining = totalSeconds;

            // Update countdown message initially
            $('#countdownMessage').text(`${secondsRemaining} seconds remaining`);
            
            // Show overlay to disable interactions
            $('.overlay').show();

            // Show countdown modal
            $('#countdownModal').modal({
                backdrop: 'static', // Prevent modal from closing on backdrop click
                keyboard: false // Prevent modal from closing on ESC key press
            });

            // Disable close button in modal header
            $('#countdownModal .btn-close').prop('disabled', true);

            const intervalId = setInterval(() => {
                secondsRemaining--;
                if (secondsRemaining >= 0) {
                    $('#countdownMessage').text(`${secondsRemaining} seconds remaining`);
                } else {
                    clearInterval(intervalId);
                    $('#countdownMessage').text(`Time's up!`);
                    $('#countdownModal .btn-close').prop('disabled', false);


                    // Hide countdown modal and overlay
                    setTimeout(() => {
                        $('#countdownModal').modal('hide');
                        $('.overlay').hide();
                    }, 2000); // Delay for 2 seconds (adjust as needed)
                }
            }, 1000); 
        }

        // hide the countdown modal
        function hideCountdownModal() {
            $('#countdownModal').modal('hide');
            $('.overlay').hide();
        }

        // prevent navigation away from the page
        window.addEventListener('beforeunload', function (e) {
            if ($('#countdownModal').hasClass('show')) {
                e.preventDefault();
                e.returnValue = ''; 
            }
        });

        // prevent back and forward navigation
        window.addEventListener('popstate', function (e) {
            // Check if countdown modal is active
            if ($('#countdownModal').hasClass('show')) {
                history.pushState(null, null, location.href);
            }
        });

        //display error modal with message
        function displayErrorModal(message, title) {
            $('#errorMessage').text(message);
            $('#errorModalLabel').text(title);
            $('#errorModal').modal('show');
        }

        // delete a questions
        function deleteQuestion(questionId) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', window.location.href + `?action=delete_question&question_id=${questionId}`, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        alert(response.message); 
                        fetchQuestions(currentCategoryId); 

                        
                    } catch (error) {
                        console.error('Failed to parse JSON response:', error);
                    }
                } else {
                    console.error('Request failed. Status:', xhr.status);
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
            };

            xhr.send();
        }

        $(document).ready(function() {

            // Function to show the leaderboard modal
            function showLeaderboardModal() {
                $('#leaderboardModal').modal('show');
            }

            // Function to export table to Excel
            function exportToExcel() {
                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.table_to_sheet(document.getElementById('leaderboardTable'));
                XLSX.utils.book_append_sheet(wb, ws, 'Leaderboard');
                XLSX.writeFile(wb, 'leaderboard.xlsx');
            }

            // Bind click event to the "Export as Excel" button
            $('#exportExcelBtn').on('click', function() {
                exportToExcel();
            });

            // Bind click event to the "Show Leaderboard" button
            $('#showLeaderboardBtn').on('click', function() {
                showLeaderboardModal();
            });

            // Event listener for the Show Leaderboard button outside of document.ready
            $('.btn-show-leaderboard').click(function() {
                showLeaderboardModal();
            });
        });

        function displayTeamsScoreLeaderBoard(teams) {
            const leaderboardTable = document.getElementById('leaderboardTable');
            const tbody = leaderboardTable.querySelector('tbody');

            // Clear previous content
            tbody.innerHTML = '';

            teams.forEach((team, index) => {
                const totalScore = team.total_score !== undefined ? team.total_score : 0;

                // Create a new table row (tr) for each team
                const row = document.createElement('tr');
                row.innerHTML = `
                    <th scope="row">${index + 1}</th>
                    <td>${team.team_name}</td>
                    <td>${totalScore}</td>
                `;

                // Append the row to the tbody of the leaderboard table
                tbody.appendChild(row);
            });

            // Show the leaderboard modal if it's hidden
            $('#leaderboardModal').modal('show');
        }

        // Function to handle showing the leaderboard modal
        function showLeaderboard() {
            $('#leaderboardModal').modal('show'); // Show the leaderboard modal
        }

        // Event listener for the Show Leaderboard button
        $(document).ready(function() {
            $('.btn-show-leaderboard').click(function() {
                showLeaderboard();
            });
        });

            // Assign jsPDF if it's not defined
        if (!window.jsPDF && window.jspdf) {
            window.jsPDF = window.jspdf.jsPDF;
        }

        // Function to export table to PDF
        function exportToPDF() {
            const doc = new jsPDF();
            doc.autoTable({ html: '#leaderboardTable' });
            doc.save('leaderboard.pdf');
        }
        

        // Bind click event to the "Export as PDF" button
        $(document).ready(function() {
            $('#exportPdfBtn').on('click', function() {
                exportToPDF();
            });
        });

        function fetchUpdateQuizEvent() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', window.location.href + '?action=update_quizevent', true); 

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        console.error('Error updating quiz event:', response.error);
                    } else if (response.success) {

                        console.log('Quiz event status updated successfully');

                        window.location.href = "<?php echo ROOT . 'quiz_master'; ?>";

                    } else {
                        console.error('Unexpected response:', response);
                        // Handle unexpected response
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


        document.getElementById('finishEventBtn').addEventListener('click', function() {

            let canvas = document.createElement("canvas");
            canvas.width = window.innerWidth; 
            canvas.height = window.innerHeight; 

            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.zIndex = '1000'; 

            document.body.appendChild(canvas);

            let confetti_button = confetti.create(canvas);
            confetti_button({
                particleCount: 600,
                spread: 600,
                startVelocity: 30,
                scalar: 0.9,
                ticks: 100
            }).then(() => {
                document.body.removeChild(canvas);
                fetchUpdateQuizEvent();
            });
        });


        
</script>
</html>