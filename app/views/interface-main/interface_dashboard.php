<?php $this->view("base/header_main", $data); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container mt-5 pt-5">
        <div class="row">
            <!-- Create quiz box -->
            <div class="col-md-3">
                <div class="box shadow p-3 mb-5 bg-white rounded">
                    <h2>BeeQuized</h2>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createQuizModal">Create</button>
                </div>
            </div>

          <!-- show quiz event created -->
            <div class="col-md-9">
                <div class="row quiz-container">
                    <?php if (is_array($data['quizbee_module'])): ?>
                        <?php foreach ($data['quizbee_module'] as $row): ?>
                            <div class="col-md-4 quiz-box">
                                <div class="box shadow p-3 mb-5 bg-white rounded">
                                    <h3><?= $row->event_title ?></h3>
                                    <p><span style="font-weight: 600; font-size: 15px; ">Quiz Master Code:</span> <span style="font-size: 15px; color: #6C757D;"><?= htmlspecialchars($row->quizmaster_code)?></span> </p>
                                    <p><span style="font-weight: 600; font-size: 15px;">Participant Code:</span> <span style="font-size: 15px; color: #6C757D;"><?= htmlspecialchars($row->participant_code)?></span>  </p>
                                    <p><span style="font-weight: 600; font-size: 15px;">Audience Code:</span> <span style="font-size: 15px; color: #6C757D;"><?= htmlspecialchars($row->audience_code)?></span></p>
                                    <p><span style="font-weight: 600; font-size: 15px;">Status:</span> 
                                        <?php
                                            if ($row->status == 0) {
                                                echo "On Hold";
                                            } elseif ($row->status == 1) {
                                                echo "Ongoing";
                                            } elseif ($row->status == 2) {
                                                echo "Ended";
                                            }
                                        ?>
                                    </p>
                                    <button class="btn btn-success">
                                        <?php
                                            if ($row->status == 0) {
                                                echo "Edit";
                                            } elseif ($row->status == 1) {
                                                echo "Join";
                                            } elseif ($row->status == 2) {
                                                echo "Visit";
                                            }
                                        ?>
                                    </button>
                                    <button class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
    </div>
</section>
<!-- End Hero Section -->

<!-- Create Quiz Modal -->
<div class="modal fade" id="createQuizModal" tabindex="-1" role="dialog" aria-labelledby="createQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createQuizModalLabel">Create Quiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createQuizForm" method="post">
                    <div class="form-group">
                        <label for="quizTitle">Quiz Bee Event Title</label>
                        <input name="quizTitle" type="text" class="form-control" id="quizTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="quizMasterCode">QuizMaster Code</label>
                        <input name="quizMasterCode" type="text" class="form-control" id="quizMasterCode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="participantCode">Participant Code</label>
                        <input name="participantCode" type="text" class="form-control" id="participantCode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="audienceCode">Audience Code</label>
                        <input name="audienceCode" type="text" class="form-control" id="audienceCode" readonly>
                    </div>

                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-primary float-left" onclick="generateCodes()">Generate Codes</button>
                        <button type="submit" class="btn btn-success float-right">Create Quiz</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Create Quiz Modal -->

<!-- Loading Animation -->
<div id="loading" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(255, 255, 255, 0.8); z-index:9999; flex-direction: column; justify-content:center; align-items:center;">
    <div class="spinner-dashboard"></div>
    <p style="margin-top: 10px;">Loading, please wait...</p>
</div>

<!-- Notification -->
<div id="notification" style="display:none; position:fixed; bottom:20px; right:20px; background-color:#28a745; color:#fff; padding:10px 20px; border-radius:5px;"></div>

<?php $this->view("base/footer_main", $data); ?>

