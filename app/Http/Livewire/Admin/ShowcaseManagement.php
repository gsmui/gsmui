<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Showcase;

class ShowcaseManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all';

    public function getShowcases()
    {
        $query = Showcase::query();
        if ($this->search) { $query->where('title', 'like', "%{$this->search}%"); }
        if ($this->status !== 'all') { $query->where('status', $this->status); }
        return $query->latest()->paginate(20);
    }

    public function approveShowcase(Showcase $showcase) { $showcase->update(['status' => 'published']); session()->flash('success', 'Showcase approved.'); }
    public function rejectShowcase(Showcase $showcase) { $showcase->update(['status' => 'rejected']); session()->flash('success', 'Showcase rejected.'); }
    public function deleteShowcase(Showcase $showcase) { $showcase->delete(); session()->flash('success', 'Showcase deleted.'); }

    public function render()
    {
        return view('livewire.admin.showcase-management', ['showcases' => $this->getShowcases()])->layout('components.layouts.admin', ['title' => 'Showcase Management']);
    }
}
