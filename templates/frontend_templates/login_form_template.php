<?php  $token_1 = $csrf_token->generate_token('login'); ?>

<div class="wrapper_narrow_nbg_mt_150">
<div class="column">
<form method="post">
<label for="username_form">Username</label>
<input class="form_text_default" type="text" name="username_form" id="username_form" placeholder="username">
<label for="user_password_form">Username</label>
<input class="form_password_default" type="password" name="user_password_form" id="user_password_form" placeholder="**********">
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="login">Login</button>
</form>
<a href="index.php"><button class="btn_dynamic_mt_mb_10">Return to home page</button></a>
</div>
</div>
