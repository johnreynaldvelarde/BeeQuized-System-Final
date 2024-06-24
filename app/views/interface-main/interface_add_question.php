<?php $this->view("base/header_create_question", $data); ?>

<div class="container-fluid d-flex flex-column" style="height: 100vh;">
    <div class="row flex-fill">

       <!-- First Column -->
       <div class="col-md-2 bg-grey p-4" style="height: 100vh; overflow-y: auto;">

            <!-- Show Category List -->
            <div id="categoryList" class="mt-1">
                <?php $data['category'] = $data['category'] ?? []; ?>
                <?php if (is_array($data['category'])): ?>
                    <?php foreach ($data['category'] as $row): ?>
                        <div class="category-item box p-3 mb-2 bg-white rounded" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);" data-category-id="<?= htmlspecialchars($row->id)?>">
                            <p><strong>Name:</strong> <?= htmlspecialchars($row->category_name) ?></p>
                            <p><strong>Base Points:</strong> <?= htmlspecialchars($row->base_points) ?></p>
                            <button class="btn btn-primary mr-2" onclick="selectCategory(this)">Select</button>
                            <button class="btn btn-danger" onclick="deleteCategory(this)">-</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

         
            <div id="formBox" class="box shadow p-3 mb-5 bg-white rounded reduced-shadow text-center">
             <!-- Category Name input -->
                <div class="form-group" style="margin-bottom: 15px;">
                        <input name="categoryName" type="text" class="form-control" id="categoryNameInput" placeholder="Enter category name">
                        <div id="categoryNameError" class="text-danger"></div> <!-- Error message -->
                    </div>
                    <!-- Base Points input -->
                    <div class="form-group" style="margin-bottom: 15px;">
                        <input name="basePoints" type="number" class="form-control" id="basePointsInput" placeholder="Enter base points">
                        <div id="basePointsError" class="text-danger"></div> <!-- Error message -->
                    </div>
                    <!--<button type="submit" class="btn btn-primary" ">Add Category</button>-->
                <button class="btn btn-primary" onclick="addCategory()">Add Category</button>
            </div>

        </div>

        <!-- Center Column -->
        <div class="col-md-8 p-4">

            <div class="box shadow p-3 mb-3 bg-white rounded reduced-shadow">
                <div class="d-flex justify-content-between align-items-center">
                    <h3><?=$_SESSION['event_title']?></h3>
                    <!-- Codes on the right side -->
                    <div>
                        <h3 class="ques_code">QuizMaster Code: <span class="code"><?=$_SESSION['quizmaster_code']?></span></h3>
                        <h3 class="ques_code">Participant Code: <span class="code"><?=$_SESSION['participant_code']?></span></h3>
                        <h3 class="ques_code">Audience Code: <span class="code"><?=$_SESSION['audience_code']?></span></h3>
                    </div>
                    <button class="btn btn-outline-secondary">Copy</button>
                </div>
            </div>

            <div id="questionFormBox" class="box shadow p-3 mb-3 bg-white rounded reduced-shadow" style="display: none;">

                    <!-- Hidden input for category_id -->
                    <input type="hidden" id="selectedCategoryId" name="selectedCategoryId" value="">

                    <h3>Create Question</h3>

                    <!-- Question Type Toggle -->
                    <div class="form-group mb-3">
                        <label for="questionType" class="mb-3 mt-3" style="font-weight: 600; color: #007bff;">Question Type:</label>
                        <div class="mb-4">
                            <label class="me-5" >
                                <input type="radio" name="questionType" value="multipleChoice" checked onclick="toggleQuestionType('multipleChoice')"> Multiple Choice
                            </label>
                            <label class="me-5" style="display: none;">
                                <input type="radio" name="questionType" value="essay" onclick="toggleQuestionType('essay')"> Essay
                            </label>
                            <label class="me-5" style="display: none;" >
                                <input type="radio" name="questionType" value="trueFalse" onclick="toggleQuestionType('trueFalse')"> True/False
                            </label>
                        </div>
                    </div>

                    <!-- Timer input -->
                    <div class="form-group mt-3">
                        <label for="timer">Timer Duration (seconds):</label>
                        <input type="number" class="form-control mb-2" id="timer" name="timer" min="1">
                    </div>

                    <!-- Image input for the question -->
                    <div class="form-group question-image-input">
                        <label for="questionImage">Question Image:</label>
                        <div class="box p-3 mb-3 bg-white rounded reduced-shadow" id="imageInputBox">
                            <input type="file" class="form-control-file" id="questionImage" name="questionImage" onchange="showImagePreview(event)">
                            <label id="questionImageLabel" for="questionImage">Choose Image</label>
                            <img id="questionImagePreview" src="#" alt="Question Image" style="display: none;">
                        </div>
                    </div>

                    <!-- Multiple Choice Input -->
                    <div id="multipleChoiceInputs" class="form-group mb-3">
                        <label for="choices">Choices:</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="choice1" name="choice1">
                            <span class="correct-indicator" onclick="toggleCorrect(this, 'choice1')"></span>
                        </div>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="choice2" name="choice2">
                            <span class="correct-indicator" onclick="toggleCorrect(this, 'choice2')"></span>
                        </div>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="choice3" name="choice3">
                            <span class="correct-indicator" onclick="toggleCorrect(this, 'choice3')"></span>
                        </div>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="choice4" name="choice4">
                            <span class="correct-indicator" onclick="toggleCorrect(this, 'choice4')"></span>
                        </div>
                    </div>

                    <!-- Essay Input -->
                    <div id="essayInput" class="form-group mb-3" style="display: none;">
                        <label for="essayAnswer">Answer:</label>
                        <textarea class="form-control" id="essayAnswer" name="essayAnswer" rows="4"></textarea>
                    </div>

                     <!-- True/False Input -->
                     <div id="trueFalseInput" class="form-group mb-3" style="display: none;">
                        <label>Answer:</label>
                        <div>
                            <label>
                                <input type="radio" id="trueFalseAnswerTrue" name="trueFalseAnswer" value="true" > True
                            </label>
                            <label>
                                <input type="radio" id="trueFalseAnswerFalse" name="trueFalseAnswer" value="false"> False
                            </label>
                        </div>
                    </div>
                    
                    <!-- Create button -->
                    <button class="btn btn-success" onclick="createQuestion()">Create a question</button>
                    <!-- Clear button -->
                    <button class="btn btn-outline-secondary" onclick="clearQuestion()">Clear</button>
            </div>
                <!-- Submit and Cancel buttons -->
                <div class="d-flex justify-content-end">
                    <button id="cancelButton" class="btn btn-secondary btn-floating me-2" style="display: none;" onclick="cancelCreation()">Cancel</button>
                    <button id="submitButton" class="btn btn-primary btn-floating" style="display: none;" onclick="proceed()">Proceed</button>
                </div>
        </div>
        
        <!-- Third Column -->
        <div class="col-md-2 bg-grey p-4" style="height: 100vh; overflow-y: auto;">
            <!-- Show Question List -->
            <div id="questionListContainer" class="mt-4" style="display: none;">
                <div id="questionList">
                    <?php if (is_array($data['questions'])): ?>
                        <?php foreach ($data['questions'] as $row): ?>
                            <div class="question-item box p-3 mb-3 bg-white rounded" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <img src="<?= ROOT . $row->question_image ?>" alt="Question Image" style="max-width: 100%; height: auto;">
                                <p><strong>Answer:</strong> <?= htmlspecialchars($row->correct_answer) ?></p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary mr-2" style="background-color: #198754; border-color: #198754;" onclick="selectQuestion(this)">View</button>
                                    <button class="btn btn-danger">-</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Animation -->
<div id="loading" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(255, 255, 255, 0.8); z-index:9999; flex-direction: column; justify-content:center; align-items:center;">
    <div class="spinner-question"></div>
    <p style="margin-top: 10px;">Loading, please wait...</p>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background: linear-gradient(to right, #ef4136, #fbb040);">
        <img src="<?=ASSETS?>quizbee/images/warning_icon.png" class="error-icon" alt="Error Icon" style="width: 30px; height: 30px;">
        <h5 class="ms-2 modal-title" id="errorModalLabel">Warning</h5>
      </div>
      <div class="modal-body" id="errorMessage">
        <!-- Error message will be inserted here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php $this->view("base/footer_create_question", $data); ?>
