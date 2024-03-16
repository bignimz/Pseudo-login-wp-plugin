<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Pseudo_Login_Admin {
    // Constructor
    public function __construct() {
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
    }

    // Add admin menu
    public function add_admin_menu() {
        add_options_page(
            __('Pseudo Login Settings', 'pseudo-login'),
            __('Pseudo Login', 'pseudo-login'),
            'manage_options',
            'pseudo-login-settings',
            array($this, 'settings_page')
        );
    }

    // Settings page callback
    public function settings_page() {
        // Include settings page template
        include PSEUDO_LOGIN_PLUGIN_DIR . 'templates/settings-page.php';
    }

    // Register settings
    public function register_settings() {
        // Register a new setting for the options page
        register_setting('pseudo_login_options', 'pseudo_login_enabled');
        register_setting('pseudo_login_options', 'pseudo_login_path');
        register_setting('pseudo_login_options', 'pseudo_login_prefix');
        register_setting('pseudo_login_options', 'pseudo_login_hex_code');
    }
}
