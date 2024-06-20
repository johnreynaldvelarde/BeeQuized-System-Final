<footer>
    <!-- Footer content can be added here -->
</footer>
</body>
    <!-- Important -->
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/socket/socket.io.js"></script>

<script>

    let socket = io('http://localhost:3000', {transports: ['websocket', 'polling', 'flashsocket'] });

    function updateMemberFields(memberCount) {
        const memberFieldsContainer = document.getElementById('memberFields');
        memberFieldsContainer.innerHTML = ''; 

        for (let i = 1; i <= memberCount; i++) {
            const inputGroup = document.createElement('div');
            inputGroup.className = 'mb-3';

            const label = document.createElement('label');
            label.className = 'form-label';
            label.innerText = `Member ${i} Name`;

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.placeholder = `Enter name of member ${i}`;
            input.addEventListener('blur', validateInput);

            inputGroup.appendChild(label);
            inputGroup.appendChild(input);
            memberFieldsContainer.appendChild(inputGroup);
        }
    }

    function validateInput(event) {
        const input = event.target;
        if (input.value.trim() === '') {
            input.classList.add('border-danger');
        } else {
            input.classList.remove('border-danger');
        }
    }

    function clearFields() {
        document.getElementById('teamForm').reset();
        document.getElementById('memberFields').innerHTML = '';
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('border-danger');
        });
    }


    function saveTeam() {

        const teamName = document.getElementById('teamName').value.trim();
        const memberInputs = document.querySelectorAll('#memberFields .form-control');
        const members = Array.from(memberInputs).map(input => input.value.trim());

        let valid = true;

        if (teamName === '') {
            document.getElementById('teamName').classList.add('border-danger');
            valid = false;
        } else {
            document.getElementById('teamName').classList.remove('border-danger');
        }

        members.forEach((member, index) => {
            const input = memberInputs[index];
            if (member === '') {
                input.classList.add('border-danger');
                valid = false;
            } else {
                input.classList.remove('border-danger');
            }
        });

        if (!valid) {
            showErrorModal('Please fill out all fields');
            //alert('Please fill out all fields.');
            return;
        }

       

        const formData = new FormData();
        formData.append('action', 'set_team');
        formData.append('teamName', teamName);
        members.forEach((member, index) => {
            formData.append(`members[${index}]`, member);
        });

        const xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    //alert('Team saved successfully!');
                    //window.location.reload();
                    //socket.emit('updateTeamScore', member);

                    document.getElementById('loading').style.display = 'flex';
                    
                    setTimeout(function() { 
                            window.location.href = "<?php echo ROOT . 'realtime_participants'; ?>";
                    }, 1000);

                } else {
                    //alert('Error: ' + response.error);
                    showErrorModal(response.error); // Show error modal
                }
            } else {
                //alert('Error saving team.');
                showErrorModal('Error saving team.');
            }
        };

        xhr.onerror = function() {
            document.getElementById('loading').style.display = 'none';
            //alert('Request failed.');
            showErrorModal('Request failed.');
        };

        xhr.send(formData);
    }

    function showErrorModal(errorMessage) {
        document.getElementById('errorMessage').innerText = errorMessage;
        $('#errorModal').modal('show');
    }

</script>
</html>