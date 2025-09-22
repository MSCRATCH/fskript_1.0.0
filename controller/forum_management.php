<?php
//forum_management.php [forum_management.]
//Forum_management_controller

class Forum_management_controller {

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

//Save a forum.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['submit_forum'])) {
if ($csrf_token->validate_token('submit_forum', $_POST['csrf_token'])) {

$category_id_form = '';
if (isset($_POST['category_id_form'])) {
$category_id_form  = (INT) $_POST['category_id_form'];
}

$forum_name_form = '';
if (isset($_POST['forum_name_form'])) {
$forum_name_form = trim($_POST['forum_name_form']);
}

$forum_description_form = '';
if (isset($_POST['forum_description_form'])) {
$forum_description_form = trim($_POST['forum_description_form']);
}

try {
$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_category_id($category_id_form);
$forum_manager->set_forum_name($forum_name_form);
$forum_manager->set_forum_description($forum_description_form);
$result = $forum_manager->create_forum();
if ($result === true) {
$message = new Message('The forum has been successfully created.', 'msg_wrapper_mb', 'index.php?section=forum_management', 'Return to forum management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_forum_management.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mb', 'index.php?section=forum_management', 'Return to forum management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Save a forum.

//Specify how many records should be displayed on each page.

$entries_per_page = 5;

//Specify how many records should be displayed on each page.

try {
$forum_manager = new ForumManager($this->dbh);
$total_records = $forum_manager->get_number_of_forums();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->is_valid_page_number();
$offset = $pagination->get_offset();

//Pagination.

$forum_manager->set_entries_per_page($entries_per_page);
$forum_manager->set_offset($offset);
$forums = $forum_manager->get_all_forums();
$categories = $forum_manager->show_categories();
if ($forums === false) {
$message = new Message('Currently no forum has been created.', 'msg_wrapper_mb');
echo $message->render_message();
}

if ($categories === false) {
$message = new Message('No category has been created yet. Forums can only be created if a category has been created beforehand.', 'msg_wrapper_mb');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
} else {
include 'templates/backend_templates/forum_management_template.php';
}


require_once 'themes/backend_template/backend_footer.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}
}

}
