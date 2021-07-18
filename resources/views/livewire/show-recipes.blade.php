<div>
    @foreach ($recipes as $recipe)
        <div class="flex flex-col md:grid grid-cols-2 my-2 md:p-5 bg-gray-100 rounded-lg" >
            <div wire:click="showModal({{$recipe->id}})" class="cursor-pointer overflow-none bg-blue-100 rounded">
             
                <div class="p-4" wire:click="showModal({{$recipe->id}})">
                    <img class="w-auto rounded-lg" src="{{asset('storage/photos/'.$recipe->image_path)}}" alt="">
                </div>
                <div class="p-4 flex flex-col items-center justify-center">
                    <h3 class="text-2xl font-semibold">{{$recipe->recipe_name}}</h3>
                    <p class="text-lg">{{$recipe->description}}</p>
                </div>
            </div>
           
            <div class="">
            
                <div>

                    @livewire('comments',['recipeId'=> $recipe->id], key($recipe->id))
                </div>
                    
            </div>
            

        </div>
    @endforeach

   
    {{-- show single modal --}}
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h3 class="text-3xl font-semibold">{{ $modalRecipe }}</h3>
            {{-- <div>
                <span>Categories</span>
                @foreach ($categories as $category)
                    <h3>{{$category->category_id}}</h3>
                @endforeach
            </div> --}}
        </x-slot>

        <x-slot name="content">

          <div class="bg-gray-100 rounded-lg font-semibold text-sm p-1">
              <h4>{{$modalDescription}}</h4>
          </div>
          <div class="bg-gray-100 p-2 my-2 rounded-lg">
              <img class="rounded-lg" src="{{asset('storage/photos/'.$modalPhoto)}}" alt="">
          </div>
          <div class="grid grid-cols-2 my-2">
              <div class="bg-gray-100 rounded-lg p-2 mr-1">
                <h3 class="font-semibold text-center mb-1">Benodigheden</h3>
                @foreach ($ingredients as $ingredient )
                <div class="flex justify-between">
                    <h2 class="flex items-center gap-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                      </svg> 
                      {{$ingredient->ingredient}}
                    </h2>
                    <h2>{{$ingredient->quantity}}</h2>
                </div>
                @endforeach
              </div>
              <div class="bg-gray-100 rounded-lg p-2 ml-1">
                <h3 class="font-semibold text-center mb-1">Stappen</h3>
                <div>
                    @foreach ($steps as $key=>$step )
                    <div class="flex gap-2">
                        <h2 class="font-bold"> {{++$key}}</h2>
                        <h2>{{$step->step}}</h2>
                    </div>
                    @endforeach
                </div>
                
              </div>
          </div>
          
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
         
        </x-slot>
    </x-jet-dialog-modal>
    {{-- end show single modal --}}
</div>
