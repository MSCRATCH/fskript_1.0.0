<?php
//ForumManager.php [Class to manage the categories and their forums.]
//pathologicalplay [MMXXV]

class ForumManager {

private $dbh;
private $category_id;
private $category_name;
private $forum_id;
private $forum_name;
private $forum_description;
private $entries_per_page;
private $offset;

function __construct(Dbh $dbh) {
$this->dbh = $dbh;
}

//Set methods.

public function set_category_id($category_id) {
$this->category_id = $category_id;
}

public function set_category_name($category_name) {
$this->category_name = $category_name;
}

public function set_forum_id($forum_id) {
$this->forum_id = $forum_id;
}

public function set_forum_name($forum_name) {
$this->forum_name = $forum_name;
}

public function set_forum_description($forum_description) {
$this->forum_description = $forum_description;
}

public function set_entries_per_page($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function set_offset($offset) {
$this->offset = $offset;
}

//Set methods.

//Check if the category ID exists.

public function validate_id_of_category() {
$sql = "SELECT COUNT(*) AS category_count FROM categories WHERE category_id = ?";
$result = $this->dbh->check_if_id_exists($sql, "i", $this->category_id);
if ($result > 0) {
return true;
} else {
return false;
}
}

//Check if the category ID exists.

//Check if the forum id exists.

public function validate_id_of_forum() {
$sql = "SELECT COUNT(*) AS forum_count FROM forums WHERE forum_id = ?";
$result = $this->dbh->check_if_id_exists($sql, "i", $this->forum_id);
if ($result > 0) {
return true;
} else {
return false;
}
}

//Check if the forum id exists.

//Display of the categories and the corresponding forums.

private function get_all_categories_and_forums_db() {
$sql = "SELECT
c.category_id AS category_forum_id,
c.category_name,
f.forum_id,
f.forum_name,
f.forum_description,
(SELECT COUNT(*) FROM topics WHERE forum_id = f.forum_id AND is_removed != 1) AS topic_count,
(SELECT COUNT(*) FROM posts WHERE topic_id IN (SELECT topic_id FROM topics WHERE forum_id = f.forum_id AND is_removed != 1)) AS post_count,
t.topic_title AS latest_topic_title,
t.topic_id AS latest_topic_id,
t.username AS latest_topic_user,
t.user_id AS latest_topic_user_id,
t.topic_created AS latest_topic_created
FROM
categories c
JOIN
forums f ON c.category_id = f.category_id
LEFT JOIN
(
SELECT
t.forum_id,
t.topic_title,
t.topic_id,
t.topic_created,
u.username,
u.user_id,
ROW_NUMBER() OVER (PARTITION BY t.forum_id ORDER BY t.topic_created DESC) AS rn
FROM
topics t
JOIN
users u ON t.user_id = u.user_id
WHERE
t.is_removed != 1
) t ON f.forum_id = t.forum_id AND t.rn = 1
ORDER BY
c.category_id,
f.forum_id;";
return $result = $this->dbh->get_all_data($sql);
}

public function get_all_categories_and_forums() {
$result = $this->get_all_categories_and_forums_db();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Display of the categories and the corresponding forums.

//Validation.

private function check_if_category_form_is_empty() {
if (empty($this->category_name)) {
throw new Exception("Category name is required.");
}
}

private function check_if_forum_form_is_empty() {
if (empty($this->forum_name) OR empty($this->forum_description)) {
throw new Exception("Forum name and description are required.");
}
}

//Validation.

//Total number of forums for pagination.

private function get_number_of_forums_db() {
$sql = "SELECT forum_id, forum_name, forum_description, category_id FROM forums";
$result = $this->dbh->count_entire_data_from_table($sql);
return $result;
}

public function get_number_of_forums() {
$result = $this->get_number_of_forums_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Total number of forums for pagination.

//Output of all forums paginated for the backend.

private function get_all_forums_db() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$sql = "SELECT forum_id, forum_name, forum_description, category_id FROM forums LIMIT $offset, $entries_per_page";
return $result = $this->dbh->get_all_data($sql);
}

public function get_all_forums() {
$result = $this->get_all_forums_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of all forums paginated for the backend.

//Output of forums.

private function show_forums_db() {
$sql = "SELECT forum_id, forum_name, forum_description FROM forums";
return $result = $this->dbh->get_all_data($sql);
}

public function show_forums() {
$result = $this->show_forums_db();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of categories.

//Output of forum.

private function show_forum_db() {
$sql = "SELECT forum_name, forum_description, category_id FROM forums WHERE forum_id = ?";
return $result = $this->dbh->get_data($sql, "i", $this->forum_id);
}

public function show_forum() {
$result = $this->show_forum_db();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of forum.

//Saving a forum.

private function create_forum_db() {
$sql = "INSERT INTO forums(forum_name, forum_description, category_id) VALUES(?, ?, ?)";
return $result = $this->dbh->insert_data($sql, "ssi", $this->forum_name, $this->forum_description, $this->category_id);
}

public function create_forum() {
$this->check_if_forum_form_is_empty();
$result = $this->create_forum_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while creating the forum.");
}
}

//Saving a forum.

//Updating a forum.

private function update_forum_db() {
$sql = "UPDATE forums SET forum_name = ?, forum_description = ?, category_id = ? WHERE forum_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "ssii", $this->forum_name, $this->forum_description, $this->category_id, $this->forum_id);
}

public function update_forum() {
$this->check_if_forum_form_is_empty();
$result = $this->update_forum_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while updating the forum.");
}
}

//Updating a forum.

//Remove a forum.

private function remove_forum_db() {
$sql = "DELETE FROM forums WHERE forum_id = ? LIMIT 1";
return $result = $this->dbh->remove_data($sql, "i", $this->forum_id);
}

public function remove_forum() {
if ($this->remove_forum_db()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the forum.");
}
}

//Remove a forum.

//Output of categories.

private function show_categories_db() {
$sql = "SELECT category_id, category_name FROM categories";
return $result = $this->dbh->get_all_data($sql);
}

public function show_categories() {
$result = $this->show_categories_db();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of categories.

//Saving a category.

private function create_category_db() {
$sql = "INSERT INTO categories(category_name) VALUES(?)";
return $result = $this->dbh->insert_data($sql, "s", $this->category_name);
}

public function create_category() {
$this->check_if_category_form_is_empty();
$result = $this->create_category_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while creating the category.");
}
}

//Saving a category.

//Updating a category.

private function update_category_db() {
$sql = "UPDATE categories SET category_name = ? WHERE category_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "si", $this->category_name, $this->category_id);
}

public function update_category() {
$this->check_if_category_form_is_empty();
$result = $this->update_category_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while updating the category.");
}
}

//Updating a category.

//Remove a category.

private function remove_category_db() {
$sql = "DELETE FROM categories WHERE category_id = ? LIMIT 1";
return $result = $this->dbh->remove_data($sql, "i", $this->category_id);
}

public function remove_category() {
if ($this->remove_category_db()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the category.");
}
}

//Remove a category.

}
