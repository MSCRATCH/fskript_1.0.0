<?php
//topic_management.php [Topic management.]
//Topic_management_controller

class Topic_management_controller {

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

//Restore topic.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['restore_topic'])) {
if ($csrf_token->validate_token('restore_topic', $_POST['csrf_token'])) {

$topic_id_form = '';
if (isset($_POST['topic_id_form'])) {
$topic_id_form = (INT) $_POST['topic_id_form'];
}

try {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_form);
if ($topic_manager->restore_topic()) {
$message = new Message('The topic has been successfully restored.', 'msg_wrapper_mt', 'index.php?section=topic_management', 'Return to topic management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=topic_management', 'Return to topic management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Restore topic.

//Remove a topic.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_topic_permanent'])) {
if ($csrf_token->validate_token('remove_topic_permanent', $_POST['csrf_token'])) {

$topic_id_form = '';
if (isset($_POST['topic_id_form'])) {
$topic_id_form = (INT) $_POST['topic_id_form'];
}

try {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_form);
if ($topic_manager->remove_topic_permanent()) {
$message = new Message('The topic has been successfully removed.', 'msg_wrapper_mt', 'index.php?section=topic_management', 'Return to topic management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=topic_management', 'Return to topic management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Remove a topic.

//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

try {
$topic_manager = new TopicManager($this->dbh);
$total_records = $topic_manager->get_number_of_all_topics_by_removed_status();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->is_valid_page_number();
$offset = $pagination->get_offset();

//Pagination.

$topic_manager->set_entries_per_page($entries_per_page);
$topic_manager->set_offset($offset);
$topics = $topic_manager->get_all_removed_topics();
if ($topics === false) {
$message = new Message('There are currently no topics marked for removal.', 'msg_wrapper_mb');
echo $message->render_message();
} else {
include 'templates/backend_templates/topic_management_template.php';
}

require_once 'themes/backend_template/backend_footer.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}
}

}
