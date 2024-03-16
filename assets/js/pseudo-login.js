jQuery(document).ready(function ($) {
  // When the "Generate New Hex Code" button is clicked
  $("#generate-hex-code-button").click(function () {
    // Generate a new hex code
    var newHexCode = generateHexCode();

    // Update the hex code field value
    $('input[name="pseudo_login_hex_code"]').val(newHexCode);

    // Update the pseudo login path field value
    var pseudoLoginPrefix = $('input[name="pseudo_login_prefix"]').val(); // Get the prefix value
    var newPseudoLoginPath = "/" + pseudoLoginPrefix + "/" + newHexCode; // Concatenate prefix and new hex code
    $('input[name="pseudo_login_path"]').val(newPseudoLoginPath);

    // Submit the form
    $("#pseudo-login-settings-form").submit();
  });

  // Function to generate a new hex code
  function generateHexCode() {
    // Generate a random hexadecimal code
    return Array.from({ length: 16 }, () =>
      Math.floor(Math.random() * 16).toString(16)
    ).join("");
  }
});
