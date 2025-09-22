<?php
//manage_forum.php [manage_forum.php]
//Manage_forum_controller

class Manage_forum_controller {

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

//ID of the forum.

$forum_id_get = '';
if (isset($_GET['forum_id'])) {
$forum_id_get = (INT) $_GET['forum_id'];
}

//ID of the forum.

//Check if the forum exists.

$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_forum_id($forum_id_get);
if ($forum_manager->validate_id_of_forum() === false) {
$message = new Message('The forum you are looking for does not exist.', 'msg_wrapper_mt', 'index.php?section=forum_management', 'Return to forum_management');
require_once 'themes/backend_template/backend_header.php';
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}

//Check if the forum exists.

//Remove a forum, security question.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_forum'])) {
if ($csrf_token->validate_token('remove_forum', $_POST['csrf_token'])) {


include 'templates/messages/message_remove_forum.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=manage_forum&forum_id='. sanitize($forum_id_get), 'Return to the accessed forum');
echo $message->render_message();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a category, security question.

//Remove a forum.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_forum_confirm'])) {
if ($csrf_token->validate_token('remove_forum_confirm', $_POST['csrf_token'])) {

try {
$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_forum_id($forum_id_get);
$result = $forum_manager->remove_forum();
if ($result === true) {
$message = new Message('The Forum has been successfully removed.', 'msg_wrapper_mt', 'index.php?section=forum_management', 'Return to forum management');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=manage_forum&forum_id='. sanitize($forum_id_get), 'Return to the accessed forum');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Remove a forum.

//Update a forum.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_forum'])) {
if ($csrf_token->validate_token('update_forum', $_POST['csrf_token'])) {

$category_id_form = '';
if (isset($_POST['category_id_form'])) {
$category_id_form = (INT) $_POST['category_id_form'];
}

$forum_name_update_form = '';
if (isset($_POST['forum_name_update_form'])) {
$forum_name_update_form = trim($_POST['forum_name_update_form']);
}

$forum_description_update_form = '';
if (isset($_POST['forum_description_update_form'])) {
$forum_description_update_form = trim($_POST['forum_description_update_form']);
}

try {
$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_forum_id($forum_id_get);
$forum_manager->set_forum_name($forum_name_update_form);
$forum_manager->set_forum_description($forum_description_update_form);
$forum_manager->set_category_id($category_id_form);
$result = $forum_manager->update_forum();
if ($result === true) {
$message = new Message('The forum has been updated successfully.', 'msg_wrapper_mt', 'index.php?section=manage_forum&forum_id='. sanitize($forum_id_get), 'Return to the accessed forum');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=manage_forum&forum_id='. sanitize($forum_id_get), 'Return to the accessed forum');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Update a forum.

//Output of the forums.

$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_forum_id($forum_id_get);
$forums = $forum_manager->show_forum();
$categories = $forum_manager->show_categories();
if ($categories === false) {
$message = new Message('Categories must first be created before forums can be added.');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
} else {
include 'templates/backend_templates/manage_forum_template.php';
require_once 'themes/backend_template/backend_footer.php';
}

//Output of the forums.

}

}
