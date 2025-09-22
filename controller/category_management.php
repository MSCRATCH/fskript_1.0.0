<?php
//category_management.php [category_management.]
//category_management_controller

class Category_management_controller {

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

//Remove a category, security question.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_category'])) {
if ($csrf_token->validate_token('remove_category', $_POST['csrf_token'])) {

$category_id_form = '';
if (isset($_POST['category_id_form'])) {
$category_id_form = (INT) $_POST['category_id_form'];
}

include 'templates/messages/message_remove_category.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=category_management', 'Return to category management');
echo $message->render_message();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a category, security question.

//Remove a category.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_category_confirm'])) {
if ($csrf_token->validate_token('remove_category_confirm', $_POST['csrf_token'])) {

$category_id_confirm_form = '';
if (isset($_POST['category_id_confirm_form'])) {
$category_id_confirm_form = (INT) $_POST['category_id_confirm_form'];
}

try {
$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_category_id($category_id_confirm_form);
$result = $forum_manager->remove_category();
if ($result === true) {
$message = new Message('The category has been successfully removed.', 'msg_wrapper_mt', 'index.php?section=category_management', 'Return to category management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_category_management.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=category_management', 'Return to category management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Remove a category.

//Save a category.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['submit_category'])) {
if ($csrf_token->validate_token('submit_category', $_POST['csrf_token'])) {

$category_name_form = '';
if (isset($_POST['category_name_form'])) {
$category_name_form = trim($_POST['category_name_form']);
}

try {
$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_category_name($category_name_form);
$result = $forum_manager->create_category();
if ($result === true) {
$message = new Message('The category has been successfully created.', 'msg_wrapper_mt', 'index.php?section=category_management', 'Return to category management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_category_management.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=category_management', 'Return tocategory management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Save a category.

//Update a category.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_category'])) {
if ($csrf_token->validate_token('update_category', $_POST['csrf_token'])) {

$category_id_update_form = '';
if (isset($_POST['category_id_update_form'])) {
$category_id_update_form = (INT) $_POST['category_id_update_form'];
}

$category_name_update_form = '';
if (isset($_POST['category_name_update_form'])) {
$category_name_update_form = trim($_POST['category_name_update_form']);
}

try {
$forum_manager = new ForumManager($this->dbh);
$forum_manager->set_category_id($category_id_update_form);
$forum_manager->set_category_name($category_name_update_form);
$result = $forum_manager->update_category();
if ($result === true) {
$message = new Message('The category has been updated successfully.', 'msg_wrapper_mt', 'index.php?section=category_management', 'Return to category management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_category_management.php';
require_once 'themes/backend_template/backend_footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=category_management', 'Return to category management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Update a category.

//Output of the categories.

$forum_manager = new ForumManager($this->dbh);
$rows = $forum_manager->show_categories();
if ($rows === false) {
$message = new Message('No categories has been created yet.', 'msg_wrapper_mb');
echo $message->render_message();
}
include 'templates/backend_templates/category_management_template.php';
require_once 'themes/backend_template/backend_footer.php';

//Output of the categories.

}

}
