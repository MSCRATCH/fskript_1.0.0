<?php
//view_topic.php [Display of the topics in the corresponding categories with pagination.]
//View_topic_controller

class View_topic_controller {

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

//ID of the topic.

$topic_id_get = '';
if (isset($_GET['id'])) {
$topic_id_get = (INT) $_GET['id'];
}

//ID of the topic.

//Check if the topic exists.

$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_get);
if ($topic_manager->validate_id_of_topic() === false) {
$message = new Message('The topic you are looking for does not exist.', 'msg_wrapper_mt_centered', 'index.php', 'Return to the home page');
require_once $this->header_template;
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}

//Check if the topic exists.

//Specify how many records should be displayed on each page.

$entries_per_page = 10;

//Specify how many records should be displayed on each page.

//Check if the category exists.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['reply_topic'])) {
if ($csrf_token->validate_token('reply_topic', $_POST['csrf_token'])) {

$post_content_form = '';
if (isset($_POST['post_content_form'])) {
$post_content_form = trim($_POST['post_content_form']);
}

if (Auth::is_logged_in()) {
$user_id_reply_topic = Auth::get_user_id();
}

try {
$post_manager = new PostManager($this->dbh);
$post_manager->set_topic_id($topic_id_get);
$post_manager->set_user_id($user_id_reply_topic);
$post_manager->set_post_content($post_content_form);
if ($post_manager->validate_post() !== false) {
$total_records_before = $post_manager->get_number_of_all_posts_by_topic();
$last_page = ceil(($total_records_before + 1) / $entries_per_page);
$result = $post_manager->create_post();
if ($result === true) {
$message = new Message('The post has been successfully created.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get). '&page='. sanitize($last_page), 'Return to the homepage');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to category management');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Check if the category exists.

try {
$post_manager = new PostManager($this->dbh);
$post_manager->set_topic_id($topic_id_get);
$total_records = $post_manager->get_number_of_all_posts_by_topic();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->is_valid_page_number();
$offset = $pagination->get_offset();

//Pagination.

$post_manager->set_entries_per_page($entries_per_page);
$post_manager->set_offset($offset);
$rows = $post_manager->get_all_posts_by_topic();

if ($rows !== false) {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_get);
$topic = $topic_manager->show_topic();
include 'templates/frontend_templates/view_topic_template.php';
} else {
$message = new Message('This topic contains no posts.', 'msg_wrapper_mt_centered', 'index.php', 'Return to the homepage');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}


} catch (Exception $e) {
include 'templates/messages/message.php';
}

require_once $this->footer_template;

}

}
