<?php
//TopicManager.php [Class to manage the topics.]
//pathologicalplay [MMXXV]

class TopicManager {

private $dbh;
private $forum_id;
private $topic_title;
private $post_content;
private $user_id;
private $topic_id;
private $entries_per_page;
private $offset;

function __construct(Dbh $dbh) {
$this->dbh = $dbh;
}

//Set methods.

public function set_forum_id($forum_id) {
$this->forum_id = $forum_id;
}

public function set_topic_title($topic_title) {
$this->topic_title = $topic_title;
}

public function set_post_content($post_content) {
$this->post_content = $post_content;
}

public function set_user_id($user_id) {
$this->user_id = $user_id;
}

public function set_topic_id($topic_id) {
$this->topic_id = $topic_id;
}

public function set_entries_per_page($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function set_offset($offset) {
$this->offset = $offset;
}

//Set methods.

//Check if the topic ID exists.

public function validate_id_of_topic() {
$sql = "SELECT COUNT(*) AS topic_count FROM topics WHERE topic_id = ? AND is_removed = 0";
$result = $this->dbh->check_if_id_exists($sql, "i", $this->topic_id);
if ($result > 0) {
return true;
} else {
return false;
}
}

public function validate_id_of_removed_topic() {
$sql = "SELECT COUNT(*) AS topic_count FROM topics WHERE topic_id = ? AND is_removed = 1";
$result = $this->dbh->check_if_id_exists($sql, "i", $this->topic_id);
if ($result > 0) {
return true;
} else {
return false;
}
}

//Check if the topic ID exists.

//Total number of topics for pagination.

private function get_number_of_all_topics_by_forum_db() {
$sql = "SELECT COUNT(*) AS count FROM topics WHERE forum_id = ? AND is_removed = 0";
$result = $this->dbh->get_data($sql, "i", $this->forum_id);
return $result['count'];
}

public function get_number_of_all_topics_by_forum() {
$result = $this->get_number_of_all_topics_by_forum_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

private function get_number_of_all_topics_by_removed_status_db() {
$is_removed = 1;
$sql = "SELECT COUNT(*) AS count FROM topics WHERE is_removed = ?";
$result = $this->dbh->get_data($sql, "i", $is_removed);
return $result['count'];
}

public function get_number_of_all_topics_by_removed_status() {
$result = $this->get_number_of_all_topics_by_removed_status_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Total number of topics for pagination.

//Display of the topics in the corresponding forums with pagination.

private function get_all_topics_by_forum_db() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$sql = "SELECT
t.topic_id,
t.topic_title,
t.topic_created,
t.topic_updated,
u.user_id,
u.username,
COUNT(p.post_id) AS post_count,
lp.post_id AS last_post_id,
lp.user_id AS last_post_user_id,
lp.username AS last_post_username,
lp.post_created AS last_post_created
FROM
topics t
INNER JOIN
users u ON t.user_id = u.user_id
INNER JOIN
forums f ON t.forum_id = f.forum_id
LEFT JOIN
posts p ON t.topic_id = p.topic_id
LEFT JOIN
(
SELECT
p.topic_id,
p.post_id,
p.user_id,
u.username,
p.post_created,
ROW_NUMBER() OVER (PARTITION BY p.topic_id ORDER BY p.post_created DESC) AS rn
FROM
posts p
INNER JOIN
users u ON p.user_id = u.user_id
) lp ON t.topic_id = lp.topic_id AND lp.rn = 1
WHERE
t.forum_id = ? AND t.is_removed = 0
GROUP BY
t.topic_id,
t.topic_title,
t.topic_created,
t.topic_updated,
u.user_id,
u.username,
lp.post_id,
lp.user_id,
lp.username,
lp.post_created
ORDER BY
t.topic_updated DESC
LIMIT $offset, $entries_per_page;";
return $result = $this->dbh->get_all_data_by_id($sql, "i", $this->forum_id);
}

public function get_all_topics_by_forum() {
$result = $this->get_all_topics_by_forum_db();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Display of the topics in the corresponding forums with pagination.

//validation of the topic.

public function validate_topic() {
if (empty($this->topic_title) OR empty($this->forum_id) OR empty($this->user_id) OR empty($this->post_content)) {
return false;
}
}

//validation of the topic.

//Output of topic.

private function show_topic_db() {
$sql = "SELECT topic_title, forum_id, is_locked FROM topics WHERE topic_id = ? AND is_removed = 0";
return $result = $this->dbh->get_data($sql, "i", $this->topic_id);
}

public function show_topic() {
$result = $this->show_topic_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of topic.

//Output of all topics for the backend, that have been marked as removed.

private function get_all_removed_topics_db() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$sql = "SELECT topic_id, topic_title, topic_created, is_removed FROM topics WHERE is_removed = 1 LIMIT $offset, $entries_per_page";
return $result = $this->dbh->get_all_data($sql);
}

public function get_all_removed_topics() {
$result = $this->get_all_removed_topics_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of all topics for the backend, that have been marked as removed.

//Saving a topic.

private function create_topic_db() {
$activity_log_act_1 = 'topic_created';
$activity_log_act_2 = 'initial_post_created';
$user_ip_address = $_SERVER['REMOTE_ADDR'];

$sql_1 = "INSERT INTO topics(topic_title, topic_created, topic_updated, forum_id, user_id) VALUES(?, NOW(), NOW(), ?, ?)";
$result_1 = $this->dbh->insert_data_and_return($sql_1, "sii", $this->topic_title, $this->forum_id, $this->user_id);
$new_topic_id = $result_1->insert_id;

$sql_2 = "INSERT INTO posts(post_content, post_created, topic_id, user_id) VALUES(?, NOW(), ?, ?)";
$result_2 = $this->dbh->insert_data_and_return($sql_2, "sii", $this->post_content, $new_topic_id, $this->user_id);
$new_post_id = $result_2->insert_id;

$sql_3 = "INSERT INTO activity_log(topic_id, user_id, activity_log_act, activity_log_timestamp, activity_log_ip_address) VALUES(?, ?, ?, NOW(), ?)";
$result_3 = $this->dbh->insert_data($sql_3, "iiss", $new_topic_id, $this->user_id, $activity_log_act_1, $user_ip_address);

$sql_4 = "INSERT INTO activity_log(topic_id, user_id, activity_log_act, activity_log_timestamp, activity_log_ip_address) VALUES(?, ?, ?, NOW(), ?)";
$result_4 = $this->dbh->insert_data($sql_4, "iiss", $new_topic_id, $this->user_id, $activity_log_act_2, $user_ip_address);

return array('result_1' => $new_topic_id, 'result_2' => $new_post_id, 'result_3' => $result_3, 'result_4' => $result_4);
}

public function create_topic() {
if (Auth::is_logged_in()) {
$result = $this->create_topic_db();
if ($result['result_1'] !== false && $result['result_2'] !== false && $result['result_3'] !== false && $result['result_4'] !== false) {
return array('success' => true, 'new_topic_id' => $result['result_1']);
} else {
throw new Exception("A critical error occurred while saving the topic.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Saving a topic.

//Remove a topic.

private function remove_topic_db() {

$is_removed = 1;

$sql = "UPDATE topics SET is_removed = ? WHERE topic_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "ii", $is_removed, $this->topic_id);
}

public function remove_topic() {
if (Auth::is_administrator_or_moderator()) {
$result = $this->remove_topic_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while removing the topic.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Remove a topic.

//Restore a topic.

private function restore_topic_db() {

$is_removed = 0;

$sql = "UPDATE topics SET is_removed = ? WHERE topic_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "ii", $is_removed, $this->topic_id);
}

public function restore_topic() {
if (Auth::is_administrator_or_moderator()) {
$result = $this->restore_topic_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while restoring the topic.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Restore a topic.

//Remove a topic permanent.

private function remove_topic_permanent_db() {

$sql_1 = "DELETE FROM topics WHERE topic_id = ? LIMIT 1";
$result_1 = $this->dbh->remove_data($sql_1, "i", $this->topic_id);

$sql_2 = "DELETE FROM posts WHERE topic_id = ?";
$result_2 = $this->dbh->remove_data($sql_2, "i", $this->topic_id);

return array('result_1' => $result_1, 'result_2' => $result_2);
}

public function remove_topic_permanent() {
if (Auth::is_administrator()) {
$result = $this->remove_topic_permanent_db();
if ($result['result_1'] !== false && $result['result_2'] !== false) {
return true;
} else {
throw new Exception("A critical error occurred while removing the forum.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Remove a topic permanent.

//Updating a topic.

private function update_topic_db() {
$sql = "UPDATE topics SET topic_title = ?, forum_id = ? WHERE topic_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "sii", $this->topic_title, $this->forum_id, $this->topic_id);
}

public function update_topic() {
if (Auth::is_administrator_or_moderator()) {
$result = $this->update_topic_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while updating the topic.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Updating a topic.

//Lock a topic.

private function lock_topic_db() {

$is_locked = 1;

$sql = "UPDATE topics SET is_locked = ? WHERE topic_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "ii", $is_locked, $this->topic_id);
}

public function lock_topic() {
if (Auth::is_administrator_or_moderator()) {
$result = $this->lock_topic_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while locking the topic.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Lock a topic.

//Unlock a topic.

private function unlock_topic_db() {

$is_locked = 0;

$sql = "UPDATE topics SET is_locked = ? WHERE topic_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "ii", $is_locked, $this->topic_id);
}

public function unlock_topic() {
if (Auth::is_administrator_or_moderator()) {
$result = $this->unlock_topic_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while unlocking the topic.");
}
} else {
throw new Exception("You are not authorized to perform this action.");
}
}

//Unlock a topic.


}
