<?php
//profile.php [Output of the respective profile.]
//Profile_controller

class Profile_controller {

function __construct($dbh, $header_template, $footer_template, $footer_template_minimal, $settings) {
$this->dbh = $dbh;
$this->header_template = $header_template;
$this->footer_template = $footer_template;
$this->footer_template_minimal = $footer_template_minimal;
$this->settings = $settings;
}

public function index() {

$settings = $this->settings;

require_once $this->header_template;

//User ID.

$user_id_get = '';
if (isset($_GET['id'])) {
$user_id_get = (INT) $_GET['id'];
}

//User ID.

//Check if a user exists.

$user = new User($this->dbh);
$user->set_user_id($user_id_get);
if ($user->validate_id_of_user() === false) {
$message = new Message('The user profile does not exist.', 'msg_wrapper_mt_centered', 'index.php', 'Return to the homepage');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}

//Check if a user exists.

//Output of the respective profile.

$profile_manager = new ProfileManager($this->dbh);
$profile_manager->set_user_id($user_id_get);
$user_data = $profile_manager->get_user_profile();
$latest_topics_by_user = $profile_manager->get_latest_topics_by_user();

if ($user_data === false) {
$message = new Message('The user profile does not exist.', 'msg_wrapper_mt_centered', 'index.php', 'Return to the homepage');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
} else {
include 'templates/frontend_templates/profile_template.php';
}

require_once $this->footer_template;

//Output of the respective profile.
}

}
