<div class="template_wrapper">
<div class="template_row">
<div class="template_column_1">
<div class="profile_wrapper">
<span class="primary"><?php echo sanitize_ucfirst($user_data['username']); ?></span>
<div class="profile">
<div class="row">
<div class="column_1">
<img src="images/<?php echo sanitize($user_data['user_profile_picture']); ?>" alt="profile_picture" class="profile_picture">
<ul>
<li class="li_un"><?php echo sanitize_ucfirst($user_data['user_level']); ?></li>
<li class="li_un"><?php echo sanitize_ucfirst($user_data['user_date']); ?></li>
</ul>
</div>
<div class="column_2">
<p><?php echo sanitize($user_data['user_profile_description']); ?></p>
</div>
</div>
</div>
</div>
<div class="content_container_wrapper">
<span class="primary">Last 5 topics</span>
<div class="content_container_margin_bottom">
<?php if ($latest_topics_by_user !== false) { ?>
<?php $i = 1; ?>
<?php foreach ($latest_topics_by_user as $latest_topic_by_user) { ?>
<ul>
<li class="li_un"><a class="link_secondary" href="index.php?section=view_topic&id=<?php echo sanitize($latest_topic_by_user['topic_id']);?>"><?php echo sanitize($i);?>.<?php echo sanitize_ucfirst($latest_topic_by_user['topic_title']);?></a></li>
<li class="li_un"><?php echo sanitize($latest_topic_by_user['topic_created']);?></li>
</ul>
<?php $i++; ?>
<?php } ?>
<?php } else { ?>
<p>This user has not created a topic yet.</p>
<?php } ?>
</div>
</div>
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
