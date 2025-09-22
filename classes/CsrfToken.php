<?php
//CsrfToken.php [Class to protect forms against CSRF.]
//pathologicalplay [MMXXV]

class CsrfToken {
private $session;
private $token_name_prefix = 'csrf_token_';

public function __construct(&$session) {
$this->session = &$session;
}

//Create token.

public function generate_token($form_name) {
$token = bin2hex(random_bytes(32));
$token_name = $this->token_name_prefix . $form_name;
$this->session[$token_name] = $token;
return $token;
}

//Create token.

//Validate token.

public function validate_token($form_name, $token) {
$token_name = $this->token_name_prefix . $form_name;
if (isset($this->session[$token_name]) && $token === $this->session[$token_name]) {
$this->delete_token($form_name);
return true;
}
return false;
}

//Validate token.

//Remove token.

private function delete_token($form_name) {
$token_name = $this->token_name_prefix . $form_name;
unset($this->session[$token_name]);
}

//Remove token.

}
