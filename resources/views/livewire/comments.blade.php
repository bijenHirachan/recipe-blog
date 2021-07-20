<div class="w-full p-3 " x-data="{showComments:false}">
    <form wire:submit.prevent="addComment">
        <div>
            <div class="py-3 flex justify-between items-center">
                <h2 class="text-sm font-semibold">Geef een aantal sterren</h2>
                <div class="flex">
                    @foreach (range(1,5) as $item)
                    <div>
                        <svg 
                            wire:click="selectStar({{$item}})" 
                            xmlns="http://www.w3.org/2000/svg" 
                            class="h-6 w-6 text-yellow-400 cursor-pointer hover:text-yellow-800" 
                            fill="{{ $starSelected >= $item ? 'gold': 'white'}}" 
                            viewBox="0 0 24 24" stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    @endforeach
                   
                 </div>
               
            </div>
        </div>
        <h2>Schrijf je reactie:</h2>
        <div>
            <textarea  class="w-full focus:outline-white rounded" wire:model="comment"></textarea>
        </div>

        <div class="flex justify-end">
            <input @click="showComments = !showComments" class="bg-blue-200 font-semibold rounded uppercase px-2 py-1 cursor-pointer " type="submit" value="Post">
        </div>
    </form>
    <div class="text-xs font-semibold underline ">
        <span @click="showComments =! showComments" class="cursor-pointer">{{count($comments)}} Comments</span>
    </div>
    <div x-show="showComments" class="relative">
        @if (count($comments) > 0)
            @foreach ($comments as $comment)
                <div class="bg-blue-100 p-2 rounded mt-1 ">
                    <div class="flex justify-between">
                        <span class="font-semibold text-sm">{{$comment->user->name}}</span>
                        <div class="flex">
                        @foreach (range(1,5) as $item)
                            <svg 
                                xmlns="http://www.w3.org/2000/svg" 
                                class="h-3 w-3 text-yellow-400 cursor-pointer" 
                                fill="{{ $comment->stars >= $item ? 'gold': 'white'}}" 
                                viewBox="0 0 24 24" stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            @endforeach
                        </div>
                    
                    </div>
                    
                    <p class="text-xs">{{$comment->comment_body}}</p>
                </div>
            @endforeach 
        @endif
       
    </div>
   
</div>
