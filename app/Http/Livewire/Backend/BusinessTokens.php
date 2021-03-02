<?php

namespace App\Http\Livewire\Backend;

use App\Business;
use App\User;
use Livewire\Component;
use Laravel\Sanctum\HasApiTokens;

class BusinessTokens extends Component
{

    public $business;
    public $tokens;
    public $saved;
    public $deleted;
    public $addedToken;
    public $selectedToken;
    public $plainTextToken;

    public function mount( Business $business)
    {
        $this->business = $business;
        $this->tokens = $business->tokens;
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
        $token = $this->business->createToken($this->addedToken);

        $this->plainTextToken = $token->plainTextToken;

        $this->addedToken = '';

        $this->emit('notifyUser', ['message' => __('basic.actions.saved', ['name' => "Relation"]), 'type' => 'primary']);
        // $this->emit('reload');
    }

    public function deleteRelation ($tokenID)
    {
        dd($tokenID);
        $this->deleted = $this->business->tokens()->where('id', $this->selectedToken)->delete();
        $this->emit('notifyUser', ['message' => __('basic.actions.removed', ['name' => "Relation"]), 'type' => 'danger']);

        // $this->emit('reload');
    }

    public function getAuthKeyProperty ()
    {
        return 'backend.business.edit';
    }

}
