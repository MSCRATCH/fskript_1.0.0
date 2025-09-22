<?php
//view_activity_log.php [View activity log.]
//View_activity_log_controller

class View_activity_log_controller {

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

require_once 'themes/backend_template/backend_header.php';


//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

try {
$log_manager = new LogManager($this->dbh);
$total_records = $log_manager->get_number_of_activity_log_entries();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->is_valid_page_number();
$offset = $pagination->get_offset();

//Pagination.

$log_manager->set_entries_per_page($entries_per_page);
$log_manager->set_offset($offset);
$activity_entries = $log_manager->get_activity_log();
if ($activity_entries === false) {
$message = new Message('The activity log does not contain any entries.', 'msg_wrapper_mb');
echo $message->render_message();
} else {
include 'templates/backend_templates/view_activity_template.php';
}

require_once 'themes/backend_template/backend_footer.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}

}

}
