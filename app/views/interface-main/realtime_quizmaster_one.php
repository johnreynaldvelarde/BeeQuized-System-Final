<?php $this->view("base/header_realtime_quizmaster", $data); ?>

<div class="container-fluid d-flex flex-column" style="height: 100vh;">
    <div class="row flex-fill">

        <!-- First Upper Row - List of Participants -->
        <div class="col-12">
            <div class="box shadow p-3 mb-3 mt-2 bg-white rounded reduced-shadow">
                <h3 class="mb-4 text-center">Team Participants</h3>
                <div class="d-flex flex-wrap justify-content-center" id="team-list">
                    <!-- Teams will be dynamically added here -->
                </div>
            </div>
        </div>

        <!-- Categories Column -->
        <div class="col-md-3 bg-grey p-4" style="height: 100vh; overflow-y: auto; dis">
            <!-- Show Category List -->
            <div id="categoryList" class="mt-1"></div>
        </div>

        <!-- Questions Column -->
        <div class="col-md-9 p-4 mt-1" style="height: 100vh; overflow-y: auto;">
            <h4 class="mb-3" style="color: white;">Questions</h4>
            <div id="question-container">
                <!-- Questions will be dynamically added here -->
            </div>

            <!-- Button Row -->
            <div class="row mt-3 justify-content-end">
                <div class="col-md-auto">
                    <button class="btn btn-outline-light-custom btn-block btn-show-leaderboard">Show Leaderboard</button>
                </div>
                <div class="col-md-auto">
                    <button id="finishEventBtn" class="btn btn-outline-light-custom btn-block">Finish the Event</button>
                </div>
            </div>

        </div>
    </div>
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

<!-- Countdown Modal -->
<div class="modal fade" id="countdownModal" tabindex="-1" role="dialog" aria-labelledby="countdownModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="countdownModalLabel">Countdown</h5>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center">
                <div class="flex-grow-1 text-center">
                     <!-- Loading animation or other elements to the left -->
                     <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <!-- Countdown message centered -->
                    <p id="countdownMessage">Countdown message will be inserted here</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaderboard Modal -->
<div class="modal fade" id="leaderboardModal" tabindex="-1" role="dialog" aria-labelledby="leaderboardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaderboardModalLabel">Leaderboards</h5>
                
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-success me-2" id="exportPdfBtn">Export as PDF</button>
                    <button class="btn btn-primary " id="exportExcelBtn">Export as Excel</button>
                </div>
                <table id="leaderboardTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Team Name</th>
                            <th scope="col">Total Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample leaderboard rows -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="overlay"></div>

<?php $this->view("base/footer_realtime_quizmaster", $data); ?>
