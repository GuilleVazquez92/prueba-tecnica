<?php
namespace App\Models;

use App\Repositories\UserRepository;
use PDOException;

class User 
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    private $_userRepository;

    public function __construct()
    {
        $this->_userRepository = new UserRepository;
    }

    public function get(int $id): ?User
    {
        $result = [];

        try {
          $result = $this->_userRepository->find($id);
        } catch (PDOException $ex) {

        }

        return $result;
    }

    public function getAll(): array
    {
        $result = [];

        try {
            $result = $this->_userRepository->findAll();
        } catch (PDOException $ex) {

        }

        return $result;
    }

    public function create(User $user): array
    {
        try {
            $result = $this->_userRepository->add($user);
            return $result; 
        } catch (PDOException $ex) {
    
        }
    }

    public function update(User $user): array
    {
        try {
            $result = $this->_userRepository->update($user);
            return $result;
        } catch (PDOException $ex) {
        
        }
        
    }

    public function delete(int $id): array
    {
        try {
            $result = $this->_userRepository->destroy($id);
            return $result;
        } catch (PDOException $ex) {

        }
    }
}