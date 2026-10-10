<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['username', 'full_name', 'created_at', 'avatar', 'password'];

    public function findForLogin(string $username): ?array
    {
        $user = $this->select('id, username, password')
            ->where('username', $username)
            ->first();

        return $user === null ? null : $user;
    }

    public function findPublicById(string $id): ?array
    {
        $user = $this->select('id, username, full_name, created_at, avatar')->find($id);

        return $user === null ? null : $user;
    }

    public function findAllPublic(): array
    {
        return $this->select('id, username, full_name, created_at, avatar')->findAll();
    }
}