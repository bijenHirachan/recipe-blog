<div class="m-10">

  
    <div class="">
        <div class="flex justify-end">
            <button class="bg-yellow-500 px-2 py1 rounded font-semibold text-gray-100 hover:bg-yellow-400" wire:click="showRecipeModal">Voeg een recept toe</button>
        </div>
     <div>
        

                <!-- component -->
        <div class="table w-full p-2">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-50 border-b">
                    
                        <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                            <div class="flex items-center justify-center">
                                ID
                        
                            </div>
                        </th>
                        <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                            <div class="flex items-center justify-center">
                                Recept
                        
                            </div>
                        </th>
                        <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                            <div class="flex items-center justify-center">
                                Foto
                        
                            </div>
                        </th>
                        <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                            <div class="flex items-center justify-center">
                                Omschrijving
                        
                            </div>
                        </th>
                        <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                            <div class="flex items-center justify-center">
                                Actie
                        
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($recipes as $recipe)
                    <tr class="bg-gray-100 text-center border-b text-sm text-gray-600">
                        
                        <td class="p-2 border-r">{{ $recipe->id }}</td>
                        <td class="p-2 border-r">{{ $recipe->recipe_name }}</td>
                        <td class="p-2 border-r flex justify-center"><img class="rounded-2xl w-36 h-24 " src="{{asset('storage/photos/'.$recipe->image_path)}}" alt=""></td>
                        <td class="p-2 border-r">{{ $recipe->description }}</td>
                        <td class="">
                            <button class="bg-green-400 px-2 py-1 rounded text-white" wire:click="editRecipe({{$recipe->id}})">Edit</button>
                            <button class="bg-red-400 px-2 py-1 rounded text-white" wire:click="deleteRecipe({{$recipe->id}})">Delete</button>
                            <button class="bg-indigo-400 px-2 py-1 rounded text-white" wire:click="addIngredientsAndSteps({{$recipe->id}})">Add ingredients and steps</button>
                        </td>
                    </tr>
                @endforeach 
                
        
                </tbody>
            </table>
        </div>
     </div>
      
       
    </div>

    {{-- create update modal --}}
    <x-jet-dialog-modal wire:model="recipeModal">
        <x-slot name="title">
            @if ($modalId)
                {{ __('Bewerk je recept') }}
            @else 
                {{ __('Voeg een recept toe') }}
            @endif
        </x-slot>

        <x-slot name="content">
            <div class="my-2 w-1/4 relative">
                @if ($modalId)
                    Foto:
                    <img class="w-36 h-24" src="{{ asset('storage/photos/'.$modalPhoto) }}">
                    {{-- @if ($photo)
                    Photo Preview:
                    <img class="w-36 h-24" src="{{ $photo->temporaryUrl() }}">
                    <div class="absolute top-0 right-1">
                        <svg wire:click ="cancelPhoto"  xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    @endif --}}
                @else
                    @if ($photo)
                    Photo Preview:
                    <img class="w-36 h-24" src="{{ $photo->temporaryUrl() }}">
                    <div class="absolute top-0 right-1">
                        <svg wire:click ="cancelPhoto"  xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    @endif
                @endif

             
            </div>
           <form wire:submit.prevent="save">
                    <div class="flex my-2">
                        @if (!$modalId)
                            <label for="photo" class="w-36 font-bold hover:text-gray-400 cursor-pointer">Upload Foto</label>
                            <input type="file" id="photo" wire:model="photo" hidden>
                            @error('photo') <span class="error my-2">{{ $message }}</span> @enderror
                        @endif
                      
                    </div>
                    <div  class="flex flex-col ">
                        <label for="recipe">Recept</label>
                        <input type="text" wire:model="recipe" class="focus:outline-none rounded">
                    </div>
                    <div class="flex flex-col focus:outline-none">
                        <label for="description">Omschrijving</label>
                        <textarea wire:model="description" cols="30"  class="focus:outline-none overflow-y-scroll rounded"></textarea>
                    </div>

            

                    @if ($modalId)
                        <x-jet-secondary-button class="bg-green-400 text-white  my-2" wire:click="updateRecipe" wire:loading.attr="disabled">
                            {{ __('Update') }}
                        </x-jet-secondary-button>
                    @else
                        <x-jet-secondary-button class="bg-green-400 text-white  my-2" wire:click="save" wire:loading.attr="disabled">
                            {{ __('Save') }}
                        </x-jet-secondary-button>
                    @endif
                   
            </form>
          
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('recipeModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
         
        </x-slot>
    </x-jet-dialog-modal>
    {{-- end create update modal --}}



      {{-- start ingredient and steps add modal --}}
      <x-jet-dialog-modal wire:model="addModal">
        <x-slot name="title">
            <h3 class="text-xl font-semibold">{{ __('Voeg benodigheden en stappen toe') }} # {{$recipeName}}</h3>
        </x-slot>

        <x-slot name="content">
            {{-- already added ingredients and steps --}}
            <div class="grid grid-cols-2 my-2">
                <div class="bg-gray-100 rounded-lg p-2 mr-1">
                  <h3 class="font-semibold text-center mb-1">Benodigheden Toegevoegd</h3>
                  @if (count($addedIngredients) > 0)
                    @foreach ($addedIngredients as $ingredient )
                    <div class="flex justify-between">
                                             
                            <h2 class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg> 
                                {{$ingredient->ingredient}}
                            </h2>
                            <div class="flex gap-1">
                                <h2>{{$ingredient->quantity}}</h2>
                                <div>
                                    <svg wire:click="deleteAddedIngredient({{$ingredient->id}})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                      </svg>
                                </div>
                            </div>
                          
                    </div>
                    @endforeach
                  @endif
                </div>
                <div class="bg-gray-100 rounded-lg p-2 ml-1">
                  <h3 class="font-semibold text-center mb-1">Stappen Toegevoegd</h3>
                  <div>
                    @if (count($addedSteps) > 0)
                        @foreach ($addedSteps as $key=>$step )
                        <div class="flex gap-2">
                            <div class="">
                                <svg wire:click="deleteAddedStep({{$step->id}})" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer text-red-500 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                  </svg>
                            </div>
                            <h2 class="font-bold"> {{++$key}}</h2>
                            <h2>{{$step->step}} <span class="text-sm font-semibold text-green-700">[ Order: {{$step->order}}]</span></h2>
                            
                        </div>
                       
                        @endforeach
                    @endif
                  </div>
                  
                </div>
            </div>

            <div>
                <form class="flex flex-col gap-8" wire:submit.prevent="saveIngredients">
                    <div>
                        <div class="grid grid-cols-5 gap-1">
                            <div class="flex  flex-col col-span-2">
                                <label for="ingredient">Ingredient</label>
                                <input class="rounded focus:outline-none" type="text" wire:model="ingredient.0">
                            </div>
                            <div class="flex  flex-col col-span-2">
                                <label for="quantity">Hoeveelheid</label>
                                <input class="rounded focus:outline-none" type="text" wire:model="quantity.0">
                            </div>
                            <div class="col-span-1 flex justify-center items-end ">
                                <button class="bg-green-400 rounded px-2 py-1 text-white" wire:click.prevent="add({{$index}})">Add</button>
                            </div>
                        </div>
                        @foreach ($inputs as $key=>$value)
                        <div class="grid grid-cols-5 mt-1">
                            <div class="flex col-span-2">
                                <input class="w-full rounded focus:outline-none mr-1" type="text" wire:model="ingredient.{{$value}}">
                            </div>
                            <div class="flex col-span-2">
                                <input class="w-full rounded focus:outline-none " type="text" wire:model="quantity.{{$value}}">
                            </div>
                            <div class="col-span-1 flex justify-center items-center">
                                <button class="bg-red-400 rounded px-2 py-1 text-white" wire:click.prevent="delete({{$key}})">Delete</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="my-3">
                        <button class="bg-indigo-400 text-white uppercase font-semibold rounded px-2 py-1" type="submit">Save</button>
                    </div>
                </form>
                <form wire:submit.prevent="saveSteps">
                     <div>     
                        <div class="grid grid-cols-5 gap-1" >
                            <div class="flex  flex-col col-span-1">
                                <label for="order">Order</label>
                                <input class="rounded focus:outline-none" type="number" wire:model="order.0">
                            </div>
                            <div class="flex  flex-col col-span-3">
                                <label for="step">Stappen</label>
                                <input class="rounded focus:outline-none" type="text" wire:model="step.0">
                            </div>
                            <div class="flex justify-center items-end col-span-1">
                                <button class="bg-green-400 rounded px-2 py-1 text-white" wire:click.prevent="addStep({{$stepIndex}})">Add</button>
                            </div>
                        
                        </div>
                        @foreach ($stepInputs as $key=>$value)
                        <div class="grid grid-cols-5 mt-1">
                            <div class="col-span-1 mr-1">
                                <input class="w-full rounded focus:outline-none" type="number" wire:model="order.{{$value}}">
                            </div>
                            <div class="col-span-3">
                                <input class="w-full rounded focus:outline-none" type="text" wire:model="step.{{$value}}">
                            </div>
                            <div class="flex justify-center items-center col-span-1">
                                <button class="bg-red-400 rounded px-2 py-1 text-white" wire:click.prevent="deleteStep({{$key}})">Delete</button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="my-3">
                        <button class="bg-indigo-400 text-white uppercase font-semibold rounded px-2 py-1" type="submit">Save</button>
                    </div>
                </form>
            </div>
     
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('addModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
         
        </x-slot>
    </x-jet-dialog-modal>
    {{-- end add  modal --}}

    {{-- start category modal --}}
    {{-- <x-jet-dialog-modal wire:model="">
        <x-slot name="title">
            <h3 class="text-xl font-semibold">{{ __('Voeg een categorie toe') }}</h3>
        </x-slot>

        <x-slot name="content">
            <div>
                <form class="flex flex-col gap-8" wire:submit.prevent="saveIngredientsAndSteps">
                    <div>
                        <div class="grid grid-cols-5 gap-1">
                            <div class="flex  flex-col col-span-2">
                                <label for="ingredient">Ingredient</label>
                                <input class="rounded focus:outline-none" type="text" wire:model="ingredient.0">
                            </div>
                            <div class="flex  flex-col col-span-2">
                                <label for="quantity">Hoeveelheid</label>
                                <input class="rounded focus:outline-none" type="text" wire:model="quantity.0">
                            </div>
                            <div class="col-span-1 flex justify-center items-end ">
                                <button class="bg-green-400 rounded px-2 py-1 text-white" wire:click.prevent="add({{$index}})">Add</button>
                            </div>
                        </div>
                        @foreach ($inputs as $key=>$value)
                        <div class="grid grid-cols-5 mt-1">
                            <div class="flex col-span-2">
                                <input class="w-full rounded focus:outline-none mr-1" type="text" wire:model="ingredient.{{$value}}">
                            </div>
                            <div class="flex col-span-2">
                                <input class="w-full rounded focus:outline-none " type="text" wire:model="quantity.{{$value}}">
                            </div>
                            <div class="col-span-1 flex justify-center items-center">
                                <button class="bg-red-400 rounded px-2 py-1 text-white" wire:click.prevent="delete({{$key}})">Delete</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                     <div>     
                        <div class="grid grid-cols-5 gap-1" >
                            <div class="flex  flex-col col-span-1">
                                <label for="order">Order</label>
                                <input class="rounded focus:outline-none" type="number" wire:model="order.0">
                            </div>
                            <div class="flex  flex-col col-span-3">
                                <label for="step">Stappen</label>
                                <input class="rounded focus:outline-none" type="text" wire:model="step.0">
                            </div>
                            <div class="flex justify-center items-end col-span-1">
                                <button class="bg-green-400 rounded px-2 py-1 text-white" wire:click.prevent="addStep({{$stepIndex}})">Add</button>
                            </div>
                        
                        </div>
                        @foreach ($stepInputs as $key=>$value)
                        <div class="grid grid-cols-5 mt-1">
                            <div class="col-span-1 mr-1">
                                <input class="w-full rounded focus:outline-none" type="number" wire:model="order.{{$value}}">
                            </div>
                            <div class="col-span-3">
                                <input class="w-full rounded focus:outline-none" type="text" wire:model="step.{{$value}}">
                            </div>
                            <div class="flex justify-center items-center col-span-1">
                                <button class="bg-red-400 rounded px-2 py-1 text-white" wire:click.prevent="deleteStep({{$key}})">Delete</button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="my-3">
                        <button class="bg-indigo-400 text-white uppercase font-semibold rounded px-2 py-1" type="submit">Save</button>
                    </div>
                </form>
            </div>
     
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('addModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
         
        </x-slot>
    </x-jet-dialog-modal> --}}
    {{-- end category modal --}}
</div>
