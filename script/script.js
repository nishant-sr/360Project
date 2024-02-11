// script file for js
var signedIn = false;

var profileLink = document.getElementsByClassName("link-profile");
console.log(profileLink[0]);
profileLink[0].style.display = 'none';

function loggedInNav(){
    profileLink.style.display = 'block';
}

function validateSignUp(event) {
    // Prevent the form from submitting by default
    event.preventDefault();

    // Reset error messages
    document.getElementById('signupError').innerText = '';

    // Get form values
    var username = document.getElementById('usernameSignUp').value;
    var password = document.getElementById('passwordSignUp').value;

    // Simple validation example (you may want to implement more robust checks)
    if (username.length < 5 || password.length < 8) {
      document.getElementById('signupeError').innerText = 'Username must be at least 5 characters.';
      return;
    }

    // If validation passes, you can proceed with other actions, e.g., submit the form
    document.getElementById('signupForm').submit();
    signedIn = true;
    loggedInNav();
  }

  function validateSignIn(event) {
    // Prevent the form from submitting by default
    event.preventDefault();

    // Reset error messages
    document.getElementById('signinError').innerText = '';

    // Get form values
    var username = document.getElementById('usernameSignIn').value;
    var password = document.getElementById('passwordSignIn').value;

    // Simple validation example (you may want to implement more robust checks)
    if (username.length < 5 || password.length < 8) {
        document.getElementById('signineError').innerText = 'Username must be at least 5 characters.';
        return;
      }

    // If validation passes, you can proceed with other actions, e.g., submit the form
    document.getElementById('signinForm').submit();
    signedIn = true;
    loggedInNav();
  }