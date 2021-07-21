<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased ">
        <x-jet-banner />

        <div class="min-h-screen bg-blue-100">
            @livewire('navigation-menu')

  
            
<div class="p-3 flex flex-col  float-right mr-4">
    <h1 class="text-xs self-center font-semibold text-gray-600">Deel op sociale media </h1>
    <div>
        <a id="facebook"><i  style="color:#385898" class="text-2xl fab fa-facebook-square"></i></a>
        <a id="whatsapp"><i  style="color:#45ea64" class="text-2xl fab fa-whatsapp-square"></i></a>
        <a id="twitter"><i  style="color:#1da1f2" class="text-2xl fab fa-twitter-square"></i></a>
        <a id="pinterest"><i  style="color:#c62026" class="text-2xl fab fa-pinterest-square"></i></a>
        <a id="linkedin"><i style="color:#0a66c2" class="text-2xl fab fa-linkedin"></i></a>
    </div>
</div>



            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-blue-50 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>

    <script>
        const fbBtn = document.querySelector("#facebook");
        const twBtn = document.querySelector("#twitter");
        const waBtn = document.querySelector("#whatsapp");
        const liBtn = document.querySelector("#linkedin");
        const piBtn = document.querySelector("#pinterest");

        function init(){
            let postUrl = encodeURI(document.location.href);
            let postTitle = encodeURI("Dag iedereen, neem gerust een kijkje.");

            fbBtn.setAttribute('href', `https://www.facebook.com/sharer.php?u=${postUrl}`);
            twBtn.setAttribute('href', `https://twitter.com/share?url=${postUrl}&text=${postTitle}`);
            waBtn.setAttribute('href', `https://api.whatsapp.com/send?text=${postTitle}${postUrl}`);
            liBtn.setAttribute('href', `https://www.linkedin.com/shareArticle?url=${postUrl}&title=${postTitle}`);
            piBtn.setAttribute('href', `https://pinterest.com/pin/create/bookmarklet/?url=${postUrl}&description=${postTitle}`);
        }

        init();
    </script>
</html>
