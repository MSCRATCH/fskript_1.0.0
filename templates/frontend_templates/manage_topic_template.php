<?php  $token_1 = $csrf_token->generate_token('update_topic'); ?>
<?php  $token_2 = $csrf_token->generate_token('remove_topic'); ?>
<?php  $token_3 = $csrf_token->generate_token('lock_topic'); ?>
<?php  $token_4 = $csrf_token->generate_token('unlock_topic'); ?>

<div class="template_wrapper">
<div class="template_row">
<div class="template_column_1">
<div class="content_container_wrapper">
<span class="primary"><?php echo sanitize_ucfirst($topic['topic_title']);?></span>
<div class="content_container_margin_bottom">In this area, topics can be moved or marked for removal. Topics marked for removal will not be displayed.</div>
</div>
<form method="post">
<label for="forum_id_form">Move topic to another forum</label>
<select class="select_bg" name="forum_id_form" id="forum_id_form">
<?php foreach ($forums as $forum) { ?>
<option value="<?php echo sanitize($forum['forum_id']);?>"><?php echo sanitize($forum['forum_name']);?></option>
<?php } ?>
</select>
<label for="topic_title_form">Topic title</label>
<input class="form_text_default" type="text" name="topic_title_form" id="topic_title_form" value="<?php echo sanitize_ucfirst($topic['topic_title']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_topic">Update topic</button>
</form>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token_2;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="remove_topic">Remove topic</button>
</form>
<?php if ($topic['is_locked'] !== 1) { ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token_3;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="lock_topic">Lock topic</button>
</form>
<?php } else { ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token_4;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="unlock_topic">Unlock topic</button>
</form>
<?php } ?>
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
