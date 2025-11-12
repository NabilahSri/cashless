<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UserModal extends Component
{
    public $show = false;
    public $mode = 'create';
    public $userId = null;
    public $name;
    public $username;
    public $password;
    public $role;

    protected $listeners = [
        'open-user-modal' => 'open',
        'open-edit-user' => 'openEdit'
    ];


    public function open()
    {
        $this->mode = 'create';
        $this->resetValidation();
        $this->reset(['name', 'username', 'password', 'role']);
        $this->show = true;
    }

    public function openEdit($id)
    {
        $this->resetValidation();
        $this->mode = 'edit';
        $this->userId = $id;
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->username = $user->username;
        $this->role = $user->role;
        $this->show = true;
    }


    public function save()
    {
        if ($this->mode === 'create') {
            $this->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'role' => 'required|in:admin,pengelola',
            ]);
            User::create([
                'name' => $this->name,
                'username' => $this->username,
                'password' => $this->password,
                'role' => $this->role
            ]);
            $this->dispatch('success', message: 'User berhasil ditambahkan.');
        } else {
            $this->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $this->userId,
                'role' => 'required|in:admin,pengelola',
                'password' => 'nullable',
            ]);
            $user = User::findOrFail($this->userId);
            $data = [
                'name' => $this->name,
                'username' => $this->username,
                'role' => $this->role,
            ];
            if (!empty($this->password)) {
                $data['password'] = bcrypt($this->password);
            }
            $user->update($data);
            $this->dispatch('success', message: 'User berhasil diupdate.');
        }
        $this->show = false;
        $this->dispatch('refreshDatatable')->to(UserTable::class);
    }

    public function render()
    {
        return view('livewire.user-modal');
    }
}
