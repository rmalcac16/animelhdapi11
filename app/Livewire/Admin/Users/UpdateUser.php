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
    public $showEmailField = false;
    public $newEmail = '';

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
        $this->newPassword = '';
        $this->showEmailField = false;
        $this->newEmail = '';
    }

    public function enableEmailChange()
    {
        $this->showEmailField = true;
    }

    public function enablePasswordChange()
    {
        $this->showPasswordField = true;
    }

    public function updateEmail()
    {
        if ($this->selectedUser && $this->newEmail !== '') {

            //Validated email
            $this->validate([
                'newEmail' => 'required|email|unique:users,email'
            ]);
            
            $this->selectedUser->update([
                'email' => $this->newEmail
            ]);
            $this->newEmail = '';
            session()->flash('success', __('Email updated successfully.'));
            $this->resetData();
            $this->updatedQuery();
        }
    }

    public function updatePassword()
    {
        if ($this->selectedUser && $this->newPassword !== '') {
            $this->selectedUser->update([
                'password' => bcrypt($this->newPassword)
            ]);
            $this->newPassword = '';
            session()->flash('success', __('Password updated successfully.'));
            $this->resetData();
            $this->updatedQuery();
        }
    }

    public function cancelUpdateEmail()
    {
        $this->showEmailField = false;
        $this->newEmail = '';
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
            session()->flash('success', __('Premium status updated successfully.'));
        }

        $this->resetData();
        $this->updatedQuery();
    }

    public function resetData()
    {
        $this->selectedUser = null;
        $this->showPasswordField = false;
        $this->newPassword = '';
        $this->showEmailField = false;
        $this->newEmail = '';
    }

    public function clearAllData(){
        $this->query = '';
        $this->users = [];
        $this->selectedUser = null;
        $this->showPasswordField = false;
        $this->newPassword = '';
        $this->showEmailField = false;
        $this->newEmail = '';
    }

    public function render()
    {
        return view('livewire.admin.users.update-user', [
            'users' => $this->users
        ]);
    }
}
