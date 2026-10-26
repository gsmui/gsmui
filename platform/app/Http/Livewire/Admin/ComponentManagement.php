<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Component;

class ComponentManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $selectedComponent;
    public $form = ['name' => '', 'slug' => '', 'description' => '', 'category' => '', 'version' => '1.0.0', 'status' => 'active', 'is_free' => true, 'code_example' => ''];

    public function getComponents()
    {
        $query = Component::query();
        if ($this->search) { $query->where('name', 'like', "%{$this->search}%"); }
        return $query->latest()->paginate(20);
    }

    public function createComponent() { $this->resetForm(); $this->isEditing = false; $this->showModal = true; }

    public function editComponent(Component $component)
    {
        $this->selectedComponent = $component;
        $this->form = $component->toArray();
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveComponent()
    {
        $this->validate(['form.name' => 'required', 'form.slug' => 'required|unique:components,slug,' . ($this->selectedComponent?->id ?? '')]);
        if ($this->isEditing) { $this->selectedComponent->update($this->form); } else { Component::create($this->form); }
        $this->showModal = false;
        session()->flash('success', 'Component saved.');
    }

    public function deleteComponent(Component $component) { $component->delete(); session()->flash('success', 'Component deleted.'); }
    public function resetForm() { $this->form = ['name' => '', 'slug' => '', 'description' => '', 'category' => '', 'version' => '1.0.0', 'status' => 'active', 'is_free' => true, 'code_example' => '']; }

    public function render()
    {
        return view('livewire.admin.component-management', ['components' => $this->getComponents()])->layout('layouts.admin', ['title' => 'Component Management']);
    }
}
