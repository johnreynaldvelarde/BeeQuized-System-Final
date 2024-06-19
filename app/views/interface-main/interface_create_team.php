<?php $this->view("base/header_create_team", $data); ?>

<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="container">
      <h1 class="text-center" style="color: white;">Create Team</h1>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-6">
                <form id="teamForm" class="p-4 bg-white shadow rounded">
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Team Name</label>
                        <input type="text" class="form-control" id="teamName" placeholder="Enter team name" onblur="validateInput(event)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Members</label>
                        <div class="btn-group" role="group" aria-label="Member count">
                            <button type="button" class="btn btn-outline-primary" onclick="updateMemberFields(1)">1</button>
                            <button type="button" class="btn btn-outline-primary" onclick="updateMemberFields(2)">2</button>
                            <button type="button" class="btn btn-outline-primary" onclick="updateMemberFields(3)">3</button>
                            <button type="button" class="btn btn-outline-primary" onclick="updateMemberFields(4)">4</button>
                        </div>
                    </div>
                    <div id="memberFields" class="mb-3">
                        <!-- Member inputs will be appended here -->
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="clearFields()">Clear</button>
                        <button type="button" class="btn btn-primary" onclick="saveTeam()">Save</button>
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
      <div class="modal-header bg-danger text-white">
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


<?php $this->view("base/footer_create_team", $data); ?>
