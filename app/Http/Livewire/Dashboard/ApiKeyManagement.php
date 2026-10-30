<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class ApiKeyManagement extends Component
{
    public $showModal = false, $newKeyName = '';

    public function getApiKeys() { return auth()->user()->apiKeys()->latest()->get(); }

    public function createApiKey()
    {
        $this->validate(['newKeyName' => 'required|string|max:255']);
        auth()->user()->apiKeys()->create(['name' => $this->newKeyName, 'abilities' => ['*']]);
        $this->showModal = false;
        $this->newKeyName = '';
        session()->flash('success', 'API key created.');
    }

    public function deleteApiKey($id) { auth()->user()->apiKeys()->find($id)?->delete(); session()->flash('success', 'API key deleted.'); }

    public function render()
    {
        return view('livewire.dashboard.api-key-management', ['apiKeys' => $this->getApiKeys()])->layout('components.layouts.dashboard', ['title' => 'API Keys']);
    }
}
