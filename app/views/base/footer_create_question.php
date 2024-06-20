<footer>
    <!-- Footer content can be added here -->
</footer>
</div>
</body>
<script>
    
    // list add category
    function addCategory() {
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

        const formData = new FormData();
        formData.append('categoryName', categoryName);
        formData.append('basePoints', basePoints);
        formData.append('action', 'add_category');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php?url=create_question', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {

                    console.log('Category added successfully!');

                    categoryNameInput.value = '';
                    basePointsInput.value = '';
                    showCategoryList();

                } else {
                    console.error('Error adding category:', response.error);
                }
            } else {
                console.error('Error adding category:', xhr.statusText);
            }
        };

        xhr.send(formData);
    }

    // update category list
    function showCategoryList() {
        console.log('update category');

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?url=create_question&action=view_all_category', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const categoryList = document.getElementById('categoryList');
                categoryList.innerHTML = ''; 

                const categories = JSON.parse(xhr.responseText);

                categories.forEach(function(category) {
                    const categoryItem = document.createElement('div');
                    categoryItem.className = 'category-item box p-3 mb-2 bg-white rounded';
                    categoryItem.setAttribute('data-category-id', category.id);
                    categoryItem.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                    categoryItem.innerHTML = `
                        <p><strong>Name:</strong> ${category.category_name}</p>
                        <p><strong>Base Points:</strong> ${category.base_points}</p>
                        <button class="btn btn-primary mr-2" onclick="selectCategory(this)">Select</button>
                        <button class="btn btn-danger">-</button>
                    `;
                    categoryList.appendChild(categoryItem);
                });

                // Add animation class to category items
                const categoryItems = document.querySelectorAll('.category-item');
                categoryItems.forEach(item => {
                    item.classList.add('category-animation');
                });

                //console.log('Category list updated successfully!');
            } else {
                console.error('Error updating category list:', xhr.statusText);
            }
        };

        xhr.send();
    }

    // open file
    document.getElementById('questionImage').addEventListener('change', function(event) {
        const imageInputBox = document.getElementById('imageInputBox');
        const imagePreview = document.getElementById('questionImagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            imagePreview.style.display = 'none';
        }
    });

    // show image that choose
    function showImagePreview(event) {
        const imagePreview = document.getElementById('questionImagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                document.getElementById('questionImageLabel').style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            imagePreview.style.display = 'none';
            document.getElementById('questionImageLabel').style.display = 'block';
        }
    }

    // clear question
    function clearQuestion() {
        // Clear the input fields
        document.getElementById('choice1').value = '';
        document.getElementById('choice2').value = '';
        document.getElementById('choice3').value = '';
        document.getElementById('choice4').value = '';
        //document.getElementById('timer').value = '';

        // Clear the input field for essay
        document.getElementById('essayAnswer').value = '';

        // Reset the radio buttons for true/false
        document.getElementById('trueFalseAnswerTrue').checked = false;
        document.getElementById('trueFalseAnswerFalse').checked = false;

        // Reset the border color of input fields (if they were highlighted)
        document.getElementById('choice1').style.borderColor = '';
        document.getElementById('choice2').style.borderColor = '';
        document.getElementById('choice3').style.borderColor = '';
        document.getElementById('choice4').style.borderColor = '';
        document.getElementById('timer').style.borderColor = '';

        // Clear the image input
        var imageInput = document.getElementById('questionImage');
        imageInput.value = ''; 
        document.getElementById('questionImagePreview').src = '';
        document.getElementById('questionImagePreview').style.display = 'none';
        document.getElementById('questionImageLabel').style.display = 'block';

        document.getElementById('imageInputBox').style.borderColor = '';

        // Clear the correct answer indicator and border
        document.querySelectorAll('.correct-indicator').forEach(ind => {
            ind.classList.remove('checked');
        });
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('correct-answer');
        });

        // Clear the correctAnswer variable
        correctAnswer = '';
    }

    let correctAnswer = '';

    // toggle answer
    function toggleCorrect(indicator, choiceId) {
        // Clear any previously selected correct indicators
        document.querySelectorAll('.correct-indicator').forEach(ind => {
            ind.classList.remove('checked');
        });

        // Set the current indicator as checked
        indicator.classList.add('checked');

        // Set the correct answer
        correctAnswer = document.getElementById(choiceId).value;

        // Highlight the correct input
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('correct-answer');
        });
        document.getElementById(choiceId).classList.add('correct-answer');
    }

    // toggle 
    function toggleQuestionType(type) {
        // Hide all question type inputs
        document.getElementById('multipleChoiceInputs').style.display = 'none';
        document.getElementById('essayInput').style.display = 'none';
        document.getElementById('trueFalseInput').style.display = 'none';

        // Show the selected question type input
        if (type === 'multipleChoice') {
            document.getElementById('multipleChoiceInputs').style.display = 'block';
        } else if (type === 'essay') {
            document.getElementById('essayInput').style.display = 'block';
        } else if (type === 'trueFalse') {
            document.getElementById('trueFalseInput').style.display = 'block';
        }
    }

    //  for add question in database
    function createQuestion() {
        const choice1 = document.getElementById('choice1').value.trim();
        const choice2 = document.getElementById('choice2').value.trim();
        const choice3 = document.getElementById('choice3').value.trim();
        const choice4 = document.getElementById('choice4').value.trim();
        const timer = document.getElementById('timer').value.trim();
        var imageInput = document.getElementById('questionImage');
        const selectedCategoryId = document.getElementById('selectedCategoryId').value;

        // Clear previous error indications
        document.getElementById('timer').style.borderColor = '';
        document.getElementById('imageInputBox').style.borderColor = '';
        document.getElementById('choice1').style.borderColor = '';
        document.getElementById('choice2').style.borderColor = '';
        document.getElementById('choice3').style.borderColor = '';
        document.getElementById('choice4').style.borderColor = '';
        document.getElementById('essayAnswer').style.borderColor = '';

        const questionType = document.querySelector('input[name="questionType"]:checked').value;
        let errorMessages = [];

        // Validate timer
        if (timer === '') {
            document.getElementById('timer').style.borderColor = 'red';
            errorMessages.push('Please enter the timer duration.');
        }

        // Validate image input
        if (imageInput.files.length === 0) {
            document.getElementById('imageInputBox').style.borderColor = 'red';
            errorMessages.push('Please upload an image.');
        }

        // Validate question type specific fields
        if (questionType === 'multipleChoice') {
            if (choice1 === '') document.getElementById('choice1').style.borderColor = 'red';
            if (choice2 === '') document.getElementById('choice2').style.borderColor = 'red';
            if (choice3 === '') document.getElementById('choice3').style.borderColor = 'red';
            if (choice4 === '') document.getElementById('choice4').style.borderColor = 'red';
            
            if (choice1 === '' || choice2 === '' || choice3 === '' || choice4 === '') {
                errorMessages.push('Please fill out all multiple choice fields.');
            }

            const correctAnswerIndicator = document.querySelector('.correct-indicator.checked');
            if (!correctAnswerIndicator) {
                errorMessages.push('Please indicate the correct answer.');
            }
        } else if (questionType === 'essay') {
            const essayAnswer = document.getElementById('essayAnswer').value.trim();
            if (essayAnswer === '') {
                document.getElementById('essayAnswer').style.borderColor = 'red';
                errorMessages.push('Please provide an answer for the essay question.');
            }
        } else if (questionType === 'trueFalse') {
            const trueFalseAnswer = document.querySelector('input[name="trueFalseAnswer"]:checked');
            if (!trueFalseAnswer) {
                errorMessages.push('Please select an answer for the true/false question.');
            }
        }

        // If there are any errors, display them in the error modal
        if (errorMessages.length > 0) {
            document.getElementById('errorMessage').innerHTML = errorMessages.join('<br>');
            $('#errorModal').modal('show');
            return; // Stop further execution of the function
        }

        let formData = new FormData();
        formData.append('selectedCategoryId', selectedCategoryId);
        formData.append('questionType', questionType);
        formData.append('timer', timer);
        formData.append('correctAnswer', correctAnswer);
        formData.append('action', 'add_question');

        if (imageInput.files.length > 0) {
            formData.append('file', imageInput.files[0]);
        }

        if (questionType === 'multipleChoice') {
            formData.append('choice1', choice1);
            formData.append('choice2', choice2);
            formData.append('choice3', choice3);
            formData.append('choice4', choice4);
        } else if (questionType === 'essay') {
            formData.append('essayAnswer', document.getElementById('essayAnswer').value.trim());
        } else if (questionType === 'trueFalse') {
            formData.append('trueFalseAnswer', document.querySelector('input[name="trueFalseAnswer"]:checked').value);
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php?url=create_question', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.success) {
                    const selectedCategoryId = document.getElementById('selectedCategoryId').value;
                    showQuestionList(selectedCategoryId);
                    clearQuestion();
                    console.log('Question added successfully!');
                } else {
                    console.error('Error adding question:', response.error);
                }
            } else {
                console.error('Error adding question:', xhr.statusText);
            }
        };

        xhr.send(formData);
    }

    /*
    function createQuestion() {

        const choice1 = document.getElementById('choice1').value.trim();
        const choice2 = document.getElementById('choice2').value.trim();
        const choice3 = document.getElementById('choice3').value.trim();
        const choice4 = document.getElementById('choice4').value.trim();
        const timer = document.getElementById('timer').value.trim();
        var imageInput = document.getElementById('questionImage');

        const selectedCategoryId = document.getElementById('selectedCategoryId').value;

        if (timer === '') {
            document.getElementById('timer').style.borderColor = 'red'; 
        } else {
            document.getElementById('timer').style.borderColor = ''; 
        }

        if (imageInput.files.length === 0) {
            document.getElementById('imageInputBox').style.borderColor = 'red';
        } else {
            document.getElementById('imageInputBox').style.borderColor = '';
        }

        const questionType = document.querySelector('input[name="questionType"]:checked').value;
        if (questionType === 'multipleChoice') {

            if (choice1 === '') {
                document.getElementById('choice1').style.borderColor = 'red'; 
            } else {
                document.getElementById('choice1').style.borderColor = ''; 
            }
            if (choice2 === '') {
                document.getElementById('choice2').style.borderColor = 'red'; 
            } else {
                document.getElementById('choice2').style.borderColor = ''; 
            }
            if (choice3 === '') {
                document.getElementById('choice3').style.borderColor = 'red';
            } else {
                document.getElementById('choice3').style.borderColor = ''; 
            }
            if (choice4 === '') {
                document.getElementById('choice4').style.borderColor = 'red'; 
            } else {
                document.getElementById('choice4').style.borderColor = ''; 
            }

            // Check for empty fields for multiple choice questions
            if (choice1 === '' || choice2 === '' || choice3 === '' || choice4 === '' || timer === '') {
                alert('Please fill out all fields.'); // display an alert message
                return;
            }

        } else if (questionType === 'essay') {
            
            const essayAnswer = document.getElementById('essayAnswer').value.trim();
            if (essayAnswer === '') {
                document.getElementById('essayAnswer').style.borderColor = 'red'; 
            } else {
                document.getElementById('essayAnswer').style.borderColor = ''; 
            }

            if (essayAnswer === '') {
                alert('Please fill out all fields.'); 
                return;
            }

        } else if (questionType === 'trueFalse') {

            const trueFalseAnswer = document.querySelector('input[name="trueFalseAnswer"]:checked');
            if (!trueFalseAnswer) {
                alert('Please fill out all fields.'); 
                return;
            }
        }

        if (essayAnswer === '' || imageInput.files.length === 0 ) {
                alert('Please fill out all fields.'); 
                return;
        }

        let formData = new FormData();
        formData.append('selectedCategoryId', selectedCategoryId);
        formData.append('questionType', questionType);
        formData.append('timer', timer);
        formData.append('correctAnswer', correctAnswer);
        formData.append('action', 'add_question');


        if (imageInput.files.length > 0) {
            formData.append('file', imageInput.files[0]);
        }

        if (questionType === 'multipleChoice') {
            formData.append('choice1', document.getElementById('choice1').value.trim());
            formData.append('choice2', document.getElementById('choice2').value.trim());
            formData.append('choice3', document.getElementById('choice3').value.trim());
            formData.append('choice4', document.getElementById('choice4').value.trim());
        } else if (questionType === 'essay') {
            formData.append('essayAnswer', document.getElementById('essayAnswer').value.trim());
        } else if (questionType === 'trueFalse') {
            formData.append('trueFalseAnswer', document.querySelector('input[name="trueFalseAnswer"]:checked').value);
        }

        const correctAnswerIndicator = document.querySelector('.correct-indicator.checked');
        if (!correctAnswerIndicator) {
            // If no correct answer is indicated, alert the user
            alert('Please indicate the correct answer.');
            return; // Stop further execution of the function
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php?url=create_question', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.success) {

                    const selectedCategoryId = document.getElementById('selectedCategoryId').value;
                    showQuestionList(selectedCategoryId); 

                    clearQuestion();
                    console.log('Question added successfully!');

                } else {
                    console.error('Error adding question: 1', response.error);
                }
            } else {
                console.error('Error adding question: 2', xhr.statusText);
            }
        };

        xhr.send(formData);
    }
        */

    let selectedCategory = null;

    // select the category
    function selectCategory(button) {

        if (selectedCategory) {
            selectedCategory.style.border = '';
        }

        const categoryItem = button.parentElement;
        categoryItem.style.border = '3px solid #00c04b';

        selectedCategory = categoryItem;

        const categoryId = categoryItem.getAttribute('data-category-id');

        const selectedCategoryIdInput = document.getElementById('selectedCategoryId');
        selectedCategoryIdInput.value = categoryItem.getAttribute('data-category-id');

        const questionFormBox = document.getElementById('questionFormBox');
        questionFormBox.style.display = 'block';

        // Show question list container
        const questionListContainer = document.getElementById('questionListContainer');
        questionListContainer.style.display = 'block';

        // Show submit and cancel buttons
        document.getElementById('submitButton').style.display = 'inline-block';
        document.getElementById('cancelButton').style.display = 'inline-block';
        
        showQuestionList(categoryId);
    }

    // show question list
    function showQuestionList(categoryId) {

        //console.log('update questions');

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `index.php?url=create_question&action=view_all_question&category_id=${categoryId}`, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const questionList = document.getElementById('questionList');
                questionList.innerHTML = ''; 

                try {
                    const responseData = xhr.responseText;

                    if (responseData === 'false') {
                        const noQuestionsMessage = document.createElement('p');
                        //noQuestionsMessage.textContent = 'No questions available for the selected category.';
                        questionList.appendChild(noQuestionsMessage);
                        console.log('No questions available for the selected category.');
                        return;
                    }

                    const questions = JSON.parse(responseData);

                    if (Array.isArray(questions)) {
                        questions.forEach(function(question) {
                            const questionItem = document.createElement('div');
                            questionItem.className = 'question-item box p-3 mb-3 bg-white rounded';
                            questionItem.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                            questionItem.innerHTML = `
                                <img src="${question.question_image}" alt="Question Image" style="max-width: 100%; height: auto;">
                                <p><strong>Answer:</strong> ${question.correct_answer}</p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary mr-2" style="background-color: #198754; border-color: #198754;">View</button>
                                    <button class="btn btn-danger">-</button>
                                </div>
                            `;
                            questionList.appendChild(questionItem);
                        });
                        
                        // animation
                        const questionItems = document.querySelectorAll('.question-item');
                        questionItems.forEach(item => {
                            item.classList.add('question-animation');
                        });

                        //console.log('Question list updated successfully!');
                    } else {
                        console.error('Invalid JSON data:', questions);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            } else {
                console.error('Error updating question list:', xhr.statusText);
            }
        };

        xhr.send();
    }

   

    function proceed() {

        document.getElementById('loading').style.display = 'flex';

        const formData = new FormData();
        formData.append('action', 'update_quiz_event'); 

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php?url=create_question', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {

                        setTimeout(function() { 
                            window.location.href = "<?php echo ROOT . 'get_code'; ?>";
                        }, 1000);
                    } else {
                        console.error('Error updating quiz event status:', response.error);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            } else {
                console.error('Error updating quiz event status:', xhr.statusText);
            }
        };

        // Handle errors during the request
        xhr.onerror = function() {
            console.error('Error: Request failed');
        };

        xhr.send(formData);
    }

     // clear question
     /*
     function clearQuestionVersionOne() {
        // Clear the input fields
        document.getElementById('choice1').value = '';
        document.getElementById('choice2').value = '';
        document.getElementById('choice3').value = '';
        document.getElementById('choice4').value = '';
        document.getElementById('timer').value = '';

        // Clear the input field for essay
        document.getElementById('essayAnswer').value = '';

        // Reset the radio buttons for true/false
        document.getElementById('trueFalseAnswerTrue').checked = false;
        document.getElementById('trueFalseAnswerFalse').checked = false;

        // Reset the border color of input fields (if they were highlighted)
        document.getElementById('choice1').style.borderColor = '';
        document.getElementById('choice2').style.borderColor = '';
        document.getElementById('choice3').style.borderColor = '';
        document.getElementById('choice4').style.borderColor = '';
        document.getElementById('timer').style.borderColor = '';

        // Clear the image input
        var imageInput = document.getElementById('questionImage');
        imageInput.value = ''; 
        document.getElementById('questionImagePreview').src = '';
        document.getElementById('questionImagePreview').style.display = 'none';
        document.getElementById('questionImageLabel').style.display = 'block';

        document.getElementById('imageInputBox').style.borderColor = '';

        // Clear the correct answer indicator and border
        document.querySelectorAll('.correct-indicator').forEach(ind => {
            ind.classList.remove('checked');
        });
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('correct-answer');
        });

        // Clear the correctAnswer variable
        correctAnswer = '';
    }
    */
    
</script>

     <!-- Important -->
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>

</html>


