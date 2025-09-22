<?php  $token_4 = $csrf_token->generate_token('remove_forum_confirm'); ?>

<div class="msg_wrapper_mt">
<span class="msg_span">System message</span>
<div class="msg_default">
<p>Are you sure you want to remove that forum ?</p>
<p>Note that this will also remove all topics and posts assigned to that forum. If you don't want this to happen, move the topics to other existing forums first.</p>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token_4;?>">
<button class="msg_btn" type="submit" name="remove_forum_confirm">Confirm</button>
</form>
<a href="index.php?section=manage_forum&forum_id=<?php echo sanitize($forum_id_get);?>"><button class="msg_btn">Cancel</button></a>
</div>
</div>
