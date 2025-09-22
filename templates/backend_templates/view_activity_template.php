<div class="table_wrapper">
<div class="content_container_wrapper">
<span class="primary">Activity log</span>
<div class="content_container_margin_bottom">This area displays the logged activities of the requested user. Keep in mind that the logged IP address is not necessarily a reliable indicator, as it can easily be falsified.</div>
</div>
<div class="table_container">
<div class="table_row table_title">
<div class="table_cell">Username</div>
<div class="table_cell">Topic</div>
<div class="table_cell">Timestamp</div>
<div class="table_cell">User's IP address</div>
</div>
<?php foreach ($activity_entries as $activity_entry) { ?>
<div class="table_row">
<div class="table_cell"><a class="link_default" href="index.php?section=profile&id=<?php echo sanitize($activity_entry['user_id']);?>"><?php echo sanitize_ucfirst($activity_entry['username']);?></a> <?php echo sanitize($activity_entry['activity_log_act']);?></div>
<div class="table_cell"><a class="link_default" href="index.php?section=view_topic&id=<?php echo sanitize($activity_entry['topic_id']);?>"><?php echo sanitize($activity_entry['topic_title']);?></a></div>
<div class="table_cell"><?php echo sanitize($activity_entry['activity_log_timestamp']);?></div>
<div class="table_cell"><?php echo sanitize($activity_entry['activity_log_ip_address']);?></div>

</div>
<?php } ?>

</div>
<div class="pagination">
<?php echo $pagination->render_pagination('index.php?section=view_activity_log'); ?>
</div>
</div>
