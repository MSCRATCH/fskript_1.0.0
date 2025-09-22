<?php
//ProfileManager.php [Class to manage profiles.]
//pathologicalplay [MMXXV]

class ProfileManager {

private $dbh;
private $user_id;
private $user_profile_description;

function __construct(Dbh $dbh) {
$this->dbh = $dbh;
}

//Set methods.

public function set_user_id($user_id) {
$this->user_id = $user_id;
}

public function set_user_profile_description($user_profile_description) {
$this->user_profile_description = $user_profile_description;
}

//Set methods.

//Load data of the respective profile.

private function get_user_profile_db() {
$sql = "SELECT user_profiles.user_profile_picture, user_profiles.user_profile_description, users.username, users.user_level, users.user_date FROM user_profiles INNER JOIN users ON user_profiles.user_id = users.user_id WHERE user_profiles.user_id = ?";
return $result = $this->dbh->get_data($sql, "i", $this->user_id);
}

public function get_user_profile() {
$result = $this->get_user_profile_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Load data of the respective profile.

//Get the latest 5 topics of each user.

private function get_latest_topics_by_user_db() {
$sql = "SELECT topics.topic_id, topics.topic_title, topics.topic_created, users.user_id, users.username FROM topics INNER JOIN users ON topics.user_id = users.user_id WHERE topics.user_id = ? AND topics.is_removed = 0 ORDER BY topics.topic_created LIMIT 5";
return $result = $this->dbh->get_all_data_by_id($sql, "i", $this->user_id);
}

public function get_latest_topics_by_user() {
$result = $this->get_latest_topics_by_user_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Get the latest 5 topics of each user.

//Validation.

private function check_if_profile_form_is_empty() {
if (empty($this->user_profile_description)) {
return true;
} else {
return false;
}
}
//Validation.

//Update the profile.

private function update_user_profile_db() {
$sql = "UPDATE user_profiles SET user_profile_description = ? WHERE user_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "si", $this->user_profile_description, $this->user_id);
}

public function update_user_profile() {
if ($this->check_if_profile_form_is_empty() === true) {
throw new Exception("You must enter a description before you can submit the form.");
}
if ($this->update_user_profile_db()) {
return true;
} else {
throw new Exception("A critical error occurred while updating your profile description.");
}
}

//Update the profile.

}
