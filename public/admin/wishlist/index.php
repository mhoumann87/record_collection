<?php require_once '../../../private/initialize.php'; ?>

<?php

require_login();

$items = Wishlist::find_by_field_and_sort('user_id', $session->user_id, 'added');
//var_dump($items);

$page_title = 'Wishlist for ' . $session->username;

?>

<?php include SHARED_PATH . '/header.php'; ?>

<section class="index-page-tabel">

  <?php if (!empty($items)) { ?>

    <table>
      <thead>
        <tr>
          <th>Cover</th>
          <th>Title</th>
          <th>Artist</th>
          <th>Format</th>
          <th>Added At</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item) {
          $record = Record::find_by_id($item->record_id);
        ?>
          <tr>
            <td>
              <?php if ($record->image_link != '') { ?>
                <img src="<?php echo h($record->image_link); ?>" alt="<?php echo $record->get_title_and_artist(); ?>" />
              <?php } elseif ($record->image) { ?>
                <img src="<?php echo url_for('/assets/images/' . $record->get_table_name() . '/' . $record->image); ?>" alt="<?php echo $record->get_title_and_artist(); ?>" />
              <?php } else { ?>
                <p>No Image</p>
              <?php } ?>
            </td>

            <td><?php echo $record->show_artist_name(); ?></td>

            <td><?php echo ucfirst(h($record->title)); ?></td>

            <td><?php echo $item->get_format_for_item(); ?></td>

            <td><?php echo $item->get_date_added(); ?></td>

            <td class="btn">
              <a href="<?php echo url_for('/admin/wishlist/show.php?id=' . h(u($item->id))); ?>">
                <button class="btn-link" role="link">See Item</button>
              </a>
            </td>

            <td class="btn">
              <a href="<?php echo url_for('/admin/wishlist/edit.php?id=' . h(u($item->id))); ?>">
                <button class="btn-link" role="link">Edit Item</button>
              </a>
            </td>

            <td class="btn">
              <a href="<?php echo url_for('/admin/collection/new.php?id=' . h(u($item->id))); ?>">
                <button class="btn-success" role="link">Add Record</button>
              </a>
            </td>

            <td class="btn">
              <a href="<?php echo url_for('/admin/wishlist/delete.php?id=' . h(u($item->id))) ?>">
                <button class="btn-danger" role="link">Delete Item</button>
              </a>
            </td>

          </tr>
        <?php } ?>

      </tbody>

    </table>

  <?php  } else { ?>
    <p>There are no items on the wishlist.</p>

  <?php } ?>

  <?php ?>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>