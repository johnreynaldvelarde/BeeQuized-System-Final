<?php $this->view("base/header_waiting", $data); ?>

<div class="container-fluid d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
    
    <!-- Quizmaster List -->
    <!-- Quizmaster List -->
    <div class="row mt-5">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="quizmasterList mb-5 text-center">
                <h2>Quiz Master</h2>
                <p id="waitingMessage" style="font-size: 20px; color: #6c757d; display: none;">Waiting for quizmaster...</p>
                
                <!-- Bootstrap loading spinner -->
                <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: block;">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <div id="quizmaster-item" class="d-none flex-wrap justify-content-center mt-4">
                    <?php if (is_array($data['read'])): ?>
                        <?php foreach ($data['read'] as $row): ?>
                            <!-- Sample player item -->
                            <div class="player-item box me-2 mb-2 bg-white rounded d-flex align-items-center p-3" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <!-- Circle Image -->
                                <img src="<?= ASSETS ?>quizbee/images/nature_background.jpg" alt="Quiz Master" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 15px;">
                                <p style="font-size: 24px; color: #007bff; margin: 0;"><strong><?= htmlspecialchars($row->quizmaster_name) ?></strong></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Title of the Event and Waiting for Players Message -->
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <h1><?= $_SESSION['event_title'] ?></h1>
            <!--<p style="font-size: 20px; color: #6c757d;">Waiting for completion...</p>

              Bootstrap loading spinner 
             <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>-->
        </div>
    </div>

    <!-- Team List -->
    <div class="row mt-5" style="height: 30%; overflow-y: auto;">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="teamsList mb-5 text-center">
                <h2>Teams</h2>
                <p style="font-size: 20px; color: #6c757d;">Waiting for teams...</p>

                 <!-- Bootstrap loading spinner -->
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <div id="teams-item" class="d-none flex-wrap justify-content-center mt-4">
                    <?php $data['read'] = $data['read'] ?? []; ?>
                    <?php if (is_array($data['read'])): ?>
                        <?php foreach ($data['read'] as $row): ?>
                            <div class="player-item box me-2 mb-2 bg-white rounded d-flex align-items-center p-3" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);" data-team-id="<?= htmlspecialchars($row->id)?>">
                                <!-- Circle Image -->
                                <img src="<?=ASSETS?>quizbee/images/nature_background.jpg" alt="Teams" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 15px;">
                                <!-- Team Name and Button -->
                                <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                                    <p style="font-size: 24px; color: #007bff; margin: 0;"><strong><?= htmlspecialchars($row->team_name) ?></strong></p>
                                    <!-- Button triggers modal -->
                                    <button class="btn btn-success ms-3"
                                            data-team-id="<?= htmlspecialchars($row->id) ?>"
                                            data-bs-toggle="modal" data-bs-target="#teamMembersModal">
                                        Members
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for displaying team members -->
    <div class="modal fade" id="teamMembersModal" tabindex="-1" aria-labelledby="teamMembersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teamMembersModalLabel">Team Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="teamMembersList" class="list-group">
                        <!-- Team members will be dynamically inserted here -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php $this->view("base/footer_waiting", $data); ?>
