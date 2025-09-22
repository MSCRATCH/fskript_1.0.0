<?php
//PostManager.php [Class to manage the posts.]
//pathologicalplay [MMXXV]

class PostManager {

private $dbh;
private $post_id;
private $topic_id;
private $user_id;
private $post_content;
private $entries_per_page;
private $offset;

function __construct(Dbh $dbh) {
$this->dbh = $dbh;
}

//Set methods.

public function set_post_id($post_id) {
$this->post_id = $post_id;
}

public function set_topic_id($topic_id) {
$this->topic_id = $topic_id;
}

public function set_user_id($user_id) {
$this->user_id = $user_id;
}

public function set_post_content($post_content) {
$this->post_content = $post_content;
}

public function set_entries_per_page($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function set_offset($offset) {
$this->offset = $offset;
}

//Set methods.

//Check if the post ID exists.

public function validate_id_of_post() {
$sql = "SELECT COUNT(*) AS post_count FROM posts WHERE post_id = ? AND is_removed = 0";
$result = $this->dbh->check_if_id_exists($sql, "i", $this->post_id);
if ($result > 0) {
return true;
} else {
return false;
}
}

public function validate_id_of_removed_post() {
$sql = "SELECT COUNT(*) AS post_count FROM posts WHERE post_id = ? AND is_removed = 1";
$result = $this->dbh->check_if_id_exists($sql, "i", $this->post_id);
if ($result > 0) {
return true;
} else {
return false;
}
}

//Check if the post ID exists.

//Total number of posts for pagination.

private function get_number_of_all_posts_by_topic_db() {
$sql = "SELECT COUNT(*) AS count FROM posts WHERE topic_id = ? AND is_removed = 0";
$result = $this->dbh->get_data($sql, "i", $this->topic_id);
return $result['count'];
}

public function get_number_of_all_posts_by_topic() {
$result = $this->get_number_of_all_posts_by_topic_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

private function get_number_of_all_posts_by_removed_status_db() {
$is_removed = 1;
$sql = "SELECT COUNT(*) AS count FROM posts WHERE is_removed = ?";
$result = $this->dbh->get_data($sql, "i", $is_removed);
return $result['count'];
}

public function get_number_of_all_posts_by_removed_status() {
$result = $this->get_number_of_all_posts_by_removed_status_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Total number of posts for pagination.

//Display of the posts in the corresponding topic with pagination.

private function get_all_posts_by_topic_db() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$sql = "SELECT posts.post_id, posts.post_content, posts.post_created, topics.topic_title, users.user_id, users.username, users.user_level, users.last_activity,
TIMESTAMPDIFF(MINUTE,last_activity,NOW()) AS last_activity_minutes, user_profiles.user_profile_picture FROM posts INNER JOIN topics ON posts.topic_id = topics.topic_id INNER JOIN users ON posts.user_id = users.user_id INNER JOIN user_profiles ON posts.user_id = user_profiles.user_id WHERE posts.topic_id = ? AND posts.is_removed = 0 ORDER BY posts.post_created ASC LIMIT $offset, $entries_per_page";
return $result = $this->dbh->get_all_data_by_id($sql, "i", $this->topic_id);
}

public function get_all_posts_by_topic() {
$result = $this->get_all_posts_by_topic_db();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Display of the posts in the corresponding topic with pagination.

//Display of the posts in the corresponding removed topic without pagination.

private function get_all_posts_by_removed_topic_db() {
$sql = "SELECT posts.post_id, posts.post_content, posts.post_created, topics.topic_title, topics.is_removed, users.user_id, users.username, users.user_level, user_profiles.user_profile_picture FROM posts INNER JOIN topics ON posts.topic_id = topics.topic_id INNER JOIN users ON posts.user_id = users.user_id INNER JOIN user_profiles ON posts.user_id = user_profiles.user_id WHERE posts.topic_id = ? AND topics.is_removed = 1 ORDER BY posts.post_created ASC";
return $result = $this->dbh->get_all_data_by_id($sql, "i", $this->topic_id);
}

public function get_all_posts_by_removed_topic() {
$result = $this->get_all_posts_by_removed_topic_db();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Display of the posts in the corresponding removed topic without pagination.

//Display of the removed posts with pagination.

private function get_all_removed_posts_db() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$sql = "SELECT posts.post_id, posts.post_content, posts.post_created, topics.topic_id, topics.topic_title, users.user_id, users.username, users.user_level FROM posts INNER JOIN topics ON posts.topic_id = topics.topic_id INNER JOIN users ON posts.user_id = users.user_id WHERE posts.is_removed = 1 ORDER BY posts.post_created ASC LIMIT $offset, $entries_per_page";
return $result = $this->dbh->get_all_data($sql);
}

public function get_all_removed_posts() {
$result = $this->get_all_removed_posts_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Display of the removed posts with pagination.

//validation of the post.

public function validate_post() {
if (empty($this->post_content) OR empty($this->topic_id) OR empty($this->user_id)) {
return false;
}
}

//validation of the post.

//Output of post.

private function show_post_db() {
$sql = "SELECT post_content FROM posts WHERE post_id = ? AND is_removed != 1";
return $result = $this->dbh->get_data($sql, "i", $this->post_id);
}

public function show_post() {
$result = $this->show_post_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of post.

//Output of removed post.

private function show_removed_post_db() {
$sql = "SELECT posts.post_id, posts.post_content, posts.post_created, topics.topic_id, topics.topic_title, users.user_id, users.username, users.user_level FROM posts INNER JOIN topics ON posts.topic_id = topics.topic_id INNER JOIN users ON posts.user_id = users.user_id WHERE posts.post_id = ? AND posts.is_removed = 1";
return $result = $this->dbh->get_data($sql, "i", $this->post_id);
}

public function show_removed_post() {
$result = $this->show_removed_post_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of removed post.

//Check if the topic is locked.

private function is_topic_locked() {
$sql = "SELECT is_locked FROM topics WHERE topic_id = ?";
$result = $this->dbh->get_single_value($sql, "i", $this->topic_id);
if ($result === 1) {
return true;
} else {
return false;
}
}

//Check if the topic is locked.

//Saving a post.

private function create_post_db() {
$activity_log_act = 'post_created';
$user_ip_address = $_SERVER['REMOTE_ADDR'];

$sql_1 = "INSERT INTO posts(post_content, post_created, topic_id, user_id) VALUES(?, NOW(), ?, ?)";
$result_1 = $this->dbh->insert_data($sql_1, "sii", $this->post_content, $this->topic_id, $this->user_id);

$sql_2 = "UPDATE topics SET topic_updated = NOW() WHERE topic_id = ? LIMIT 1";
$result_2 = $this->dbh->update_data($sql_2, "i", $this->topic_id);

$sql_3 = "INSERT INTO activity_log(topic_id, user_id, activity_log_act, activity_log_timestamp, activity_log_ip_address) VALUES(?, ?, ?, NOW(), ?)";
$result_3 = $this->dbh->insert_data($sql_3, "iiss", $this->topic_id, $this->user_id, $activity_log_act, $user_ip_address);

return array('result_1' => $result_1, 'result_2' => $result_2, 'result_3' => $result_3);
}

public function create_post() {
if (Auth::is_logged_in()) {
if ($this->is_topic_locked() === true) {
throw new Exception("An error occurred, the topic is locked so no reply can be made.");
}
$result = $this->create_post_db();
if ($result['result_1'] !== false && $result['result_2'] !== false && $result['result_3'] !== false) {
return true;
} else {
throw new Exception("A critical error occurred while saving the post.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Saving a post.

//Remove a post.

private function check_if_topic_has_only_one_post() {
$is_removed = 0;
$sql = "SELECT COUNT(*) AS count FROM posts WHERE topic_id = ? AND is_removed = ?";
$result = $this->dbh->get_data($sql, "ii", $this->topic_id, $is_removed);
return (INT)$result['count'];
}

private function remove_post_db() {

$is_removed = 1;

$sql = "UPDATE posts SET is_removed = ? WHERE post_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "ii", $is_removed, $this->post_id);
}

public function remove_post() {
if (Auth::is_administrator_or_moderator()) {
$post_count = $this->check_if_topic_has_only_one_post();
if ($post_count === 1) {
throw new Exception("The topic only contains one post, remove the topic instead.");
} else {
$result = $this->remove_post_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while removing the post.");
}
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Remove a post.

//Remove a post permanent.

private function remove_post_permanent_db() {
$sql = "DELETE FROM posts WHERE post_id = ? LIMIT 1";
return $result = $this->dbh->remove_data($sql, "i", $this->post_id);
}

public function remove_post_permanent() {
if (Auth::is_administrator()) {
if ($this->remove_post_permanent_db()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the post.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Remove a post permanent.

//Restore a post.

private function restore_post_db() {

$is_removed = 0;

$sql = "UPDATE posts SET is_removed = ? WHERE post_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "ii", $is_removed, $this->post_id);
}

public function restore_post() {
if (Auth::is_administrator_or_moderator()) {
$result = $this->restore_post_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while restoring the post.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Restore a topic.

//Updating a post.

private function update_post_db() {
$sql = "UPDATE posts SET post_content = ? WHERE post_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "si", $this->post_content, $this->post_id);
}

public function update_post() {
if (Auth::is_administrator_or_moderator()) {
$result = $this->update_post_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while updating the post.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Updating a post.

}
