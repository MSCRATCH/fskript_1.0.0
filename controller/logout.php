<?php
//logout.php [Logout the respective user.]
//Logout_controller

class Logout_controller {

function __construct($dbh, $header_template, $footer_template, $footer_template_minimal, $settings) {
$this->dbh = $dbh;
$this->header_template = $header_template;
$this->footer_template = $footer_template;
$this->footer_template_minimal = $footer_template_minimal;
$this->settings = $settings;
}

public function index() {

if (! Auth::is_logged_in()) {
header('Location: index.php');
}

$settings = $this->settings;

unset($_SESSION['logged_in']['username']);
unset($_SESSION['logged_in']['user_level']);
unset($_SESSION['logged_in']['user_id']);
require_once $this->header_template;
$message = new Message('You have been successfully logged out.', 'msg_wrapper_mt_centered', 'index.php?section=categories', 'Back to homepage');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}

}
