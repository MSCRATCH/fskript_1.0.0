<?php  $token_1 = $csrf_token->generate_token('update_post'); ?>
<?php  $token_2 = $csrf_token->generate_token('remove_post'); ?>

<div class="template_wrapper">
<div class="template_row">
<div class="template_column_1">
<div class="content_container_wrapper">
<span class="primary">Editing a post</span>
<div class="content_container_margin_bottom">In this area, the requested post can be edited or marked for removal. Posts marked for removal will not be displayed.</div>
</div>
<form method="post">
<label for="post_content_form">Content of the post</label>
<textarea class="textarea_default" name="post_content_form" id="post_content_form" autocomplete="off"><?php echo sanitize($post['post_content']); ?></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_post">Update post</button>
</form>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token_2;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="remove_post">Remove post</button>
</form>
</div>
<div class="template_column_2">
<div class="template_aside_wrapper">
<span class="primary"><?php echo sanitize($settings['site_title']['setting_value']); ?></span>
<div class="template_aside_nav">
<ul>
<li><a href="index.php">Home</a></li>
<?php if (! Auth::is_logged_in()) { ?>
<li><a href="index.php?section=login">Login</a></li>
<li><a href="index.php?section=register">Register</a></li>
<?php } ?>
<?php if (Auth::is_logged_in()) { ?>
<?php $username_header = Auth::get_username(); ?>
<?php $user_id_header = Auth::get_user_id(); ?>
<li><a href="index.php?section=profile&id=<?php echo sanitize($user_id_header);?>">Your profile</a></li>
<li><a href="index.php?section=manage_profile">Settings</a></li>
<?php } ?>
<?php if (Auth::is_administrator()) { ?>
<li><a href="index.php?section=setting_management">Administration</a></li>
<?php } ?>

<?php if (Auth::is_logged_in()) { ?>
<li><a href="index.php?section=logout">Logout</a></li>
<?php } ?>

</ul>
</div>
</div>
</div>
</div>
</div>
