$(document).ready(function () {
  // Wait for the DOM content to be fully loaded

  // Find the form and add a submit event listener
  $("#registerButton").click(function (event) {
    // Prevent the default form submission
    event.preventDefault();

    // Get the values from the input fields

    var email = $("#inputEmail3").val();
    
    
    var password = $("#inputPassword").val();
    var confirmPassword = $("#inputPassword2").val();

    // Validate password matching
    if (password !== confirmPassword) {
      alert("Passwords do not match");
      return;
    }


    // Perform AJAX request to the backend
    $.ajax({
      type: "POST",
      url: "php/register.php", // Replace with your backend URL
      data: {
        
        email: email,
        
        password: password,
       
      },
      success: function (response) {
        // Handle the success response from the backend
        if (response.status === "exists") {
          alert("User already registered!");
        } else if (response.status === "success") {
          alert("Registration successful");
        } else {
          alert("Error in registration. Please try again.");
        }
      },
      error: function (error) {
        // Handle the error response from the backend
        $("#registrationResponse").html("Error: " + error.responseText);
      }
    });
  });
});
