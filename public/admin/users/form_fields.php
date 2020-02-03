<?php
// Prevents this code from being loades in the browser
// without first setting the nessasary object
if (!isset($user)) {
  redirect_to(url_for('/admin/users/index.php'));
}
?>

<div class="input-box">
  <label for="email">Email: </label>
  <input type="text" name="user[email]" value="<?php echo h($user->email); ?>">
</div>

<div class="input-box">
  <label for="username">Username: </label>
  <input type="text" name="user[username]" value="<?php echo h($user->username); ?>">
</div>

<div class="input-box">
  <label for="password">Password(min. 8 characters): </label>
  <input type="password" name="user[password]">
</div>

<div class="input-box">
  <label for="confirm">Confirm Password: </label>
  <input type="password" name="user[confirm_password]">
</div>

<!-- TODO Show only when administrator -->
<div class="radio-box">
  <label for="is-admin">Is administrator: </label>
  <input type="radio" name="user[is_admin]" value="0" <?php echo ($user->is_admin == 0) ? 'checked="checked"' : ''; ?>>No&nbsp;
  <input type="radio" name="user[is_admin]" value="1" <?php echo ($user->is_admin > 0) ? 'checked="checked"' : ''; ?>>Yes
</div>