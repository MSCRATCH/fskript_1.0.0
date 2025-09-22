<?php
//view_login_protocol.php [Login protocol.]
//View_login_protocol_controller

class View_login_protocol_controller {

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

require_once 'themes/backend_template/backend_header.php';

//ID of the user.

$user_id_get = '';
if (isset($_GET['user_id'])) {
$user_id_get = (INT) $_GET['user_id'];
}

//ID of the user.

//Check if the user exists.

$user = new User($this->dbh);
$user->set_user_id($user_id_get);
if ($user->validate_id_of_user() === false) {
$message = new Message('The user you are looking for does not exist.', 'msg_wrapper_mt', 'index.php?section=user_management', 'Return to user management');
require_once 'themes/backend_template/backend_header.php';
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}

//Check if the forum exists.

//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

try {
$user = new User($this->dbh);
$user->set_user_id($user_id_get);
$total_records = $user->get_number_of_login_protocol_entries_by_user();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->is_valid_page_number();
$offset = $pagination->get_offset();

//Pagination.

$user->set_entries_per_page($entries_per_page);
$user->set_offset($offset);
$login_protocol_entries = $user->get_login_protocol_by_user();
if ($login_protocol_entries === false) {
$message = new Message('The users login protocol does not contain any entries.', 'msg_wrapper_mb');
echo $message->render_message();
} else {
include 'templates/backend_templates/view_login_protocol_template.php';
}

require_once 'themes/backend_template/backend_footer.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}
}

}
