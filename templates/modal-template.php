<?php
// modal-template.php

// Modal template HTML
?>
<div id="pseudo-login-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2 class="pseudo-modal-title"><?php _e('Enter Your Credentials', 'pseudo-login'); ?></h2>
    <form id="pseudo-login-form">
      <label for="username"><?php _e('Username:', 'pseudo-login'); ?></label>
      <input class="pseudo-form-input" type="text" id="username" name="username">
      <label for="password"><?php _e('Password:', 'pseudo-login'); ?></label>
      <input class="pseudo-form-input" type="password" id="password" name="password">
      <button type="submit"><?php _e('Submit', 'pseudo-login'); ?></button>
      <p id="error-message" class="error"></p>
    </form>
  </div>
</div>
