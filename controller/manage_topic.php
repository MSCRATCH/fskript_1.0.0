<?php
//manage_topic.php [Manage topic]
//Manage_topic_controller

class Manage_topic_controller {

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

//ID of the forum.

$forum_id_get = '';
if (isset($_GET['forum_id'])) {
$forum_id_get = (INT) $_GET['forum_id'];
}

//ID of the forum.

//ID of the topic.

$topic_id_get = '';
if (isset($_GET['topic_id'])) {
$topic_id_get = (INT) $_GET['topic_id'];
}

//ID of the topic.

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

//Remove a topic.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_topic'])) {
if ($csrf_token->validate_token('remove_topic', $_POST['csrf_token'])) {

try {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_get);
$result = $topic_manager->remove_topic();
if ($result === true) {
$message = new Message('The topic is marked for removal and will not be displayed until it is finally removed.', 'msg_wrapper_mt_centered', 'index.php?section=view_forum&id='. sanitize($forum_id_get), 'Return to the accessed forum');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=view_forum&id='. sanitize($forum_id_get), 'Return to the accessed forum');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Remove a topic.

//Update a topic.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_topic'])) {
if ($csrf_token->validate_token('update_topic', $_POST['csrf_token'])) {

$forum_id_form = '';
if (isset($_POST['forum_id_form'])) {
$forum_id_form = (INT) $_POST['forum_id_form'];
}

$topic_title_form = '';
if (isset($_POST['topic_title_form'])) {
$topic_title_form = trim($_POST['topic_title_form']);
}

try {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_get);
$topic_manager->set_forum_id($forum_id_form);
$topic_manager->set_topic_title($topic_title_form);
$result = $topic_manager->update_topic();
if ($result === true) {
$message = new Message('The topic has been updated successfully.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to to the updated topic');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=view_forum&id='. sanitize($forum_id_get), 'Return to the accessed forum');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Update a topic.

//Lock a topic.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['lock_topic'])) {
if ($csrf_token->validate_token('lock_topic', $_POST['csrf_token'])) {

try {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_get);
$result = $topic_manager->lock_topic();
if ($result === true) {
$message = new Message('The topic has been successfully locked.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to to the locked topic');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to to the locked topic');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Lock a topic.

//Unlock a topic.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['unlock_topic'])) {
if ($csrf_token->validate_token('unlock_topic', $_POST['csrf_token'])) {

try {
$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_get);
$result = $topic_manager->unlock_topic();
if ($result === true) {
$message = new Message('The topic has been successfully unlocked.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to to the locked topic');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt_centered', 'index.php?section=view_topic&id='. sanitize($topic_id_get), 'Return to to the locked topic');
echo $message->render_message();
require_once $this->footer_template_minimal;
exit();
}
}
}

//Unlock a topic.

//Output of the topic.

$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_get);
$topic = $topic_manager->show_topic();
$forum_manager = new ForumManager($this->dbh);
$forums = $forum_manager->show_forums();
include 'templates/frontend_templates/manage_topic_template.php';
require_once $this->footer_template;

//Output of the topic.

}

}
