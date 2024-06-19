<?php $this->view("base/header_realtime_quizmaster", $data); ?>

<div class="container-fluid d-flex flex-column" style="height: 100vh;">
    <div class="row flex-fill">

        <!-- First Upper Row - List of Participants -->
        <div class="col-12">
            <div class="box shadow p-3 mb-3 mt-2 bg-white rounded reduced-shadow">
                <h3 class="mb-4 text-center">Team Participants</h3>
                <div class="d-flex flex-wrap justify-content-center">
                    <!-- Example participants, dynamically populate these -->
                    <div class="list-group-item d-flex align-items-center me-3 mb-3">
                        <div class="flex-fill d-flex justify-content-between align-items-center">
                            <span class="me-2">Team 1</span>
                            <span class="badge bg-primary rounded-pill">Score: 100</span>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center me-3 mb-3">
                        <div class="flex-fill d-flex justify-content-between align-items-center">
                            <span class="me-2">Team 2</span>
                            <span class="badge bg-primary rounded-pill">Score: 90</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Single Column for Content -->
        <div class="col-12 bg-grey p-4">
            <!-- Content Section -->
            <div class="box shadow p-3 mb-3 bg-white rounded reduced-shadow">
                <h4>Main Content Area</h4>
                <!-- Add your content here -->

                <!-- Category List -->
                <div class="box shadow p-3 mb-3 bg-white rounded reduced-shadow">
                    <h4>Category List</h4>
                    <div class="list-group" id="category-list">
                        <!-- Sample category items (replace with actual categories) -->
                        <a href="#" class="list-group-item list-group-item-action" data-category="Category 1">Category 1</a>
                        <a href="#" class="list-group-item list-group-item-action" data-category="Category 2">Category 2</a>
                        <a href="#" class="list-group-item list-group-item-action" data-category="Category 3">Category 3</a>
                    </div>
                </div>

                <!-- Container for displaying questions -->
                <div class="box shadow p-3 mb-3 bg-white rounded reduced-shadow" id="question-container">
                    <h4>Questions</h4>
                    <!-- Sample Questions -->
                    <div class="card mb-3">
                        <img src="<?= ASSETS ?>quizbee/images/nature_background.jpg" class="card-img-top img-fluid p-4" style="max-height: 400px;" alt="Question 1 Image">
                        <div class="card-body">
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="0">Choice 1</button>
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="1">Choice 2</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="2">Choice 3</button>
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="3">Choice 4</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary btn-sm me-2">View</button>
                                <button class="btn btn-success btn-sm me-2">Start</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <img src="<?= ASSETS ?>quizbee/images/nature_background.jpg" class="card-img-top img-fluid p-4" style="max-height: 400px;" alt="Question 1 Image">
                        <div class="card-body">
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="0">Choice 1</button>
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="1">Choice 2</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="2">Choice 3</button>
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="3">Choice 4</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary btn-sm me-2">View</button>
                                <button class="btn btn-success btn-sm me-2">Start</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <img src="<?= ASSETS ?>quizbee/images/nature_background.jpg" class="card-img-top img-fluid p-4" style="max-height: 400px;" alt="Question 1 Image">
                        <div class="card-body">
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="0">Choice 1</button>
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="1">Choice 2</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="2">Choice 3</button>
                                        <button type="button" class="list-group-item list-group-item-action answer-btn" data-question-id="1" data-choice-index="3">Choice 4</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary btn-sm me-2">View</button>
                                <button class="btn btn-success btn-sm me-2">Start</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view("base/footer_realtime_quizmaster", $data); ?>
