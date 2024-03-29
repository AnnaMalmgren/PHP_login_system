<?php 

namespace Model; 

require_once('Exceptions/RegisterUserException.php');
require_once('DAL/DbUserTable.php');
require_once('User.php');

class RegisteredUser {
    private $storage;
    private $registeredUser;

    public function __construct(UserCredentials $user) {
        $this->storage = new DbUserTable();
        $this->setRegisteredUser($user);
    }

     public function setRegisteredUser(UserCredentials $credentials) {
        $this->registeredUser = new User($credentials->getUsername(), $credentials->getPassword());
        if ($this->storage->getUser($credentials)) {
            throw new UsernameExistsException();
        }
        $this->storage->saveUser($this->registeredUser);
    }

    public function getRegisteredUsersName() : string {
        return $this->registeredUser->getUsername();
    }
}
