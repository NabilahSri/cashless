<?php

namespace App\Livewire;

use App\Models\PartnerUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PengelolaModal extends Component
{

    public $show = false;
    public $mode = 'create';
    public $userId = null;
    public $name;
    public $username;
    public $password;
    public $role;

    protected $listeners = [
        'open-pengelola-modal' => 'open',
        'open-edit-pengelola' => 'openEdit'
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
        $partner = PartnerUser::where('user_id', Auth::user()->id)->first();
        if ($this->mode === 'create') {
            $this->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'role' => 'required|in:admin,pengelola',
            ]);
            $user = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'password' => $this->password,
                'role' => $this->role
            ]);

            PartnerUser::create([
                'partner_id' => $partner->partner_id,
                'user_id' => $user->id,
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
        $this->dispatch('refreshDatatable')->to(PengelolaTable::class);
    }
    public function render()
    {
        return view('livewire.pengelola-modal');
    }
}
