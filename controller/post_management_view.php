<?php
//post_management_view.php [View activity log.]
//Post_management_view_controller

class Post_management_view_controller {

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

//ID of the post.

$post_id_get = '';
if (isset($_GET['id'])) {
$post_id_get = (INT) $_GET['id'];
}

//ID of the post.

//Check if the post exists.

$post_manager = new PostManager($this->dbh);
$post_manager->set_post_id($post_id_get);
if ($post_manager->validate_id_of_removed_post() === false) {
$message = new Message('The post you are looking for does not exist.', 'msg_wrapper_mt', 'index.php?section=post_management', 'Return to post management');
require_once 'themes/backend_template/backend_header.php';
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}

//Check if the post exists.

require_once 'themes/backend_template/backend_header.php';

try {
$post_manager = new PostManager($this->dbh);
$post_manager->set_post_id($post_id_get);
$row = $post_manager->show_removed_post();
if ($row === false) {
$message = new Message('An error occurred, such a post does not exist.', 'msg_wrapper_mb');
echo $message->render_message();
} else {
include 'templates/backend_templates/post_management_view_template.php';
}

require_once 'themes/backend_template/backend_footer.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}

}

}
