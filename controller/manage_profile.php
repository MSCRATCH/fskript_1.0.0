<?php
//manage_profile.php [Manage profile]
//Manage_profile_controller

class Manage_profile_controller {

function __construct($dbh, $header_template, $footer_template, $footer_template_minimal, $settings) {
$this->dbh = $dbh;
$this->header_template = $header_template;
$this->footer_template = $footer_template;
$this->footer_template_minimal = $footer_template_minimal;
$this->settings = $settings;
}

public function index() {
if (! Auth::is_logged_in()) {
header('Location: index.php?section=login');
exit();
}

$settings = $this->settings;

$csrf_token = new CsrfToken($_SESSION);

$error_container = new ErrorContainer();

$footer_template_minimal = $this->footer_template_minimal;

require_once $this->header_template;

//ID of the user requesting the page.

if (Auth::is_logged_in()) {
$user_id_profile = Auth::get_user_id();
}

//ID of the user requesting the page.

//Update profile description.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_profile_description'])) {
if ($csrf_token->validate_token('update_profile_description', $_POST['csrf_token'])) {

$profile_description_form = '';
if (isset($_POST['profile_description_form'])) {
$profile_description_form = trim($_POST['profile_description_form']);
}

try {
$profile_manager = new ProfileManager($this->dbh);
$profile_manager->set_user_id($user_id_profile);
$profile_manager->set_user_profile_description($profile_description_form);
$result = $profile_manager->update_user_profile();
if ($result === true) {
$message = new Message('The profile description has been successfully updated.', 'msg_wrapper_mt_centered', 'index.php?section=manage_profile', 'Return to manage profile');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_forum_management.php';
require_once $this->footer_template_minimal;
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=manage_profile', 'Return to manage profile');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Update profile description.

//Update profile picture.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_user_profile_picture'])) {
if ($csrf_token->validate_token('update_user_profile_picture', $_POST['csrf_token'])) {

try {
$file_uploader = new FileUploader($this->dbh);
$file_uploader->set_user_id($user_id_profile);
$file_uploader->set_error_container($error_container);
$file_uploader->set_image($_FILES);
$result = $file_uploader->upload();
if ($result === true) {
$message = new Message('The profile picture has been successfully updated.', 'msg_wrapper_mt_centered', 'index.php?section=manage_profile', 'Return to manage profile');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_forum_management.php';
require_once $this->footer_template_minimal;
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=manage_profile', 'Return to manage profile');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Update profile picture.

//Output of the profile.

$profile_manager = new ProfileManager($this->dbh);
$profile_manager->set_user_id($user_id_profile);
$profile = $profile_manager->get_user_profile();
include 'templates/frontend_templates/manage_profile_template.php';
require_once $this->footer_template;

//Output of the profile.

}

}
