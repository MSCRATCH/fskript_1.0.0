<?php  $token_1 = $csrf_token->generate_token('update_setting'); ?>

<div class="backend_wrapper">

<div class="content_container_wrapper">
<span class="primary">Settings of the <?php echo sanitize(name); ?> <?php echo sanitize(version); ?></span>
<div class="content_container_margin_bottom">This area contains the settings of the script.</div>
</div>

<?php
$theme_dir = 'themes/';
$themes = scandir($theme_dir);

$theme_options = '';
foreach ($themes as $theme) {
if (is_dir($theme_dir. $theme) && $theme != '.' && $theme != '..' && $theme != 'backend_template') {
$selected = ($settings['theme']['setting_value'] == $theme) ? 'selected' : '';
$theme_options .= '<option value="'. $theme. '"'. $selected. '>'. $theme. '</option>';
}
}
?>

<form method="post">
<label for="setting_value_form">Title of the page</label>
<input class="form_text_default" type="text" name="setting_value_form" id="setting_value_form" value="<?php echo sanitize_ucfirst($settings['site_title']['setting_value']);?>">
<input type="hidden" name="update_setting_id_form" value="<?php echo sanitize($settings['site_title']['setting_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_setting">Update setting</button>
</form>

<form method="post">
<label for="setting_value_form">Select theme</label>
<select class="select_bg" name="setting_value_form" id="setting_value_form">
<?php  echo $theme_options; ?>
</select>
<input type="hidden" name="update_setting_id_form" value="<?php echo sanitize($settings['theme']['setting_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_setting">Update setting</button>
</form>

<form method="post">
<label for="setting_value_form">Deactivate or activate the registration function</label>
<select class="select_bg" name="setting_value_form" id="setting_value_form">
<option value="<?php echo sanitize($settings['deactivate_registration']['setting_value']);?>"><?php echo sanitize($settings['deactivate_registration']['setting_value']);?></option>
<?php if ($settings['deactivate_registration']['setting_value'] !== 'activated') { ?>
<option value="activated">activated</option>
<?php } ?>
<?php if ($settings['deactivate_registration']['setting_value'] !== 'deactivated') { ?>
<option value="deactivated">deactivated</option>
<?php } ?>
<input type="hidden" name="update_setting_id_form" value="<?php echo sanitize($settings['deactivate_registration']['setting_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token_1;?>">
<button class="btn_dynamic_mt_mb_10" type="submit" name="update_setting">Update setting</button>
</select>
</form>
</div>
