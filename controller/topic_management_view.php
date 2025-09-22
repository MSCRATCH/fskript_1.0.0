<?php
//topic_management_view.php [View activity log.]
//Topic_management_view_controller

class Topic_management_view_controller {

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

//ID of the topic.

$topic_id_get = '';
if (isset($_GET['id'])) {
$topic_id_get = (INT) $_GET['id'];
}

//ID of the topic.

//Check if the topic exists.

$topic_manager = new TopicManager($this->dbh);
$topic_manager->set_topic_id($topic_id_get);
if ($topic_manager->validate_id_of_removed_topic() === false) {
$message = new Message('The topic you are looking for does not exist.', 'msg_wrapper_mt', 'index.php?section=topic_management', 'Return to topic management');
require_once 'themes/backend_template/backend_header.php';
echo $message->render_message();
require_once 'themes/backend_template/backend_footer.php';
exit();
}

//Check if the topic exists.

require_once 'themes/backend_template/backend_header.php';

try {
$post_manager = new PostManager($this->dbh);
$post_manager->set_topic_id($topic_id_get);
$rows = $post_manager->get_all_posts_by_removed_topic();
if ($rows === false) {
$message = new Message('An error occurred, such a topic does not exist.', 'msg_wrapper_mb');
echo $message->render_message();
} else {
include 'templates/backend_templates/topic_management_view_template.php';
}

require_once 'themes/backend_template/backend_footer.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}

}

}
