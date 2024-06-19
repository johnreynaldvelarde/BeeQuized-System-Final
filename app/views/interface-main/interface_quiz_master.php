<?php $this->view("base/header_quiz_master", $data); ?>

    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="container">
            <h1 class="text-center" style="color: white;">Quizmaster Details</h1>
            <div class="row mt-4 justify-content-center">
                <div class="col-md-6">
                    <form id="quizmasterForm" class="p-4 bg-white shadow rounded">
                        <div class="mb-3">
                            <label for="quizmasterName" class="form-label mb-3">Quizmaster Name</label>
                            <input type="text" class="form-control" id="quizmasterName" placeholder="Enter quizmaster name" onblur="validateInput(event)">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="clearFields()">Clear</button>
                            <button type="button" class="btn btn-primary" onclick="saveQuizmaster()">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Animation -->
    <div id="loading" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(255, 255, 255, 0.8); z-index:9999; flex-direction: column; justify-content:center; align-items:center;">
        <div class="spinner-center"></div>
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

<?php $this->view("base/footer_quiz_master", $data); ?>
