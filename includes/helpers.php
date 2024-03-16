<?php

if (!defined('ABSPATH')) {
    die("You can't be here!");
} 

// Function to generate a random hexadecimal code
function generate_hex_code() {
    // Generate a random hexadecimal code
    $hex_code = bin2hex(random_bytes(8)); // Generate 8 bytes of random data and convert to hexadecimal

    return $hex_code;
}
