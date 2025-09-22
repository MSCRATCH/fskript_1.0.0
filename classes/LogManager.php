<?php
//LogManager.php [Class to manage the activity_log table.]
//pathologicalplay [MMXXV]

class LogManager {

private $dbh;
private $entries_per_page;
private $offset;

function __construct(Dbh $dbh) {
$this->dbh = $dbh;
}

//Set methods.

public function set_entries_per_page($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function set_offset($offset) {
$this->offset = $offset;
}

//Set methods.

//Total number of activity log entries for pagination.

private function get_number_of_activity_log_entries_db() {
$sql = "SELECT activity_log.activity_log_act, activity_log.activity_log_timestamp, activity_log.activity_log_ip_address, topics.topic_id, topics.topic_title, topics.is_removed, users.user_id, users.username FROM activity_log INNER JOIN topics ON activity_log.topic_id = topics.topic_id INNER JOIN users ON activity_log.user_id = users.user_id WHERE topics.is_removed != 1 ORDER BY activity_log.activity_log_timestamp DESC";
$result = $this->dbh->count_entire_data_from_table($sql);
return $result;
}

public function get_number_of_activity_log_entries() {
$result = $this->get_number_of_activity_log_entries_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Total number of activity log entries for pagination.

//Output of all activity log entries.

private function get_activity_log_db() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$sql = "SELECT activity_log.activity_log_act, activity_log.activity_log_timestamp, activity_log.activity_log_ip_address, topics.topic_id, topics.topic_title, topics.is_removed, users.user_id, users.username FROM activity_log INNER JOIN topics ON activity_log.topic_id = topics.topic_id INNER JOIN users ON activity_log.user_id = users.user_id WHERE topics.is_removed != 1 ORDER BY activity_log.activity_log_timestamp DESC LIMIT $offset, $entries_per_page";
return $result = $this->dbh->get_all_data($sql);
}

public function get_activity_log() {
$result = $this->get_activity_log_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of all activity log entries.


}
