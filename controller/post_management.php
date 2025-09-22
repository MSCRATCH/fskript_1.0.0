<?php
//post_management.php [Topic management.]
//Post_management_controller

class Post_management_controller {

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

//Restore post.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['restore_post'])) {
if ($csrf_token->validate_token('restore_post', $_POST['csrf_token'])) {

$post_id_form = '';
if (isset($_POST['post_id_form'])) {
$post_id_form = (INT) $_POST['post_id_form'];
}

try {
$post_manager = new PostManager($this->dbh);
$post_manager->set_post_id($post_id_form);
if ($post_manager->restore_post()) {
$message = new Message('The post has been successfully restored.', 'msg_wrapper_mt', 'index.php?section=post_management', 'Return to post management');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=post_management', 'Return to post management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Restore post.

//Remove a post.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_post_permanent'])) {
if ($csrf_token->validate_token('remove_post_permanent', $_POST['csrf_token'])) {

$post_id_form = '';
if (isset($_POST['post_id_form'])) {
$post_id_form = (INT) $_POST['post_id_form'];
}

try {
$post_manager = new PostManager($this->dbh);
$post_manager->set_post_id($post_id_form);
if ($post_manager->remove_post_permanent()) {
$message = new Message('The post has been successfully removed.', 'msg_wrapper_mt', 'index.php?section=post_management', 'Return to post management');
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
$message = new Message('The session has expired for security reasons.', 'msg_wrapper_mt', 'index.php?section=post_management', 'Return to post management');
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}
}
}

//Remove a post.

//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

try {
$post_manager = new PostManager($this->dbh);
$total_records = $post_manager->get_number_of_all_posts_by_removed_status();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->is_valid_page_number();
$offset = $pagination->get_offset();

//Pagination.

$post_manager->set_entries_per_page($entries_per_page);
$post_manager->set_offset($offset);
$posts = $post_manager->get_all_removed_posts();
if ($posts === false) {
$message = new Message('There are currently no posts marked for removal.', 'msg_wrapper_mb');
echo $message->render_message();
} else {
include 'templates/backend_templates/post_management_template.php';
}

require_once 'themes/backend_template/backend_footer.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}
}

}
