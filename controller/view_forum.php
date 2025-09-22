<?php
//view_forum.php [Display of the topics in the corresponding forums with pagination.]
//View_forum_controller

class View_forum_controller {

function __construct($dbh, $header_template, $footer_template, $footer_template_minimal, $settings) {
$this->dbh = $dbh;
$this->header_template = $header_template;
$this->footer_template = $footer_template;
$this->footer_template_minimal = $footer_template_minimal;
$this->settings = $settings;
}

public function index() {

$settings = $this->settings;

$csrf_token = new CsrfToken($_SESSION);

require_once $this->header_template;

//ID of the forum.

$forum_id_get = '';
if (isset($_GET['id'])) {
$forum_id_get = (INT) $_GET['id'];
}

//ID of the forum.

//Check if the forum exists.

$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_forum_id($forum_id_get);
if ($forum_manager->validate_id_of_forum() === false) {
$message = new Message('The forum you are looking for does not exist.', 'msg_wrapper_mt_centered', 'index.php', 'Return to the home page');
require_once $this->header_template;
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}

//Check if the forum exists.

//Saving a topic and the opening post.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['create_topic'])) {
if ($csrf_token->validate_token('create_topic', $_POST['csrf_token'])) {

$topic_title_form = '';
if (isset($_POST['topic_title_form'])) {
$topic_title_form = trim($_POST['topic_title_form']);
}

$post_content_form = '';
if (isset($_POST['post_content_form'])) {
$post_content_form = trim($_POST['post_content_form']);
}

if (Auth::is_logged_in()) {
$user_id_create_topic = Auth::get_user_id();
}

try {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_forum_id($forum_id_get);
$topic_manager->set_topic_title($topic_title_form);
$topic_manager->set_user_id($user_id_create_topic);
$topic_manager->set_post_content($post_content_form);
if ($topic_manager->validate_topic() !== false) {
$result = $topic_manager->create_topic();
if ($result['success'] === true) {
$message = new Message('The topic has been successfully created.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($result['new_topic_id']), 'Continue to the new topic');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
} catch (Exception $e) {
include 'templates/messages/message_category_management.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=view_forum&id='. sanitize($category_id_get), 'Return to the requested forum');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Saving a topic and the opening post.


//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

try {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_forum_id($forum_id_get);
$total_records = $topic_manager->get_number_of_all_topics_by_forum();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->is_valid_page_number();
$offset = $pagination->get_offset();

//Pagination.

$topic_manager->set_entries_per_page($entries_per_page);
$topic_manager->set_offset($offset);
$rows = $topic_manager->get_all_topics_by_forum();
$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_forum_id($forum_id_get);
$forum = $forum_manager->show_forum();

include 'templates/frontend_templates/view_forum_template.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}

require_once $this->footer_template;

}

}
