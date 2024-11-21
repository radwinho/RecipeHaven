<?php

namespace App\Livewire\Forms;

use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateRecipe extends Form
{
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('nullable|image|max:2048')]
    public $image;

    #[Validate('required|min:50')]
    public $ingredients = '';
    
    #[Validate('required|min:50')]
    public $preparation = '';
    
    public $storedImage;

    public $id;

    public function save()
    {
      $this->validate();

      $imageName = $this->storedImage;

      if ($this->image) {
        Storage::delete('public/photos/'.$imageName);
        $imageName = $this->image->hashName();
        $this->image->storeAs(path: 'public/photos', name: $imageName);
      }
    
      Recipe::find($this->id)->update([
        'name'        => $this->name,
        'recipe_image'=> $imageName,
        'ingredients' => $this->ingredients,
        'preparation' => $this->preparation
      ]);
    }

    public function init($recipe)
    {
      $this->id = $recipe->id;      
      $this->name = $recipe->name;      
      $this->ingredients = $recipe->ingredients;      
      $this->preparation = $recipe->preparation;      
      $this->storedImage = $recipe->recipe_image;      
    }
}
