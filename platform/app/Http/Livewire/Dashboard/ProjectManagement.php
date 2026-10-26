<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Project;

class ProjectManagement extends Component
{
    public $showModal = false;
    public $isEditing = false;
    public $selectedProject;
    public $form = ['name' => '', 'slug' => '', 'description' => '', 'is_public' => false];

    public function getProjects() { return auth()->user()->projects()->latest()->paginate(12); }

    public function createProject() { $this->resetForm(); $this->isEditing = false; $this->showModal = true; }

    public function editProject(Project $project)
    {
        $this->selectedProject = $project;
        $this->form = $project->toArray();
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveProject()
    {
        $this->validate(['form.name' => 'required', 'form.slug' => 'required|unique:projects,slug,' . ($this->selectedProject?->id ?? '')]);
        if ($this->isEditing) { $this->selectedProject->update($this->form); } else { auth()->user()->projects()->create($this->form); }
        $this->showModal = false;
        session()->flash('success', 'Project saved.');
    }

    public function deleteProject(Project $project) { $project->delete(); session()->flash('success', 'Project deleted.'); }
    public function resetForm() { $this->form = ['name' => '', 'slug' => '', 'description' => '', 'is_public' => false]; }

    public function render()
    {
        return view('livewire.dashboard.project-management', ['projects' => $this->getProjects()])->layout('layouts.dashboard', ['title' => 'Projects']);
    }
}
