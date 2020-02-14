<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* It is only administrators that can see all accounts
* that are in the database 
*/

require_admin_role();

$page_title = 'Admin Area - Users Front Page';

// Get all users from database
$users = User::find_all();

//var_dump($users);
?>


<?php include_once SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/users/new.php'); ?>">
  <button class="btn-link" role="link">Create New</button>
</a>

<section class="index-page-tabel">
  <table>
    <tr>
      <th>ID</th>
      <th>Email</th>
      <th>Username</th>
      <th>Role</th>
      <th>Created</th>
      <th>Last Login</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
    <?php foreach ($users as $user) { ?>

      <tr>
        <td class="num"><?php echo h($user->id); ?></td>
        <td><?php echo h($user->email); ?></td>
        <td><?php echo h($user->username); ?></td>
        <td><?php echo $user->is_admin == '0' ? 'User' : 'Administrator'; ?></td>
        <td><?php echo date('d.m Y', h($user->created)); ?></td>
        <td><?php echo $user->last_logged_in != 0 ? date('d.m Y', h($user->last_logged_in)) : 'Never'; ?></td>

        <td class="btn">
          <a href="<?php echo url_for('/admin/users/show.php?id=' . h(u($user->id))); ?>">
            <button class="btn-link" role="link">Show</button>
          </a>
        </td>

        <td class="btn">
          <a href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user->id))); ?>">
            <button class="btn-link" role="link">Edit</button>
          </a>
        </td>

        <td class="btn">
          <a href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user->id))); ?>">
            <button class="btn-danger" role="link">Delete</button>
          </a>
        </td>

      </tr>

    <?php } ?>

  </table>

</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>