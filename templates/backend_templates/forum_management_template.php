<?php  $token_1 = $csrf_token->generate_token('submit_forum'); ?>

<div class="backend_wrapper">
<div class="content_container_wrapper">
<span class="primary">Adding a new Forum</span>
<div class="content_container_margin_bottom">Forums can be managed in this area.</div>
</div>
<form method="post">
<label for="category_id_form">Select a Category</label>
<select class="select_bg" name="category_id_form" id="category_id_form">
<?php foreach ($categories as $category) { ?>
<option value="<?php echo sanitize($category['category_id']);?>"><?php echo sanitize($category['category_name']);?></option>
<?php } ?>
</select>
<label for="forum_name_form">Forum title</label>
<input class="form_text_default" type="text" name="forum_name_form" id="forum_name_form" placeholder="Enter the name for the forum.">
<label for="forum_description_form">Forum description</label>
<textarea class="textarea_default" name="forum_description_form" id="forum_description_form" autocomplete="off" placeholder="Enter the description for the forum."></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="submit_forum">Submit forum</button>
</form>

<?php if ($forums !== false) { ?>
<?php $i = 1; ?>
<?php foreach ($forums as $forum) { ?>
<div class="content_container_wrapper">
<a class="link_block" href="index.php?section=manage_forum&forum_id=<?php echo sanitize($forum['forum_id']);?>">
<span class="primary">#<?php echo sanitize($i);?> <?php echo sanitize($forum['forum_name']);?></span>
<div class="content_container_margin_bottom">
<?php echo sanitize($forum['forum_description']);?>
</div>
</a>
<?php $i++; ?>
<?php } ?>

<div class="pagination">
<?php echo $pagination->render_pagination('index.php?section=forum_management'); ?>
</div>
</div>
<?php } ?>
</div>
