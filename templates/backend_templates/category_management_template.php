<?php  $token_1 = $csrf_token->generate_token('submit_category'); ?>
<?php  $token_2 = $csrf_token->generate_token('update_category'); ?>
<?php  $token_3 = $csrf_token->generate_token('remove_category'); ?>

<div class="backend_wrapper">
<div class="content_container_wrapper">
<span class="primary">Adding a new category</span>
<div class="content_container_margin_bottom">In this area, new categories can be created, edited, and existing ones deleted.</div>
</div>
<form method="post">
<label for="category_name_form">Category name</label>
<input class="form_text_default" type="text" name="category_name_form" id="category_name_form">
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="submit_category">Submit category</button>
</form>

<?php if ($rows !== false) { ?>
<?php foreach ($rows as $row) { ?>
<form method="post">
<label for="forum_name_update_form">category name</label>
<input class="form_text_default" type="text" name="category_name_update_form" id="category_name_update_form" value="<?php echo sanitize_ucfirst($row['category_name']);?>">
<input type="hidden" name="category_id_update_form" value="<?php echo sanitize($row['category_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_2;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_category">Update category</button>
</form>
<form method="post">
<input type="hidden" name="category_id_form" value="<?php echo sanitize($row['category_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_3;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="remove_category">Remove category</button>
</form>
<?php } ?>
<?php } ?>
</div>
