<?php
//Router.php [Router of the script.]
//pathologicalplay [MMXXV]

class Router {
private $dbh;
private $settings;
private $header_template;
private $footer_template;
private $footer_template_minimal;
private $allowed_sections;

function __construct() {
$this->dbh = new Dbh();
$setting_manager = new SettingManager($this->dbh);
$this->settings = $setting_manager->get_settings();
$active_theme = sanitize($this->settings['theme']['setting_value']);
$theme_dir = 'themes/';
$this->header_template = $theme_dir. $active_theme. '/header.php';
$this->footer_template = $theme_dir. $active_theme. '/footer.php';
$this->footer_template_minimal = $theme_dir. $active_theme. '/footer_minimal.php';
$this->allowed_sections = array(
'login',
'logout',
'register',
'profile',
'view_forum',
'view_topic',
'forum_management',
'manage_forum',
'category_management',
'setting_management',
'user_management',
'view_login_protocol',
'view_activity_log',
'manage_topic',
'manage_post',
'topic_management',
'topic_management_view',
'post_management',
'post_management_view',
'manage_profile',
);
}

private function update_users_last_activity() {
if (Auth::is_logged_in()) {
$user_front_controller = new User($this->dbh);
$user_id_front_controller = Auth::get_user_id();
$user_front_controller->set_user_id($user_id_front_controller);
$user_front_controller->update_last_activity();
}
}

private function check_if_user_is_activated() {
if (Auth::is_not_activated()) {
require_once $header_template;
include 'templates/messages/message_not_activated.php';
require_once $footer_template_minimal;
exit();
}
}

public function route() {

$this->update_users_last_activity();
$this->check_if_user_is_activated();

$section = $_GET['section'] ?? 'forum';
$section = sanitize($section);
if (in_array($section, $this->allowed_sections)) {
$file_name = $section. '.php';
$controller_path = 'controller/'. $section. '.php';
if (file_exists($controller_path)) {
require_once $controller_path;
}
$controller_name = ucfirst($section). '_controller';
$controller = new $controller_name($this->dbh, $this->header_template, $this->footer_template, $this->footer_template_minimal, $this->settings);
$controller->index();
} else {
require_once 'controller/forum.php';
$controller = new Forum_controller($this->dbh, $this->header_template, $this->footer_template, $this->footer_template_minimal, $this->settings);
$controller->index();
}
}


}
