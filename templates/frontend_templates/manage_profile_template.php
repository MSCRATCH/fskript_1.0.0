<?php  $token_1 = $csrf_token->generate_token('update_profile_description'); ?>
<?php  $token_2 = $csrf_token->generate_token('update_user_profile_picture'); ?>

<?php if ($error_container->has_errors()) { ?>
<div class="msg_wrapper_mt_centered">
<div class="msg_wrapper_mt_centered">
<span class="msg_span">System message</span>
<div class="msg_default">
<ul>
<li class="li_un">The upload was not successful.</li>
<?php $i = 1; ?>
<?php foreach ($error_container->get_errors() as $error) { ?>
<li class="li_un"><?php echo sanitize($i);?>.<?php echo sanitize($error);?></li>
<?php $i++; ?>
<?php } ?>
</ul>
<a href="index.php?section=manage_profile"><button class="msg_btn">Return to manage profile</button></a>
</div>
</div>
<?php require_once $footer_template_minimal; ?>
<?php exit(); ?>
<?php } ?>

<div class="template_wrapper">
<div class="template_row">
<div class="template_column_1">
<div class="content_container_wrapper">
<span class="primary">Editing user profile</span>
<div class="content_container_margin_bottom">The user profile can be edited in this area.</div>
</div>
<form method="post">
<label for="profile_description_form">Content of the profile description</label>
<textarea class="textarea_default" name="profile_description_form" id="profile_description_form" autocomplete="off"><?php echo sanitize($profile['user_profile_description']); ?></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_profile_description">Update profile description</button>
</form>
<form enctype="multipart/form-data" method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token_2;?>">
<input type="file" name="image" size="90" maxlength="255">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_user_profile_picture">Update profile picture</button>
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
