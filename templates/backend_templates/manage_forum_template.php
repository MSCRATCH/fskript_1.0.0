<?php  $token_1 = $csrf_token->generate_token('update_forum'); ?>
<?php  $token_2 = $csrf_token->generate_token('remove_forum'); ?>

<div class="backend_wrapper">

<div class="content_container_wrapper">
<span class="primary">Edit or remove existing forums</span>
<div class="content_container_margin_bottom">In this area the selected forum can be edited, removed or moved to another forum.</div>
</div>

<form method="post">
<label for="category_id_form">Select a Category</label>
<select class="select_bg" name="category_id_form" id="forum_id_form">
<?php foreach ($categories as $category) { ?>
<option value="<?php echo sanitize($category['category_id']);?>"><?php echo sanitize($category['category_name']);?></option>
<?php } ?>
</select>
<label for="forum_name_update_form">Forum title</label>
<input class="form_text_default" type="text" name="forum_name_update_form" id="forum_name_update_form" value="<?php echo sanitize_ucfirst($forums['forum_name']);?>">
<label for="form_description_update_form">Forum description</label>
<textarea class="textarea_default" name="forum_description_update_form" id="forum_description_update_form"><?php echo sanitize($forums['forum_description']);?></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_forum">Update forum</button>
</form>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token_2;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="remove_forum">Remove forum</button>
</form>

</div>
