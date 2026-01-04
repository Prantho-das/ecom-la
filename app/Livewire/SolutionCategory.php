<?php

namespace App\Livewire;

use App\Models\Solution;
use Livewire\Component;
use App\Models\SolutionCategory as SolutionCategoryModel;
class SolutionCategory extends Component
{
    public $solutionCategories;

    public function mount()
    {
        $this->solutionCategories = Solution::when(request()->filled('category_id'), function ($query) {
            $query->whereHas('categories', function ($q) {
                $q->where('solution_solution_category.solution_category_id', request()->category_id);
            });
        })
        ->get();
    }

    public function render()
    {
        return view('livewire.solution-category');
    }
}
