<div class="template_wrapper">
<div class="template_row">
<div class="template_column_1">
<?php if ($rows !== false) { ?>
<?php $last_forum_id = null; ?>
<?php foreach ($rows as $row) { ?>
<?php if ($last_forum_id !== $row['category_forum_id']) { ?>
<?php if ($last_forum_id !== null) { ?>
</div>
<?php } ?>
<div class="forum_row_wrapper">
<span class="primary"><?php echo sanitize($row['category_name']);?></span>
<?php } ?>
<div class="forum_row">
<div class="forum_column_1">
<a class="link_secondary" href="index.php?section=view_forum&id=<?php echo sanitize($row['forum_id']);?>"><?php echo sanitize($row['forum_name']);?></a>
<p class="p_nm"><?php echo sanitize($row['forum_description']);?></p>
</div>
<div class="forum_column_2">
<p class="p_nm">Topics</p>
<p class="p_nm"><?php echo sanitize($row['topic_count']);?></p>
</div>
<div class="forum_column_3">
<p class="p_nm">Posts</p>
<p class="p_nm"><?php echo sanitize($row['post_count']);?></p>
</div>
<div class="forum_column_4">
<?php if(empty($row['latest_topic_id'])) { ?>
<p class="p_nm">This category contains no topics.</p>
<?php } else { ?>
<p class="p_nm"><a class="link_default" href="index.php?section=view_topic&id=<?php echo sanitize($row['latest_topic_id']);?>"><?php echo sanitize($row['latest_topic_title']);?></a></p>
<p class="p_nm"><a class="link_default" href="index.php?section=profile&id=<?php echo sanitize($row['latest_topic_user_id']);?>"><?php echo sanitize_ucfirst($row['latest_topic_user']);?></a> at <?php echo sanitize($row['latest_topic_created']);?></p>
<?php } ?>
</div>
</div>
<?php $last_forum_id = $row['category_forum_id']; ?>
<?php } ?>
<?php if ($last_forum_id !== null) { ?>
</div>
<?php } ?>
<?php } else { ?>
<?php $message = new Message('Currently no forum has been created.', 'msg_wrapper_mt'); ?>
<?php echo $message->render_message(); ?>
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
