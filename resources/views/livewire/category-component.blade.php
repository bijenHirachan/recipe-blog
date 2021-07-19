
<div>
    <div class="flex flex-col gap-2 md:flex-row md:gap-24">
        <div class="w-1/4">
            <form wire:submit.prevent="addCategory" class="flex ">
                <div class="flex flex-col">
                    <label for="category" class="font-bold text-xl">Voeg een categorie toe</label>
                    <input class="focus:outline-none rounded" id="category" type="text" wire:model.lazy="name">
                </div>
                <input class="self-end justify-self-center bg-blue-400 rounded px-2 py-1 ml-1 mb-1 text-white font-semibold" type="submit" value="Add">
            </form>
        </div>
        
        <div class="w-3/4 p-4 flex flex-wrap">
            @forelse ($categories as $category)
            <div class="flex items-center bg-yellow-500 m-1 px-2 py-1">
                <span class="cursor-pointer" wire:click="addToList({{$category->id}})" >{{$category->category}}</span>
                <span>
                    <svg wire:click="deleteCategory({{$category->id}})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                </span>
            </div>
                
            @empty
            
                <h4 class="text-center">Geen categorieën gevonden!</h4>
            @endforelse
        </div>
    
    
    
    </div>

    <div class="grid grid-cols-2 my-5"> 
        <div>
            <div class="flex flex-col w-2/4" >
                <label for="" class="font-bold text-xl">Selecteer Recept</label>
                <select class="rounded-lg text-gray-700 " multiple="multiple" data-placeholder="Select a categorie">
                    @foreach ($recipes as $recipe)
                        <option class="font-bold" wire:click="selectRecipe({{$recipe->id}})" value="{{$recipe->id}}">{{$recipe->recipe_name}}</option>
                    @endforeach
                </select>
            </div>
        
            {{-- <div class="flex flex-col w-2/4" >
                <label for="">Select categories</label>
                <select class="rounded dropdown" multiple="multiple" data-placeholder="Select a categorie">
                    @foreach ($categories as $category)
                        <option wire:click="addToList({{$category->id}})" value="{{$category->id}}">{{$category->category}}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>

        <div class="flex flex-col gap-5">
            <div class="grid grid-cols-4">
                <div class="bg-indigo-400 flex flex-col items-center rounded col-span-3">
                        <h3 class="font-bold">Geselecteerd Recept</h3>
                    @if ($selectedRecipe)
                        <h3 class="text-xl">{{$selectedRecipe}}</h3>
                    @else
                        <h3 class="text-xl">Niets geselecteerd</h3>
                    @endif
                </div>
                <div class="col-span-1">
                    <button class="bg-red-400 rounded p-2 ml-2 font-semibold text-white" wire:click.prevent="addCategoriesToRecipe">Categorieën toevoegen</button>
                </div>
            </div>
            <div class="flex flex-wrap">
                @if (count($selectedCategories) > 0)
                    @foreach ($selectedCategories as $key=>$value)
                        <div class="flex items-center bg-green-500 m-1 px-2 py-1">
                            <span>{{$value}}</span>
                            <span>
                                <svg wire:click="removeFromList({{$key}})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
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

