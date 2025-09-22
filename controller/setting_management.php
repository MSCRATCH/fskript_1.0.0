<?php
//setting_management.php [Setting Management.]
//Setting_management_controller

class Setting_management_controller {

function __construct($dbh, $header_template, $footer_template, $footer_template_minimal, $settings) {
$this->dbh = $dbh;
$this->header_template = $header_template;
$this->footer_template = $footer_template;
$this->footer_template_minimal = $footer_template_minimal;
$this->settings = $settings;
}

public function index() {
if (! Auth::is_administrator()) {
header('Location: index.php?section=login');
exit();
}

$settings = $this->settings;

$csrf_token = new CsrfToken($_SESSION);

require_once 'themes/backend_template/backend_header.php';


//Update a Setting.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_setting'])) {
if ($csrf_token->validate_token('update_setting', $_POST['csrf_token'])) {

$update_setting_id_form = '';
if (isset($_POST['update_setting_id_form'])) {
$update_setting_id_form = (INT) $_POST['update_setting_id_form'];
}

$setting_value_form = '';
if (isset($_POST['setting_value_form'])) {
$setting_value_form = trim($_POST['setting_value_form']);
}

try {
$setting_manager = new SettingManager($this->dbh);
$setting_manager->set_setting_id($update_setting_id_form);
$setting_manager->set_setting_value($setting_value_form);
$result = $setting_manager->update_setting();
if ($result === true) {
$message = new Message('The setting has been updated successfully.', 'msg_wrapper_mt', 'index.php?section=setting_management', 'Return to setting management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_setting_management.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=setting_management', 'Return to setting management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Update a Setting.

//Output of the settings.

$setting_manager = new SettingManager($this->dbh);
$settings = $setting_manager->get_settings();
include 'templates/backend_templates/setting_management_template.php';
require_once 'themes/backend_template/backend_footer.php';

//Output of the settings.

}

}
