<?php if ($settings['deactivate_registration']['setting_value'] === 'deactivated') { ?>
<div class="msg_wrapper_mt_centered">
<span class="msg_span">System message</span>
<div class="msg_default">
<p>Registration is currently disabled.</p>
<a href="index.php?section=register"><button class="msg_btn">Return to register</button></a>
</div>
</div>
<?php require_once $footer_template_minimal; ?>
<?php exit(); ?>
<?php } ?>

<?php  $token_1 = $csrf_token->generate_token('register'); ?>

<?php if ($error_container->has_errors()) { ?>
<div class="msg_wrapper_mt_centered">
<div class="msg_wrapper_mt_centered">
<span class="msg_span">System message</span>
<div class="msg_default">
<ul>
<li class="list_unstyled">The registration was not successful.</li>
<?php $i = 1; ?>
<?php foreach ($error_container->get_errors() as $error) { ?>
<li class="list_unstyled"><?php echo sanitize($i);?>.<?php echo sanitize($error);?></li>
<?php $i++; ?>
<?php } ?>
</ul>
<a href="index.php?section=register"><button class="msg_btn">Return to register</button></a>
</div>
</div>
<?php require_once $footer_template_minimal; ?>
<?php exit(); ?>
<?php } ?>

<div class="wrapper_narrow_nbg_mt_50">
<form method="post">
<label for="username_form">Username</label>
<input class="form_text_default" type="text" name="username_form" id="username_form" placeholder="username">
<label for="password_form">Password</label>
<input class="form_password_default" type="password" name="password_form" id="password_form" placeholder="**********">
<label for="user_password_confirm_form">Password comparison</label>
<input class="form_password_default" type="password" name="user_password_confirm_form" id="user_password_confirm_form" placeholder="**********">
<label for="user_email_form">E-mail address</label>
<input class="form_text_default" type="text" name="user_email_form" id="user_email_form" placeholder="**********">
<p class="p_ml">What is something nobody wants to be, but everyone will be?</p>
<label for="security_question_answer_form">Security question</label>
<input class="form_text_default" type="text" name="security_question_answer_form" id="security_question_answer_form" placeholder="***********">
<p class="p_ml">By registering you agree to the terms of use.</p>
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="register">Register</button>
</form>
<a href="index.php"><button class="btn_dynamic_mt_mb_10">Return to home page</button></a>
</div>
