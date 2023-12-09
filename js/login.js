$(document).ready(function () {
    // Wait for the DOM content to be fully loaded

    // Find the login button and add a click event listener
    $("#loginButton").click(function (event) {

        event.preventDefault();
        // Get the values from the input fields
        var email = $("#exampleInputEmail1").val();
        var password = $("#exampleInputPassword1").val();

        // Perform AJAX request to the backend
        $.ajax({
            type: "POST",
            url: "php/login.php", // Replace with the correct path to your PHP file
            data: {
                email: email,
                password: password
            },
            success: function (response) {
                // Handle the JSON response from the backend
                if (response.status === "exists") {
                    alert("Login successful!");
                    // Redirect to the profile page
                    window.location.href = "profile.html"; // Replace with your profile page URL
                } else if (response.status === "login_failed") {
                    alert("Invalid email or password");
                } else {
                    alert("Error: Something went wrong.");
                }
            },
            error: function (error) {
                // Handle the error response from the backend
                alert("Error: " + error.responseText);
            }
        });
    });
});
