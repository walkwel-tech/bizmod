<?php

namespace App\Http\Livewire\Backend;

use App\User;
use Livewire\Component;
use Laravel\Sanctum\HasApiTokens;

class UserTokens extends Component
{

    public $user;
    public $tokens;
    public $saved;
    public $deleted;
    public $addedToken;
    public $selectedToken;
    public $plainTextToken;

    public function mount( User $user)
    {
        $this->user = $user;
        $this->tokens = $user->tokens;
        $this->saved = false;
        $this->deleted = false;

       // dd($this->business->getKey());
       // dd($this->tokens);
    }

    public function updated ()
    {

        $this->validate(['addedToken' => 'required']);
        $this->saved = false;
    }

    public function save ()
    {
       // dd($this->addedToken);
        $token = $this->user->createToken($this->addedToken);

        $this->plainTextToken = $token->plainTextToken;

        $this->addedToken = '';

        $this->emit('notifyUser', ['message' => __('basic.actions.saved', ['name' => "Relation"]), 'type' => 'primary']);
        // $this->emit('reload');
    }

    public function deleteRelation ($tokenID)
    {

        $this->deleted = $this->user->tokens()->where('id', $this->selectedToken)->delete();
        $this->emit('notifyUser', ['message' => __('basic.actions.removed', ['name' => "Relation"]), 'type' => 'danger']);

        // $this->emit('reload');
    }

    public function getAuthKeyProperty ()
    {
        return 'backend.user.edit';
    }

}
