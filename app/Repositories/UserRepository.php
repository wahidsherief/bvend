<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function get($item = 15)
    {
        return $this->user->latest()->paginate($item);
    }

    public function find($id)
    {
        return $this->user->findOrFail($id);
    }

    public function findByCondition(array $conditions)
    {
        return $this->user->where($conditions)->first();
    }

    public function create()
    {
    }

    public function store(array $attributes)
    {
        return $this->user->newInstance()->fill($attributes)->save();
    }

    public function update($id, array $attributes)
    {
        return $this->user->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->user->find($id)->delete();
    }
}
