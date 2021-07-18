<x-guest-layout>
    <div class="">
        <div class="mx-5 my-20 p-10 bg-gray-100 rounded">
            
            <div class="">
              <h3 class="text-center font-semibold text-2xl text-gray-500">Welkom bij mijn</h3>
              <h3 class="text-center font-semibold text-4xl text-gray-600">Receptenbeheersystem</h3>

              <div class="flex flex-col justify-center items-center mt-20 text-sm font-semibold">
                <p>Schrijf je in als je nieuw bent.</p>
                <p>Log in om door te gaan.</p>
              </div>

              <div class="flex justify-center items-center"> 
                    @if (Route::has('login'))
                    <div class=" px-6 py-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm uppercase  bg-gray-400 hover:bg-gray-600  text-white rounded px-2 py-1 font-semibold">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm uppercase  bg-gray-400 hover:bg-gray-600  text-white rounded px-2 py-1 font-semibold">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm uppercase  bg-gray-400 hover:bg-gray-600  text-white rounded px-2 py-1 font-semibold">Register</a>
                            @endif
                        @endauth
                    </div>
                    @endif
                </div>
 
           </div>
        </div>
    </div>
</x-guest-layout>