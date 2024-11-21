<?php

namespace App\Livewire\Forms;

use App\Models\Recipe;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateRecipe extends Form
{
    
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|image|max:2048')]
    public $image;

    #[Validate('required|min:50')]
    public $ingredients = '';

    #[Validate('required|min:50')]
    public $preparation = '';
    
    public function save()
    {

        $this->validate();

        $imageName = $this->image->hashName();
        
        Recipe::create([
            'name'        => $this->name,
            'user_id'     => auth()->id(),
            'recipe_image'=> $imageName,
            'ingredients' => $this->ingredients,
            'preparation' => $this->preparation
        ]);

        $this->image->storeAs(path: 'public/photos', name: $imageName);

        $this->reset();

        session()->flash('success', 'Recipe Added.');

    }
}
