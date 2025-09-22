<div class="table_wrapper">
<div class="content_container_wrapper">
<span class="primary">Show user logs</span>
<div class="content_container_margin_bottom">This area displays the logged activities of the requested user. Keep in mind that the logged IP address is not necessarily a reliable indicator, as it can easily be falsified.</div>
</div>
<div class="table_container">
<div class="table_row table_title">
<div class="table_cell">Username</div>
<div class="table_cell">User's IP address</div>
<div class="table_cell">Timestamp</div>
<div class="table_cell">Login</div>
</div>
<?php $i = 1; ?>
<?php foreach ($login_protocol_entries as $login_protocol_entry) { ?>
<div class="table_row">
<div class="table_cell">#<?php echo sanitize($i);?> <a class="link_default" href="index.php?section=profile&id=<?php echo sanitize($login_protocol_entry['user_id']);?>"><?php echo sanitize_ucfirst($login_protocol_entry['username']);?> (<?php echo sanitize($login_protocol_entry['user_id']);?>)</a></div>
<div class="table_cell"><?php echo sanitize($login_protocol_entry['login_protocol_ip_address']);?></div>
<div class="table_cell"><?php echo sanitize($login_protocol_entry['login_protocol_timestamp']);?></div>
<?php if ($login_protocol_entry['login_protocol_successful'] === 1) { ?>
<div class="table_cell">successful</div>
<?php } else { ?>
<div class="table_cell">failed</div>
<?php }?>
</div>
<?php $i++; ?>
<?php } ?>

</div>
<div class="pagination">
<?php echo $pagination->render_pagination('index.php?section=view_login_protocol&user_id='. $user_id_get); ?>
</div>
</div>
