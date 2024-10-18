<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;

class UpdateUser extends Component
{
    public $query = '';
    public $users = [];
    public $selectedUser = null;
    public $showPasswordField = false;
    public $newPassword = '';

    public function updatedQuery()
    {
        if ($this->query) {
            $this->users = User::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->take(5)
            ->get();
        } else {
            $this->users = [];
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->showPasswordField = false;
        $this->newPassword = ''; // Reiniciar el campo de contraseña
    }

    public function enablePasswordChange()
    {
        $this->showPasswordField = true;
    }

    public function updatePassword()
    {
        if ($this->selectedUser && $this->newPassword !== '') {
            $this->selectedUser->update([
                'password' => bcrypt($this->newPassword)
            ]);
            $this->newPassword = '';
            session()->flash('message', __('Password updated successfully.'));
            $this->resetData();
            $this->updatedQuery();
        }
    }

    public function cancelUpdatePassword()
    {
        $this->showPasswordField = false;
        $this->newPassword = '';
    }

    public function togglePremium()
    {
        if ($this->selectedUser) {
            $this->selectedUser->update([
                'isPremium' => !$this->selectedUser->isPremium
            ]);
            session()->flash('message', __('Premium status updated successfully.'));
        }

        $this->resetData();
        $this->updatedQuery();
    }

    public function resetData()
    {
        $this->selectedUser = null;
        $this->showPasswordField = false;
        $this->newPassword = '';
    }

    public function clearAllData(){
        $this->query = '';
        $this->users = [];
        $this->selectedUser = null;
        $this->showPasswordField = false;
        $this->newPassword = '';
    }

    public function render()
    {
        return view('livewire.admin.users.update-user', [
            'users' => $this->users
        ]);
    }
}
