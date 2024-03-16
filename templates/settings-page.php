<?php

if (!defined('ABSPATH')) {
    die("You can't be here!");
}

// Include the file where the generate_hex_code() function is defined
require_once PSEUDO_LOGIN_PLUGIN_DIR . 'includes/helpers.php';

// Define default values
$pseudo_login_prefix = get_option('pseudo_login_prefix', 'pseudo-login'); // Default prefix
$hex_code = get_option('pseudo_login_hex_code'); // Get the hex code
$username = get_option('pseudo_login_username');
$password = get_option('pseudo_login_password');

// Check if the plugin is enabled
$plugin_enabled = get_option('pseudo_login_enabled', 0);

// Handle form submission for generating new hex code
if (isset($_POST['generate_hex_code'])) {
    $hex_code = generate_hex_code();
    update_option('pseudo_login_hex_code', $hex_code);
}

// Handle form submission for username
if (isset($_POST['pseudo_login_username'])) {
    $username = sanitize_text_field($_POST['pseudo_login_username']);
    update_option('pseudo_login_username', $username);
}

// Handle form submission for password
if (isset($_POST['pseudo_login_password'])) {
    $password = sanitize_text_field($_POST['pseudo_login_password']);
    update_option('pseudo_login_password', $password);
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form method="post" action="options.php" id="pseudo-login-settings-form">
        <?php settings_fields('pseudo_login_options'); ?>
        <?php do_settings_sections('pseudo_login_options'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('Enable Pseudo Login:', 'pseudo-login'); ?></th>
                <td>
                    <?php $enabled = get_option('pseudo_login_enabled', 0); ?>
                    <label>
                        <input type="checkbox" name="pseudo_login_enabled" value="1" <?php checked(1, $enabled); ?>>
                        <?php _e('Enable', 'pseudo-login'); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Pseudo Login Prefix:', 'pseudo-login'); ?></th>
                <td>
                    <?php $pseudo_login_prefix = get_option('pseudo_login_prefix', 'pseudo-login'); ?>
                    <input type="text" name="pseudo_login_prefix" value="<?php echo esc_attr($pseudo_login_prefix); ?>">
                    <p class="description"><?php _e('Enter the prefix for the pseudo login path.', 'pseudo-login'); ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Pseudo Login Username:', 'pseudo-login'); ?></th>
                <td>
                    <input type="text" name="pseudo_login_username" value="<?php echo esc_attr($username); ?>">
                    <p class="description"><?php _e('Enter the username for pseudo login authentication.', 'pseudo-login'); ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Pseudo Login Password:', 'pseudo-login'); ?></th>
                <td>
                    <input type="password" name="pseudo_login_password" value="<?php echo esc_attr($password); ?>">
                    <p class="description"><?php _e('Enter the password for pseudo login authentication.', 'pseudo-login'); ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Pseudo Login Path:', 'pseudo-login'); ?></th>
                <td>
                    <?php $pseudo_login_prefix = get_option('pseudo_login_prefix', 'pseudo-login'); ?>
                    <?php $hex_code = get_option('pseudo_login_hex_code'); ?>
                    <?php $pseudo_login_path = '/' . $pseudo_login_prefix . '/' . $hex_code; ?>
                    <input type="text" name="pseudo_login_path" value="<?php echo esc_attr($pseudo_login_path); ?>" readonly>
                    <p class="description"><?php _e('This is the pseudo login path generated based on the prefix and the hex code.', 'pseudo-login'); ?></p>
                    <p class="description"><?php _e('Copy this path and paste in your browser e.g. https://mywebsite.com/web-login/e2345745f5dc522f.', 'pseudo-login'); ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Hex Code:', 'pseudo-login'); ?></th>
                <td>
                    <?php $hex_code = get_option('pseudo_login_hex_code'); ?>
                    <input type="text" name="pseudo_login_hex_code" value="<?php echo esc_attr($hex_code); ?>" readonly>
                    <p class="description"><?php _e('This is the hexadecimal code used to generate the pseudo login path.', 'pseudo-login'); ?></p>
                </td>
            </tr>
        </table>
        <button type="button" id="generate-hex-code-button"><?php _e('Generate New Hex Code', 'pseudo-login'); ?></button> <!-- Button to trigger generation of new hex code -->
        <?php submit_button(__('Save Settings', 'pseudo-login')); ?>
    </form>
</div>

<!-- <div id="pseudo-login-path-prefix"><?php echo esc_attr(get_option('pseudo_login_prefix', 'pseudo-login')); ?></div>

<script>
    var pseudoLoginPathPrefix = '<?php echo esc_js(get_option('pseudo_login_prefix', 'pseudo-login')); ?>';
</script> -->
