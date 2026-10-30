<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Templates\Models\Template;

class TemplateManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $selectedTemplate;
    public $form = ['name' => '', 'slug' => '', 'description' => '', 'category' => '', 'is_free' => true, 'price' => null];

    public function getTemplates()
    {
        $query = Template::query();
        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }
        return $query->latest()->paginate(20);
    }

    public function createTemplate() { $this->resetForm(); $this->isEditing = false; $this->showModal = true; }

    public function editTemplate(Template $template)
    {
        $this->selectedTemplate = $template;
        $this->form = $template->toArray();
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveTemplate()
    {
        $this->validate(['form.name' => 'required', 'form.slug' => 'required|unique:templates,slug,' . ($this->selectedTemplate?->id ?? '')]);
        if ($this->isEditing) { $this->selectedTemplate->update($this->form); } else { Template::create($this->form); }
        $this->showModal = false;
        session()->flash('success', 'Template saved successfully.');
    }

    public function deleteTemplate(Template $template) { $template->delete(); session()->flash('success', 'Template deleted.'); }
    public function resetForm() { $this->form = ['name' => '', 'slug' => '', 'description' => '', 'category' => '', 'is_free' => true, 'price' => null]; }

    public function render()
    {
        return view('livewire.admin.template-management', ['templates' => $this->getTemplates()])->layout('components.layouts.admin', ['title' => 'Template Management']);
    }
}
