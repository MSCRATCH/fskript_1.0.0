<?php  $token_1 = $csrf_token->generate_token('create_topic'); ?>

<div class="template_wrapper">
<div class="template_row">
<div class="template_column_1">
<div class="forum_row_wrapper">
<?php  if ($forum && $rows !== false) { ?>
<span class="primary"><?php echo sanitize($forum['forum_name']);?></span>
<?php foreach ($rows as $row) { ?>
<div class="forum_row">
<div class="forum_column_1">
<a class="link_secondary" href="index.php?section=view_topic&id=<?php echo sanitize($row['topic_id']);?>"><?php echo sanitize($row['topic_title']);?></a>
<p class="p_nm"><a class="link_secondary" href="index.php?section=profile&id=<?php echo sanitize($row['user_id']);?>"><?php echo sanitize_ucfirst($row['username']);?></a> at <?php echo sanitize($row['topic_created']);?></p>
</div>
<div class="forum_column_2">
<p class="p_nm">Posts</p>
<p class="p_nm"><?php echo sanitize($row['post_count']);?></p>
</div>
<div class="forum_column_3">
<p class="p_nm">Last Post</p>
<?php if(empty($row['last_post_id'])) { ?>
<p class="p_nm">This topic contains no posts.</p>
<?php } else { ?>
<p class="p_nm"><a class="link_default" href="index.php?section=profile&id=<?php echo sanitize($row['last_post_user_id']);?>"><?php echo sanitize_ucfirst($row['last_post_username']);?></a> <?php echo sanitize($row['last_post_created']);?></p>
<?php } ?>
</div>
<?php if (Auth::is_administrator_or_moderator()) { ?>
<div class="forum_column_4">
<p class="p_nm"><a class="link_default" href="index.php?section=manage_topic&forum_id=<?php echo sanitize($forum_id_get);?>&topic_id=<?php echo sanitize($row['topic_id']);?>">Manage topic</a></p>
</div>
<?php } ?>
</div>
<?php } ?>
<?php } else { ?>
<?php  $message = new Message('This category contains no topics.', 'msg_wrapper_mt'); ?>
<?php echo $message->render_message(); ?>
<?php } ?>
</div>
<div class="pagination">
<?php echo $pagination->render_pagination('index.php?section=view_forum&id='. $forum_id_get); ?>
</div>
<?php if (Auth::is_logged_in()) { ?>
<form method="post">
<label for="topic_title_form">Title of the new topic</label>
<input class="form_text_default" type="text" name="topic_title_form" id="topic_title_form" placeholder="Title of the new topic">
<label for="post_content_form">Create a new topic</label>
<textarea class="textarea_default" name="post_content_form" id="post_content_form" placeholder="Create a new topic"></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="create_topic">Create a new topic</button>
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
