// Selecting form and input elements

function initializeViewer() {
  $(".viewer_image").viewer({backdrop: 'static'});
  $(".viewer_images").viewer({backdrop: 'static'});
}
function quickSearch(tableId) {
        var input, filter, cards, card, i, txtValue,content;
        input = document.getElementById("quickSearch");
        filter = input.value.toUpperCase();
        cards = document.getElementById(tableId).getElementsByClassName("cards");
        for (i = 0; i < cards.length; i++) {
            card = cards[i];
            content = card.querySelector(".text-secondary");
            if(content){
              txtValue = content.textContent || content.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
            }
            
        }
    }
const form = document.querySelector("form");
const passwordInput = document.getElementById("password");
const passToggleBtn = document.getElementById("pass-toggle-btn");
// Function to display error messages
const showError = (field, errorText) => {
  field.classList.add("error");
  const errorElement = document.createElement("small");
  errorElement.classList.add("error-text");
  errorElement.innerText = errorText;
  field.closest(".form-group").appendChild(errorElement);
};

document.addEventListener('DOMContentLoaded', function() {
    var notification = document.getElementById('notification');

       if (notification&&notification.innerHTML.trim() !== "") {
      notification.style.display = 'block';

      // Hide notification after 3 seconds
      setTimeout(function() {
        notification.style.display = 'none';
      }, 3000);
    }
  });
document.addEventListener('DOMContentLoaded', function() {
    var notification_scuccess = document.getElementById('notification_success');

    // Show notification if there is an error
      if (notification_scuccess&&notification_scuccess.innerHTML.trim() !== "") {
      notification_scuccess.style.display = 'block';

      // Hide notification after 3 seconds
      setTimeout(function() {
        notification_scuccess.style.display = 'none';
      }, 3000);
    }
  
  });
// Function to handle form submission
const handleFormData = (e) => {
  e.preventDefault();

  // Retrieving input elements

  const emailInput = document.getElementById("email");

  // Getting trimmed values from input fields

  const email = emailInput.value.trim();
  const password = passwordInput.value.trim();

  // Regular expression pattern for email validation
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

  // Clearing previous error messages
  document
    .querySelectorAll(".form-group .error")
    .forEach((field) => field.classList.remove("error"));
  document
    .querySelectorAll(".error-text")
    .forEach((errorText) => errorText.remove());

  // Performing validation checks

  if (!emailPattern.test(email)) {
    showError(emailInput, "Enter a valid email address");
  }
  if (password === "") {
    showError(passwordInput, "Enter your password");
  }

  // Checking for any remaining errors before form submission
  const errorInputs = document.querySelectorAll(".form-group .error");
  if (errorInputs.length > 0) return;

  // Submitting the form
  form.submit();
};
if(passToggleBtn){
// Toggling password visibility
passToggleBtn.addEventListener("click", () => {
  passToggleBtn.className =
    passwordInput.type === "password"
      ? "fa-solid fa-eye-slash"
      : "fa-solid fa-eye";
  passwordInput.type = passwordInput.type === "password" ? "text" : "password";
});
}
if(form){
 // Handling form submission event
form.addEventListener("submit", handleFormData); 
}

