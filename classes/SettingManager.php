<?php
//SettingManager.php [Class to manage the categories table.]
//pathologicalplay [MMXXV]

class SettingManager {

private $dbh;

function __construct(Dbh $dbh) {
$this->dbh = $dbh;
}

//Set methods.

public function set_setting_id($setting_id) {
$this->setting_id = $setting_id;
}

public function set_setting_value($setting_value) {
$this->setting_value = $setting_value;
}

//Set methods.

//Output of settings. [controller->settings.php]

private function get_settings_db() {
$sql = "SELECT setting_id, setting_key, setting_value FROM settings";
return $result = $this->dbh->get_all_data($sql);
}

public function get_settings() {
$result = $this->get_settings_db();
if ($result !== false && ! empty($result)) {
return array_column($result, null, 'setting_key');
} else {
return false;
}
}

//Output of settings. [controller->settings.php]

//Updating a setting.

private function update_setting_db() {
$sql = "UPDATE settings SET setting_value = ? WHERE setting_id = ? LIMIT 1";
return $result = $this->dbh->update_data($sql, "si", $this->setting_value, $this->setting_id);
}

public function update_setting() {
$result = $this->update_setting_db();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while updating the setting.");
}
}

//Updating a setting.


}
