<div>
    @foreach ($recipes as $recipe)
        <div class="flex flex-col md:grid grid-cols-2 my-2 md:p-5 bg-gray-100 rounded-lg" >
        
            <div wire:click="showModal({{$recipe->id}})" class="cursor-pointer overflow-none bg-blue-100 rounded">
                              
                <div class="p-2  flex  items-center justify-between">
                    <h3 class="ml-2 text-2xl font-semibold">{{$recipe->recipe_name}}</h3>
                    {{-- {{dd($avgStars)}} --}}
                    <div class="flex ">
                        {{-- @foreach ($avgStars as $key=>$value)
                            @if ($key === $recipe->id)
                                @foreach (range(1,5) as $item)
                                <div>
                                    <svg 
                                        xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5 text-blue-300 cursor-pointer" 
                                        fill="{{$item <= $value ? 'gold':''}}" 
                                        viewBox="0 0 24 24" stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                @endforeach
                            @endif
                        @endforeach --}}
                    
                       
                     </div>
                </div>
                <div class=" px-4" wire:click="showModal({{$recipe->id}})">
                    <img class="w-auto rounded-lg" src="{{asset('storage/photos/'.$recipe->image_path)}}" alt="">
                    <p class="text-sm text-center font-semibold">{{$recipe->description}}</p>
                
                </div>
                @if (count($recipe->categories) > 0)
                <div class="flex items-center mx-5 px-4 pb-2 pt-1">
                    <div class="flex flex-wrap items-center text-xs gap-2 ml-2 font-semibold" >
                        
                        <h3 class="text-sm font-semibold ">Categorieën :</h3>

                        @foreach ($recipe->categories as $item)
                        <p class="text-xs underline">{{$item->category}}</p>
                        @endforeach
                    </div>
                    
                </div>
                @endif
             
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
            <div>
                <span class="text-sm font-semibold">Categorieën:</span>
                @if (count($modalRecipeForCategories)>0)
                    @forelse ($modalRecipeForCategories as $item)
                    <span class="text-gray-800 text-xs">{{$item->category}}</span>
                        
                    @empty
                        <p>Geen categorieën</p>
                    @endforelse ()
                   
                @endif
            
            </div>
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
