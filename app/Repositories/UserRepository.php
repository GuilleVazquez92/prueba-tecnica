<?php

namespace App\Repositories;

use App\Exceptions\FatalException;
use App\Exceptions\NoParamsException;
use Database\Connection;
use App\Models\User;
use App\Exceptions\Handler;
use PDO;

class UserRepository
{
    private $_db;

    public function __construct()
    {
        $this->_db = Connection::get();
    }

    public function find(int $id): ?User
    {
        $result = null;

        $stm = $this->_db->prepare('select * from users where id = :id');
        $stm->execute(['id' => $id]);

        $data = $stm->fetchObject('\\App\\Models\\User');

        if ($data) {
            $result = $data;
        }

        return $result;
    }

    public function findAll(): array
    {
        $result = [];

        $stm = $this->_db->prepare('select * from users');
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_CLASS, '\\App\\Models\\User');

        if ($data) {
            $result = $data;
        }

        return $result;
    }

    public function add(User $user): array
    {
        try {
            if (empty($user->name) or empty($user->email) or  empty($user->password)) {
                throw new NoParamsException();
            } else {
                if ($this->find($user->id) == null) {
                    $stm = $this->_db->prepare(
                        'insert into users(id,name,email,password, created_at, updated_at) values (:id,:name, :email, :password, :created, :updated)'
                    );

                    $now = date('Y-m-d H:i:s');
                    $stm->execute([
                        'id'        => null,
                        'name'      => $user->name,
                        'email'     => $user->email,
                        'password'  => md5($user->password),
                        'created'   => $now,
                        'updated'   => $now,
                    ]);
                    return array('message' => 'user created successfully');
                } else {
                    return array('message' => 'User already exists!');
                }
            }
        } catch (\Exception $e) {
            throw new FatalException($e->getMessage());
        }
    }
    public function update(User $user): array
    {
        try {
            $sql = '';
            $array = [];
            if (isset($user)) {
                if (!empty($user->name)) {
                    $sql .= ' name = :name,';
                    $array['name'] = $user->name;
                }
                if (!empty($user->email)) {
                    $sql .= ' email = :email,';
                    $array['email'] = $user->email;
                }
                if (!empty($user->password)) {
                    $sql .= ' password = :password,';
                    $array['password'] = md5($user->password);
                }
                if ($this->find($user->id) == null) {
                    return array('message' => 'User not exits!');
                } else {
                    $stm = $this->_db->prepare('
            update users
            set' . $sql . '
            updated_at = :updated
            where id = :id');

                    $now = date('Y-m-d H:i:s');
                    $array['updated'] = $now;
                    $array['id'] = $user->id;

                    $stm->execute($array);
                    return array('message' => 'User update!');
                }
            }else{
                return array('message' => '
                There is no field to update!');
            }
        } catch (\Exception $e) {
            throw new FatalException($e->getMessage());
        }
    }

    public function destroy(int $id): array
    {
        try {
            if ($this->find($id) == null) {
                return array('message' => 'User not exits!');
            } else {
                $stm = $this->_db->prepare(
                    'delete from users where id = :id'
                );

                $stm->execute(['id' => $id]);
                return array('message' => 'User delete!');
            }
        } catch (\Exception $e) {
            throw new FatalException($e->getMessage());
        }
    }
}
