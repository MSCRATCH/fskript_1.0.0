<?php
//manage_post.php [Manage post]
//Manage_post_controller

class Manage_post_controller {

function __construct($dbh, $header_template, $footer_template, $footer_template_minimal, $settings) {
$this->dbh = $dbh;
$this->header_template = $header_template;
$this->footer_template = $footer_template;
$this->footer_template_minimal = $footer_template_minimal;
$this->settings = $settings;
}

public function index() {
if (! Auth::is_administrator_or_moderator()) {
header('Location: index.php?section=login');
exit();
}

$settings = $this->settings;

$csrf_token = new CsrfToken($_SESSION);

require_once $this->header_template;

//ID of the topic.

$topic_id_get = '';
if (isset($_GET['topic_id'])) {
$topic_id_get = (INT) $_GET['topic_id'];
}

//ID of the topic.

//ID of the post.

$post_id_get = '';
if (isset($_GET['post_id'])) {
$post_id_get = (INT) $_GET['post_id'];
}

//ID of the post.

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

//Check if the post exists.

$post_manager = new PostManager($this->dbh);
$post_manager->set_post_id($post_id_get);
if ($post_manager->validate_id_of_post() === false) {
$message = new Message('The post you are looking for does not exist.', 'msg_wrapper_mt_centered', 'index.php', 'Return to the home page');
require_once $this->header_template;
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}

//Check if the post exists.

//Remove a post.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_post'])) {
if ($csrf_token->validate_token('remove_post', $_POST['csrf_token'])) {

try {
$post_manager = new PostManager($this->dbh);
$post_manager->set_topic_id($topic_id_get);
$post_manager->set_post_id($post_id_get);
$result = $post_manager->remove_post();
if ($result === true) {
$message = new Message('The post is marked for removal and will not be displayed until it is finally removed.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to the accessed topic');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to the accessed topic');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Remove a post.

//Update a post.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_post'])) {
if ($csrf_token->validate_token('update_post', $_POST['csrf_token'])) {

$post_content_form = '';
if (isset($_POST['post_content_form'])) {
$post_content_form = trim($_POST['post_content_form']);
}

try {
$post_manager = new PostManager($this->dbh);
$post_manager->set_post_id($post_id_get);
$post_manager->set_post_content($post_content_form);
$result = $post_manager->update_post();
if ($result === true) {
$message = new Message('The post has been updated successfully.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to to the updated post');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to the accessed topic');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Update a post.

//Output of the post.

$post_manager = new PostManager($this->dbh);
$post_manager->set_post_id($post_id_get);
$post = $post_manager->show_post();
include 'templates/frontend_templates/manage_post_template.php';
require_once $this->footer_template;

//Output of the post.

}

}
