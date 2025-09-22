<?php
//forum.php [Output of categories.]
//Forum_controller

class Forum_controller {

function __construct($dbh, $header_template, $footer_template, $footer_template_minimal, $settings) {
$this->dbh = $dbh;
$this->header_template = $header_template;
$this->footer_template = $footer_template;
$this->footer_template_minimal = $footer_template_minimal;
$this->settings = $settings;
}

public function index() {

$settings = $this->settings;

require_once $this->header_template;


$forum_manager = new ForumManager($this->dbh);
$rows = $forum_manager->get_all_categories_and_forums();
include 'templates/frontend_templates/forum_template.php';

require_once $this->footer_template;
}

}
