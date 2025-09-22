<?php  $token_1 = $csrf_token->generate_token('reply_topic'); ?>

<div class="template_wrapper">
<div class="template_row">
<div class="template_column_1">

<?php foreach ($rows as $row) { ?>

<div class="forum_row_wrapper">
<span class="primary"><?php echo sanitize($row['topic_title']);?></span>
<div class="post_row">
<div class="post_column_1">
<img src="images/<?php echo sanitize($row['user_profile_picture']); ?>" alt="profile_picture_post" class="profile_picture_post">
<ul>
<li class="li_un"><a class="link_secondary" href="index.php?section=profile&id=<?php echo sanitize($row['user_id']);?>"><?php echo sanitize_ucfirst($row['username']);?></a></li>
<li class="li_un"><?php echo sanitize_ucfirst($row['user_level']);?></li>
<?php if ($row['last_activity_minutes'] <= 5) { ?>
<li class="li_un">Online</li>
<?php } else { ?>
<li class="li_un">Offline</li>
<?php }?>
<?php if (Auth::is_administrator_or_moderator()) { ?>
<li class="li_un"><a class="link_default" href="index.php?section=manage_post&topic_id=<?php echo sanitize($topic_id_get);?>&post_id=<?php echo sanitize($row['post_id']);?>">Manage post</a></li>
<?php } ?>
</ul>
</div>
<div class="post_column_2">
<p class="p_nm"><?php echo sanitize($row['post_created']);?></p>
<p class="p_nm"><?php echo bb($row['post_content']);?></p>
</div>
</div>
</div>
<?php } ?>
<div class="pagination">
<?php echo $pagination->render_pagination('index.php?section=view_topic&id='. $topic_id_get); ?>
</div>
<?php if ($topic['is_locked'] !== 1) { ?>
<?php if (Auth::is_logged_in()) { ?>
<a id="reply_form"></a>
<form method="post">
<label for="post_content_form">Reply to this topic</label>
<textarea class="textarea_default" name="post_content_form" id="post_content_form" placeholder="Reply to this topic"></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="reply_topic">Reply</button>
</form>
<?php } ?>
<?php } else { ?>
<div class="content_container_wrapper">
<span class="primary">Locked</span>
<div class="content_container_margin_bottom">This topic has been locked by an administrator or moderator. It is therefore no longer possible to reply.</div>
</div>
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
<li><a href="#reply_form">Reply to this topic</a></li>
<?php } ?>
</ul>
</div>
</div>
</div>
</div>
</div>
