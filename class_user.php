<?php
class User {
    protected $user_id;
    protected $username;
    protected $password;
    protected $role;
    protected $email;
    protected $phone;
    protected $is_active;
    protected $last_login;
    protected $created_at;

    public function __construct($user_id, $username, $password, $role, $email, $phone, $is_active, $last_login, $created_at) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->email = $email;
        $this->phone = $phone;
        $this->is_active = $is_active;
        $this->last_login = $last_login;
        $this->created_at = $created_at;
    }

    // Getter methods
    public function getUserId() {
        return $this->user_id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getIsActive() {
        return $this->is_active;
    }

    public function getLastLogin() {
        return $this->last_login;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // Setter methods
    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setIsActive($is_active) {
        $this->is_active = $is_active;
    }

    public function setLastLogin($last_login) {
        $this->last_login = $last_login;
    }
}
?>