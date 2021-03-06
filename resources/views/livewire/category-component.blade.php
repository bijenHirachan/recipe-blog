
<div class="py-10">
   

    <div class="flex flex-col gap-2 md:flex-row md:gap-24 mb-10 bg-blue-100 p-5 rounded">
        <div class="w-full md:w-2/5 ">
            <form wire:submit.prevent="addCategory" class="flex justify-center">
                <div class="flex flex-col ">
                    @error('name')
                        <span class="text-xs text-red-600">{{$message}}</span>
                    @enderror
                    <label for="category" class="font-bold text-xl">Voeg een categorie toe</label>
                    <input class="focus:outline-none rounded h-full" id="category" type="text" wire:model.lazy="name">
                </div>
                <button class="self-end justify-self-center h-full bg-blue-400 cursor-pointer hover:bg-blue-500 rounded px-2 py-1 ml-1 mb-1 text-white font-semibold" type="submit">Add</button>
            </form>
        </div>
        
        <div class="w-full md:w-3/5 ">
            <h2 class="text-center text-3xl mb-3">Onze Categorieën</h2>
            <div class="flex flex-wrap items-center justify-center">
                @forelse ($categories as $category)
                <div class="flex items-center bg-yellow-500 m-1 px-2 py-1">
                    <span class="cursor-pointer" wire:click="addToList({{$category->id}})" >{{$category->category}}</span>
                    <span>
                        <svg wire:click="deleteCategory({{$category->id}})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    </span>
                </div>
                    
                @empty
                
                    <h4 class="text-center">Geen categorieën gevonden!</h4>
                @endforelse
            </div>
            
        </div>
    
    
    
    </div>

    <div class="flex flex-col md:flex-row my-5 bg-blue-100 rounded p-5 items-center"> 
   
        <div class="flex flex-col  my-4 w-full md:w-1/2" >
            <h2 class="font-bold p-2">Selecteer recept uit onze lijst</h2>
            <div class="flex flex-wrap">
                @foreach ($recipes as $key=>$recipe)
                <div class="self-center text-center bg-pink-300 hover:bg-pink-500 cursor-pointer font-semibold px-2 py-1 rounded m-1" wire:click="selectRecipe({{$recipe->id}})">{{++$key}}. {{$recipe->recipe_name}}</div>
                @endforeach
            </div>

            <div class="p-3 ">

                @if ($selectedRecipe)
                {{-- {{count($selectedRecipe->categories)}} --}}
                    @if (count($selectedRecipe->categories) > 0)
                        <h2 class="text-sm text-gray-800"><span class="text-green-600 font-semibold">{{$selectedRecipe->recipe_name}}</span> is gecategoriseerd als</h2>
                        <div class="flex">
                            @foreach ($selectedRecipe->categories as $category)
                                <div class="text-sm font-semibold text-gray-800 mr-1 px-2 py-1 bg-green-300 flex">
                                    <span>{{$category->category}}</span> 
                                    <span>
                                        <svg wire:click="deleteCategoryFromRecipe({{$selectedRecipe->id}},{{$category->id}})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div> 
                            @endforeach
                        </div>
                    @endif
                    
                @endif
           
            </div>
           
        </div>
        
      
        <div class="flex flex-col justify-center gap-5 my-4 w-full md:w-1/2">
            <div class="flex">
                <div class=" flex flex-col items-center rounded w-1/2">
                        <h3 class="font-bold">Geselecteerd Recept</h3>
                    @if ($selectedRecipe)
                        <h3 class="text-xl">{{$selectedRecipe->recipe_name}}</h3>
                    @else
                        <h3 class="text-xl">Niets geselecteerd</h3>
                    @endif
                </div>
                <div class="w-1/2">
                    <button class="bg-red-400 hover:bg-red-500 rounded p-2 ml-2 font-semibold text-white" wire:click.prevent="addCategoriesToRecipe">Categorieën toevoegen</button>
                </div>
            </div>

            {{-- session messages as validations --}}
            <div>
                @if (session()->has('failure'))
                <span class="text-sm text-red-500">{{session('failure')}}</span>   
                @elseif (session()->has('success'))
                        <span class="text-sm text-green-500">{{session('success')}}</span>   
                @elseif (session()->has('catExist'))
                    <span class="text-sm text-red-500">{{session('catExist')}}</span>   
                @endif
            </div>


            <div class="flex flex-wrap">
                
             
                @if (count($selectedCategories) > 0)
                    @foreach ($selectedCategories as $key=>$value)
                        <div class="flex items-center bg-green-500 m-1 px-2 py-1">
                            <span>{{$value}}</span>
                            <span>
                                <svg wire:click="removeFromList({{$key}})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    
    </div>
    
</div>

