// Login Form PopUp
function openLogin() {
  document.getElementById("login-popup").style.display = "block";
  document.getElementById("overlay").style.display = "block";
  document.getElementById("btn").style.left = "0px";
  document.getElementById("login-form").style.display = "block";

  // toggle button
  document
    .querySelector('.toggle-btn[data-form="login-form"]')
    .classList.add("active");
}

function closeLogin() {
  document.getElementById("login-popup").style.display = "none";
  document.getElementById("overlay").style.display = "none";
  document.getElementById("login-form").style.display = "none";
  document.getElementById("registration-form").style.display = "none";

  // toggle button
  document
    .querySelector('.toggle-btn[data-form="registration-form"]')
    .classList.remove("active");
}

function submitRegistrationForm() {
  var errorParam = new URLSearchParams(window.location.search).get("error");

  // Check if there's an error message
  if (errorParam) {
    // Display the error message and prevent form submission
    var errorElement = document.querySelector(".input-register .error");
    if (errorElement) {
      errorElement.innerHTML = errorParam;
    }
  } else {
    // If no error message, submit the form
    document.getElementById("registration-form").submit();
  }
}

function toggleForm(formId) {
  var loginForm = document.getElementById("login-form");
  var registrationForm = document.getElementById("registration-form");
  var z = document.getElementById("btn");
  var loginButton = document.querySelector(
    '.toggle-btn[data-form="login-form"]'
  );
  var registrationButton = document.querySelector(
    '.toggle-btn[data-form="registration-form"]'
  );

  if (formId === "login-form") {
    loginForm.style.display = "block";
    registrationForm.style.display = "none";
    z.style.left = "0px";
    loginButton.classList.add("active");
    registrationButton.classList.remove("active");
  } else if (formId === "registration-form") {
    loginForm.style.display = "none";
    registrationForm.style.display = "block";
    z.style.left = "110px";
    loginButton.classList.remove("active");
    registrationButton.classList.add("active");
  }
}

function generateInputFields() {
  var numMembers = document.getElementById("numMembers").value;
  var memberFieldsContainer = document.getElementById("memberFields");
  memberFieldsContainer.innerHTML = ""; // Clear previous input fields

  for (var i = 0; i < numMembers; i++) {
    var inputField = document.createElement("input");
    inputField.type = "text";
    inputField.className = "form-control";
    inputField.name = "member" + (i + 1); // Naming convention for member inputs
    inputField.placeholder = "Enter member " + (i + 1) + "'s name";

    var divFormGroup = document.createElement("div");
    divFormGroup.className = "form-group";
    divFormGroup.appendChild(inputField);

    memberFieldsContainer.appendChild(divFormGroup);
  }
}
