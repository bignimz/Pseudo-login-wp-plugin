<?php
/*
Plugin Name: Pseudo Login Plugin
Description: Disables default admin login and creates a pseudo login path using hexadecimal characters.
Version: 1.0
Author: Nimrod Musungu
*/

if (!defined('ABSPATH')) {
    die("You can't be here!");
}

// Define constants
define('PSEUDO_LOGIN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PSEUDO_LOGIN_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once PSEUDO_LOGIN_PLUGIN_DIR . 'includes/admin/pseudo-login-admin.php';
require_once PSEUDO_LOGIN_PLUGIN_DIR . 'templates/modal-template.php';

// Initialize the plugin
function pseudo_login_init() {
    // Initialize admin functionality
    new Pseudo_Login_Admin();
}
add_action('plugins_loaded', 'pseudo_login_init');

// Enqueue the Admin JavaScript file
function pseudo_login_enqueue_scripts() {
    wp_enqueue_script('pseudo-login-script', PSEUDO_LOGIN_PLUGIN_URL . 'assets/js/pseudo-login.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'pseudo_login_enqueue_scripts');

// Enqueue Frontend ASSETS
function pseudo_login_plugin_enqueue_frontend_assets() {
    // Enqueue pseudo login JavaScript for frontend
    wp_enqueue_script('pseudo-login-frontend-script', PSEUDO_LOGIN_PLUGIN_URL . 'assets/js/pseudo-login-frontend.js', array('jquery'), '1.0', true);
    wp_enqueue_style('pseudo-login-frontend-styles', PSEUDO_LOGIN_PLUGIN_URL . 'assets/css/pseudo-login-frontend.css', [], '1.0', "all");

    // Localize the script with the ajaxurl
    wp_localize_script('pseudo-login-frontend-script', 'pseudoLoginAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'pseudo_login_plugin_enqueue_frontend_assets');

// Function to handle pseudo login authentication and redirection
function handle_pseudo_login_authentication() {
    // Check if the form is submitted and the nonce is set
    if (isset($_POST['pseudo_login_nonce']) && wp_verify_nonce($_POST['pseudo_login_nonce'], 'pseudo_login_nonce')) {
        // Get the submitted username and password
        $submitted_username = isset($_POST['pseudo_login_username']) ? sanitize_text_field($_POST['pseudo_login_username']) : '';
        $submitted_password = isset($_POST['pseudo_login_password']) ? sanitize_text_field($_POST['pseudo_login_password']) : '';

        // Get the expected username and password from options
        $expected_username = get_option('pseudo_login_username');
        $expected_password = get_option('pseudo_login_password');

        if ($submitted_username === $expected_username && password_verify($submitted_password, $expected_password)) {
            // Redirect to the default WordPress login page
            wp_redirect(wp_login_url());
            exit;
        } else {
            // Invalid credentials, redirect to pseudo login page with error message
            wp_redirect(home_url(add_query_arg('login_error', 'true')));
            exit;
        }
    }

    // Check if the "Enable Pseudo Login" checkbox is checked
    $enabled = get_option('pseudo_login_enabled', 0);
    if ($enabled && !is_user_logged_in()) {
        // Redirect if accessing wp-login.php or /wp-admin/
        if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== false || strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
            // Redirect to a custom error page or any other desired page
            wp_redirect(home_url('/'));
            exit;
        }

        // Check if the current URL matches the pseudo login path
        $pseudo_login_prefix = get_option('pseudo_login_prefix', 'pseudo-login');
        $hex_code = get_option('pseudo_login_hex_code');
        $pseudo_login_path = '/' . $pseudo_login_prefix . '/' . $hex_code;
        $requested_url = esc_url($_SERVER['REQUEST_URI']);

        if ($requested_url === home_url($pseudo_login_path)) {
            // Show pseudo login modal
            return;
        }
    }
}
add_action('init', 'handle_pseudo_login_authentication');

// Handle form submission for username
function handle_pseudo_login_username_submission() {
    if (isset($_POST['pseudo_login_username'])) {
        $username = sanitize_text_field($_POST['pseudo_login_username']);
        update_option('pseudo_login_username', $username);
    }
}
add_action('admin_init', 'handle_pseudo_login_username_submission');

// Handle form submission for password
function handle_pseudo_login_password_submission() {
    if (isset($_POST['pseudo_login_password'])) {
        $password = sanitize_text_field($_POST['pseudo_login_password']);
        update_option('pseudo_login_password', $password);
    }
}
add_action('admin_init', 'handle_pseudo_login_password_submission');
?>
