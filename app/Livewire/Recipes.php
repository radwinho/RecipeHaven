<?php

namespace App\Livewire;

use App\Livewire\Forms\CreateRecipe;
use App\Livewire\Forms\UpdateRecipe;
use App\Models\Comment;
use App\Models\Recipe;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Recipes extends Component
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
    public $order = 'created_at';
    public $showCommnet;
    public $comment;

    public $view;

    // #[On('comment-created')] 
    #[Computed]
    public function recipes()
    {
        $recipes = Recipe::with('comments')->withCount(['likes','comments'])->search($this->search)->orderBy($this->order, 'desc')->paginate(10);
        return $recipes;
    }

    // #[On('comment-created')] 
    public function render()
    {
        return view('livewire.recipes');
    }

    public function updatedSearch()
    {
        $this->resetPage();
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

    public function CommentRecipe($recipeId)
    {
      $this->showCommnet = $recipeId;
    }

    public function addComment() {
        $recipe = $this->recipes[$this->showCommnet];
        Comment::create([
            'user_id' => auth()->id(),
            'recipe_id' => $recipe->id,
            'body' => $this->comment,
        ]);

        $this->reset('comment');
        unset($this->recipes); 
        // $this->dispatch('comment-created'); 
    }

    public function toggleLike($recipeId)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($user->likedRecipes->contains($recipeId)) {
            // If the user already likes the recipe, unlike it
            $user->likedRecipes()->detach($recipeId);
        } else {
            // If the user does not like the recipe yet, like it
            $user->likedRecipes()->syncWithoutDetaching([$recipeId]);
        }

        // $this->dispatch('comment-created'); 
        // unset($this->recipes); 

    }
}
