<?php $this->view("base/header_realtime_participants", $data); ?>

<div class="container-fluid d-flex flex-column" style="height: 100vh;">
     
   <!-- First Upper Row -->
    <div class="row d-flex justify-content-center align-items-center" style="flex: 4;">
        <div class="col-12 h-100 d-flex justify-content-center align-items-center">
            <!-- Flex container for loading animation and text -->
            <div class="d-flex align-items-center mt-5">
                <!-- Loading animation -->
                <div id="loadingAnimation" class="spinner-border text-light me-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                
                <!-- Text with white color -->
                <div id="waitingText">
                    <h2 style="color: white; margin: 0;">Waiting for next questions...</h2>
                </div>

                <!-- Countdown message (hidden initially) -->
                <div id="countdownMessage" class="text-center" style="display: none;">
                    <h2 style="color: white; font-size: 100px;"></h2>
                </div>

                <!-- Question Image (if applicable)-->
                <div id="imageQuestion" style="border: 2px solid white; padding: 20px; border-radius: 8px; overflow: hidden;">
                    <img src="<?= ASSETS ?>quizbee/images/T1.JPG" alt="Question Image" class="responsive-image">
                </div> 
            </div>

            <!-- Timer -->
            <div id="upperTimer" style="color: white; position: absolute; top: 40px; right: 40px; font-size: 25px;">
                    60 seconds
            </div>
        </div>
    </div>

    <!-- Below Row -->
    <div class="row" style="flex: 2;">
        <div class="col-12 h-100">
            <div id="questionContainer" class="mt-5 ms-5 me-5 text-center">
                 <!-- Choices -->
                 <div class="choices row">
                    <!-- Choices will be populated here dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="resultMessage"></p>
                <p id="resultScore"></p>
                <p id="correctAnswerMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php $this->view("base/footer_realtime_participants", $data); ?>
