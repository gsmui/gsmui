<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Theme;

class ThemeManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $selectedTheme;
    public $form = ['name' => '', 'slug' => '', 'description' => '', 'is_free' => true, 'price' => null, 'config' => null];

    public function getThemes()
    {
        $query = Theme::query();
        if ($this->search) { $query->where('name', 'like', "%{$this->search}%"); }
        return $query->latest()->paginate(20);
    }

    public function createTheme() { $this->resetForm(); $this->isEditing = false; $this->showModal = true; }

    public function editTheme(Theme $theme)
    {
        $this->selectedTheme = $theme;
        $this->form = $theme->toArray();
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveTheme()
    {
        $this->validate(['form.name' => 'required', 'form.slug' => 'required|unique:themes,slug,' . ($this->selectedTheme?->id ?? '')]);
        if ($this->isEditing) { $this->selectedTheme->update($this->form); } else { Theme::create($this->form); }
        $this->showModal = false;
        session()->flash('success', 'Theme saved successfully.');
    }

    public function deleteTheme(Theme $theme) { $theme->delete(); session()->flash('success', 'Theme deleted.'); }
    public function resetForm() { $this->form = ['name' => '', 'slug' => '', 'description' => '', 'is_free' => true, 'price' => null, 'config' => null]; }

    public function render()
    {
        return view('livewire.admin.theme-management', ['themes' => $this->getThemes()])->layout('layouts.admin', ['title' => 'Theme Management']);
    }
}
