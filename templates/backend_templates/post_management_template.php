<?php  $token_1 = $csrf_token->generate_token('remove_post_permanent'); ?>
<?php  $token_2 = $csrf_token->generate_token('restore_post'); ?>

<div class="table_wrapper">
<div class="content_container_wrapper">
<span class="primary">Post management</span>
<div class="content_container_margin_bottom">In this area, posts that have been marked for removal by the administrator or moderators can be restored or completely removed.</div>
</div>
<div class="table_container">
<div class="table_row table_title">
<div class="table_cell">Topic</div>
<div class="table_cell">Post created</div>
<div class="table_cell">Post created by</div>
<div class="table_cell">Remove</div>
<div class="table_cell">Restore</div>
</div>
<?php $i = 1; ?>
<?php foreach ($posts as $post) { ?>
<div class="table_row">
<div class="table_cell">#<?php echo sanitize($i);?> <a class="link_default" href="index.php?section=post_management_view&id=<?php echo sanitize($post['post_id']);?>"><?php echo sanitize_ucfirst($post['topic_title']);?></a></div>
<div class="table_cell"><?php echo sanitize($post['post_created']);?></div>
<div class="table_cell"><a class="link_secondary" href="index.php?section=profile&id=<?php echo sanitize($post['user_id']);?>"><?php echo sanitize_ucfirst($post['username']);?></a></div>
<div class="table_cell">
<form method="post">
<input type="hidden" name="post_id_form" value="<?php echo sanitize($post['post_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_table" type="submit" name="remove_post_permanent">Remove</button>
</form>
</div>
<div class="table_cell">
<form method="post">
<input type="hidden" name="post_id_form" value="<?php echo sanitize($post['post_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_2;?>">
<button class="btn_table" type="submit" name="restore_post">Restore</button>
</form>
</div>
</div>
<?php $i++; ?>
<?php } ?>

</div>
<div class="pagination">
<?php echo $pagination->render_pagination('index.php?section=post_management'); ?>
</div>
</div>
