jQuery(document).ready(function ($) {
  // Get the prefix from the pseudo-login-path
  var pseudoLoginPathPrefix = "my-login";
  var pseudoLoginPath = "/" + pseudoLoginPathPrefix + "/";

  // Show modal when pseudo login path is accessed
  if (window.location.pathname.indexOf(pseudoLoginPath) !== -1) {
    $("#pseudo-login-modal").show();
  }

  // Close modal when close button is clicked
  $(".close").click(function () {
    $("#pseudo-login-modal").hide();
  });

  // Handle form submission
  $("#pseudo-login-form").submit(function (event) {
    event.preventDefault(); // Prevent default form submission

    // Get entered username and password
    var username = $("#username").val();
    var password = $("#password").val();

    console.log(username);
    console.log(password);

    // AJAX request to authenticate
    $.ajax({
      url: pseudoLoginAjax.ajaxurl, // URL to admin-ajax.php
      type: "POST",
      data: {
        action: "pseudo_login_authenticate", // Custom action for authentication
        pseudo_login_nonce: $("#pseudo-login-nonce").val(),
        pseudo_login_username: username,
        pseudo_login_password: password,
      },
      success: function (response) {
        // If authentication successful, redirect to default login page
        if (response === "authenticated") {
          window.location.href = "<?php echo wp_login_url(); ?>";
        } else {
          // Display error message or handle authentication failure
          $("#error-message").text("Invalid username or password");
        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX errors
        console.error(xhr.responseText);
      },
    });
  });
});
