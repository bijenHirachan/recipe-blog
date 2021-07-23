<div class="m-10">

  
    <div class="">
        <div class="flex flex-col sm:flex-row gap-3 justify-center   lg:justify-between  px-2">
            <input class="rounded bg-blue-100" type="search" wire:model.debounce.1000ms="search" placeholder="Zoek recept" >
            <button class="bg-yellow-500 ml-1 px-2 py1 rounded font-semibold text-gray-100 hover:bg-yellow-400" wire:click="showRecipeModal">Voeg een recept toe</button>
        </div>
        
     <div>
        

                <!--desktop view -->
        <div class="hidden lg:block w-full p-2">

            <table class="w-full">
                <thead class="w-full">
                    <tr class="grid grid-cols-12 text-left bg-blue-100">
                        <th class="py-1 col-span-1 border-2 border-gray-500 flex justify-center items-center">ID</th>
                        <th class="py-1 col-span-2 border-2 border-gray-500 flex justify-center items-center">Foto</th>
                        <th class="py-1 col-span-2 border-2 border-gray-500 flex justify-center items-center">Recept</th>
                        <th class="py-1 col-span-4 border-2 border-gray-500 flex justify-center items-center">Omschrijving</th>
                        <th class="py-1 col-span-3 border-2 border-gray-500 flex justify-center items-center">Actie</th>
                    </tr>
                </thead> 
                <tbody class="w-full">
                    @forelse ($recipes as $recipe)
                        <tr class="grid grid-cols-12 ">
                            <td class="col-span-1 border-2 border-gray-400  flex justify-center items-center">{{$recipe->id}}</td>
                            <td class="col-span-2 border-2 border-gray-400 py-2 flex justify-center items-center"><img class="w-36 h-24 rounded" src="{{asset('storage/photos/'.$recipe->image_path)}}" alt=""></td>
                            <td class="col-span-2 border-2 border-gray-400 pl-2 flex justify-start items-center">{{$recipe->recipe_name}}</td>
                            <td class="col-span-4 border-2 border-gray-400 pl-2 flex justify-start items-center">{{substr($recipe->description, 0, 100)}}..</td>
                            <td class="col-span-3 border-2 border-gray-400 flex flex-col justify-center ">
                                <button class="bg-green-400 mx-2 my-1 rounded font-bold text-gray-100 hover:bg-green-600" wire:click="editRecipe({{$recipe->id}})">Edit</button>
                                <button class="bg-red-400 mx-2 my-1 rounded font-bold text-gray-100 hover:bg-red-600" wire:click="confirmDeleteRecipe({{$recipe->id}})">Delete</button>
                                <button class="bg-indigo-400 mx-2 my-1 rounded font-bold text-gray-100 hover:bg-indigo-600" wire:click="addIngredientsAndSteps({{$recipe->id}})">Add ingredients and steps</button>
                            </td>
                        </tr>
                    @empty
                       <tr class="my-3 text-2xl text-center">
                        <td class="pt-4">Geen recepten gevonden!</td>
                       </tr>
                    @endforelse
                </tbody>
            </table> 


        </div>


         {{-- mobile view --}}
        <div class="mt-3 lg:hidden flex flex-col">
            @forelse ($recipes as $recipe)
                <div class="bg-blue-100 mb-2 rounded p-5 self-center">
                    <div class="flex flex-col"><div class="font-bold">{{$recipe->recipe_name}}</div></div>
                    <div class="flex flex-col"><div ><img class="rounded w-96 h-64" src="{{asset('storage/photos/'.$recipe->image_path)}}" alt=""></div></div>
                    <div class="my-2">{{substr($recipe->description, 0, 100)}}..</div>     
                    <div class="flex gap-4">
                        <button class="font-bold text-green-500 hover:text-green-800" wire:click="editRecipe({{$recipe->id}})">Edit</button>
                        <button class="font-bold text-red-500 hover:text-red-800" wire:click="confirmDeleteRecipe({{$recipe->id}})">Delete</button>
                        <button class="font-bold text-indigo-500 hover:text-indigo-800" wire:click="addIngredientsAndSteps({{$recipe->id}})">Add ingredients and steps</button>
                    </div>
               
              
                </div>

            @empty
            <div>
                <h3 class="text-center text-2xl">Geen recepten gevonden!</h3>
            </div>
            @endforelse
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
                    @if ($updatedPhoto)
                    Photo Preview:
                    <img class="w-36 h-24" src="{{ $updatedPhoto->temporaryUrl() }}">
                    <div class="absolute top-0 right-1">
                        <svg wire:click ="cancelPhoto"  xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    @endif
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
                @if ($modalId)
                    <form wire:submit.prevent="updateRecipe">
                        <div class="flex my-2">
                        
                            <label for="photo" class="w-36 font-bold hover:text-gray-400 cursor-pointer">Upload Foto</label>
                            <input type="file" id="photo" wire:model.lazy="updatedPhoto" hidden>
                            @error('updatedPhoto') <span class="error my-2 text-xs text-red-600">{{ $message }}</span> @enderror
                            
                        
                        </div>
                        <div  class="flex flex-col ">
                            <label for="recipe">Recept</label>
                            <input type="text" wire:model.lazy="recipe" class="focus:outline-none rounded">
                            @error('recipe') <span class="error my-2 text-xs text-red-600">{{ $message }}</span> @enderror
                        
                        </div>
                        <div class="flex flex-col focus:outline-none">
                            <label for="description">Omschrijving</label>
                            <textarea wire:model.lazy="description" cols="30"  class="focus:outline-none overflow-y-scroll rounded"></textarea>
                            @error('description') <span class="error my-2 text-xs text-red-600">{{ $message }}</span> @enderror
                        
                        </div>
                    
                        <button type="submit" class="mt-3 px-2 py-1 bg-blue-500 text-gray-50 rounded">
                            Update
                      </button>
                    </form>
                @else
                    <form wire:submit.prevent="saveRecipe">
                        <div class="flex my-2">
                        
                            <label for="photo" class="w-36 font-bold hover:text-gray-400 cursor-pointer">Upload Foto</label>
                            <input type="file" id="photo" wire:model.lazy="photo" hidden>
                            @error('photo') <span class="error my-2 text-xs text-red-600">{{ $message }}</span> @enderror
                            
                        
                        </div>
                        <div  class="flex flex-col ">
                            <label for="recipe">Recept</label>
                            <input type="text" wire:model.lazy="recipe" class="focus:outline-none rounded">
                            @error('recipe') <span class="error my-2 text-xs text-red-600">{{ $message }}</span> @enderror
                        
                        </div>
                        <div class="flex flex-col focus:outline-none">
                            <label for="description">Omschrijving</label>
                            <textarea wire:model.lazy="description" cols="30"  class="focus:outline-none overflow-y-scroll rounded"></textarea>
                            @error('description') <span class="error my-2 text-xs text-red-600">{{ $message }}</span> @enderror
                        
                        </div>
                    
                      <button type="submit" class="mt-3 px-2 py-1 bg-blue-500 text-gray-50 rounded">
                            Save
                      </button>
                    </form>
                
                
                @endif
           
           
          
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('recipeModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
         
        </x-slot>
    </x-jet-dialog-modal>
    {{-- end create/update modal --}}



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
                    <div class="flex flex-col sm:flex-row justify-between">
                                             
                            <h2 class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg> 
                                {{$ingredient->ingredient}}
                            </h2>
                            <div class="flex gap-1">
                                <h2 class="text-green-500 ml-4">{{$ingredient->quantity}}</h2>
                                <div>
                                    <svg wire:click="deleteAddedIngredient({{$ingredient->id}})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-700 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                <svg wire:click="deleteAddedStep({{$step->id}})" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer text-red-500 hover:text-red-700 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

            {{-- form to add more --}}
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
                                <button class="bg-green-400 hover:bg-green-500 rounded px-2 py-1 text-white" wire:click.prevent="add({{$index}})">Add</button>
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
                                <button class="bg-red-400 hover:bg-red-500 rounded px-2 py-1 text-white" wire:click.prevent="delete({{$key}})">Delete</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="my-3">
                        <button class="bg-indigo-400 hover:bg-indigo-500 text-white uppercase font-semibold rounded px-2 py-1" type="submit">Save</button>
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
                                <button class="bg-green-400 hover:bg-green-500 rounded px-2 py-1 text-white" wire:click.prevent="addStep({{$stepIndex}})">Add</button>
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
                                <button class="bg-red-400 hover:bg-red-500 rounded px-2 py-1 text-white" wire:click.prevent="deleteStep({{$key}})">Delete</button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="my-3">
                        <button class="bg-indigo-400 hover:bg-indigo-500 text-white uppercase font-semibold rounded px-2 py-1" type="submit">Save</button>
                    </div>
                </form>
            </div>
     
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('addModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
         
        </x-slot>
    </x-jet-dialog-modal>
    {{-- end add  modal --}}


    {{-- delete modal --}}
    <x-jet-confirmation-modal wire:model="deleteModal">
        <x-slot name="title">
            {{ __('Verwijderen') }} recept #{{$deleteId}}
        </x-slot>

        <x-slot name="content">
            {{ __('Weet je zeker dat je dit recept wilt verwijderen?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                {{ __('Annuleren') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteRecipe({{$deleteId}})" wire:loading.attr="disabled">
                {{ __('Verwijderen') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
