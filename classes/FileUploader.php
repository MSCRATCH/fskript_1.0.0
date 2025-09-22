<?php
//FileUploader.php [Class to control uploads.]
//pathologicalplay [MMXXV]

class FileUploader {

private $dbh;
private $image;
private $user_id;
private $allowed_image_extensions = array("jpg", "jpeg", "png");
private $allowed_image_mime_types = array('image/jpeg', 'image/png');
private $maximum_image_size = 2 * 1024 * 1024;
private $error_container;

function __construct(Dbh $dbh) {
$this->dbh = $dbh;
}

//Set methods.

public function set_image($image) {
$this->image = $image['image'];
}

public function set_user_id($user_id) {
$this->user_id = $user_id;
}

public function set_error_container(ErrorContainer $error_container) {
$this->error_container = $error_container;
}

//Set methods.

//Create new file name for an image (image).

private function create_new_image_name() {
$image_name = $this->image['name'];
$new_image_name = uniqid();
$image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
return $final_new_image_name = $new_image_name.  "." . $image_extension;
}

//Validate the uploaded image.

private function validate_image() {
if (isset($this->image) && is_array($this->image)) {
if ($this->image['error'] === UPLOAD_ERR_OK) {
$image_size = $this->image['size'];
if ($image_size > $this->maximum_image_size) {
$this->error_container->add_error('Error uploading image, invalid image size.');
}
$image_name = $this->image['name'];
$image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
if (! in_array(strtolower($image_extension), $this->allowed_image_extensions)) {
$this->error_container->add_error('Error uploading image, invalid image extension. Only JPG, JPEG or PNG allowed.');
}
$image_type = $this->image['type'];
if (! in_array($image_type, $this->allowed_image_mime_types)) {
$this->error_container->add_error('Error uploading image, invalid MIME Type.');
}
$file_image_size = getimagesize($this->image['tmp_name']);
if ($file_image_size !== false) {
$width = $file_image_size[0];
$height = $file_image_size[1];

if ($width > 250 and $height > 250 or $width < 250 and $height < 250) {
$this->error_container->add_error('The cover image must be 250X250PX.');
}
} else {
$this->error_container->add_error('The cover image must be 250X250PX.');
}
} elseif ($this->image['error'] === UPLOAD_ERR_NO_FILE) {
$this->error_container->add_error('Error uploading image, you need to enter a image.');
}
}
}

//Validate the uploaded image.

//Check if a profile picture is already uploaded.

private function check_if_image_exists_db() {
$sql = "SELECT user_profile_picture FROM user_profiles WHERE user_id = ?";
$existing_image = $this->dbh->get_single_value($sql, "i", $this->user_id);
if ($existing_image) {
if (file_exists('images/' . $existing_image)) {
unlink('images/' . $existing_image);
}
}
}

//Check if a profile picture is already uploaded.

//Insert image path into DB.

private function insert_image_name_db() {
$new_image_name = $this->create_new_image_name();
$sql = "UPDATE user_profiles SET user_profile_picture = ? WHERE user_id = ? LIMIT 1";
$result = $this->dbh->update_data($sql, "si", $new_image_name, $this->user_id);
if ($result) {
return $new_image_name;
} else {
return false;
}
}

//Insert image path into DB.

//Upload an image.

private function upload_image() {
$this->check_if_image_exists_db();
$image_tmp_name = $this->image['tmp_name'];
$new_image_name = $this->insert_image_name_db();
if ($new_image_name && move_uploaded_file ($image_tmp_name , 'images/'. $new_image_name)) {
return true;
} else {
return false;
}
}

//Upload an image.

//Upload.

public function upload() {
$this->validate_image();
if ($this->error_container->has_errors()) {
return false;
} else {
return $result = $this->upload_image();
}
}

//Upload.

}
