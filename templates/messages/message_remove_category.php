<?php  $token_4 = $csrf_token->generate_token('remove_category_confirm'); ?>

<div class="msg_wrapper_mt">
<span class="msg_span">System message</span>
<div class="msg_default">
<p>Are you sure you want to remove that category ?</p>
<p>Note that this will also remove all forums, topics and posts and assigned to that category. If you don't want this to happen, move the forums to other existing categories first.</p>
<form method="post">
<input type="hidden" name="category_id_confirm_form" value="<?php echo sanitize($category_id_form);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_4;?>">
<button class="msg_btn" type="submit" name="remove_category_confirm">Confirm</button>
</form>
<a href="index.php?section=forum_management"><button class="msg_btn">Cancel</button></a>
</div>
</div>
