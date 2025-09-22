<?php
//login.php [Login the respective user.]
//Login_controller

class Login_controller {

function __construct($dbh, $header_template, $footer_template, $footer_template_minimal, $settings) {
$this->dbh = $dbh;
$this->header_template = $header_template;
$this->footer_template = $footer_template;
$this->footer_template_minimal = $footer_template_minimal;
$this->settings = $settings;
}

public function index() {
if (Auth::is_logged_in()) {
header('Location: index.php');
exit();
}

$settings = $this->settings;

$csrf_token = new CsrfToken($_SESSION);

require_once $this->header_template;

if (isset($_POST['csrf_token'])) {
if (isset($_POST['login'])) {
if ($csrf_token->validate_token('login', $_POST['csrf_token'])) {

$username_form = '';
if (isset($_POST['username_form'])) {
$username_form = trim($_POST['username_form']);
}

$user_password_form = '';
if (isset($_POST['user_password_form'])) {
$user_password_form = trim($_POST['user_password_form']);
}

try {
$login = new User($this->dbh);
$login->set_username($username_form);
$login->set_user_password($user_password_form);

if ($login->login()) {
$message = new Message('You have been successfully logged in.', 'msg_wrapper_mt_centered', 'index.php?section=categories', 'Back to homepage');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_login.php';
require_once $this->footer_template_minimal;
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=login', 'Return to login');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

require_once 'templates/frontend_templates/login_form_template.php';

require_once $this->footer_template_minimal;
}

}
