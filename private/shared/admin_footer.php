<footer class="admin-footer">
  <div class="first">
    <h4>My Record Collection</h4>
    <small>&copy;<?php echo (2020 == date("Y")) ? '2020' : "2020 - " . date("Y"); ?> <a href="https://michael-h.dk" target="_blank">Michael Houmann</a></small>
  </div>
</footer>

<script src="<?php echo url_for('/assets/js/main.js'); ?>"></script>

</body>

</html>

<?php db_disconnect($db); ?>