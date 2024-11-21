<?php

namespace App\Livewire;

use App\Livewire\Forms\CreateRecipe;
use App\Livewire\Forms\UpdateRecipe;
use App\Models\Recipe;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MyRecipes extends Component
{
    
    use WithFileUploads;
    use WithPagination;

    public CreateRecipe $create;
    public UpdateRecipe $update;

    public $showCreate = false;
    public $showUpdate = false;
    public $showRecipe = false;
    public $showAlert = false;
    public $search = '';

    public $view;

    #[Computed()]
    public function recipes()
    { 
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return $user->recipes()->search($this->search)->paginate(5);
    }
    
    public function render()
    {
        return view('livewire.my-recipes');
    }

    public function save()
    {
        $this->create->save();
        $this->showCreate = false;
        $this->resetPage();
    }

    public function edit()
    {
        $this->update->save();
        $this->showUpdate = false;
    }

    public function delete($id)
    {
        Recipe::destroy($id);
        $this->showAlert = false;
        $this->resetPage();
    }

    public function init(Recipe $recipe)
    {
        $this->update->init($recipe);
    }

    public function display(Recipe $recipe)
    {
        $this->view = $recipe;
    }

}
