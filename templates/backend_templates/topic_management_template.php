<?php  $token_1 = $csrf_token->generate_token('remove_topic_permanent'); ?>
<?php  $token_2 = $csrf_token->generate_token('restore_topic'); ?>

<div class="table_wrapper">
<div class="content_container_wrapper">
<span class="primary">Topic management</span>
<div class="content_container_margin_bottom">In this area, topics that have been marked for removal by the administrator or moderators can be restored or completely removed.</div>
</div>
<div class="table_container">
<div class="table_row table_title">
<div class="table_cell">Topic</div>
<div class="table_cell">Topic created</div>
<div class="table_cell">Remove</div>
<div class="table_cell">Restore</div>
</div>
<?php $i = 1; ?>
<?php foreach ($topics as $topic) { ?>
<div class="table_row">
<div class="table_cell">#<?php echo sanitize($i);?> <a class="link_default" href="index.php?section=topic_management_view&id=<?php echo sanitize($topic['topic_id']);?>"><?php echo sanitize_ucfirst($topic['topic_title']);?></a></div>
<div class="table_cell"><?php echo sanitize($topic['topic_created']);?></div>
<div class="table_cell">
<form method="post">
<input type="hidden" name="topic_id_form" value="<?php echo sanitize($topic['topic_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_table" type="submit" name="remove_topic_permanent">Remove</button>
</form>
</div>
<div class="table_cell">
<form method="post">
<input type="hidden" name="topic_id_form" value="<?php echo sanitize($topic['topic_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_2;?>">
<button class="btn_table" type="submit" name="restore_topic">Restore</button>
</form>
</div>
</div>
<?php $i++; ?>
<?php } ?>

</div>
<div class="pagination">
<?php echo $pagination->render_pagination('index.php?section=topic_management'); ?>
</div>
</div>
