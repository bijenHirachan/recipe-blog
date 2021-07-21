<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Downloads</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

</head>
<body class="bg-blue-100">
   
    <div class="m-10">
        <h4 class="text-center text-3xl font-semibold text-gray-800">Onze Recepten</h4>

        <p class="my-5 text-center font-semibold text-gray-700 text-lg">Selecteer een recept om te downloaden</p>
        
        <div class="flex gap-3 flex-wrap justify-center">
            @foreach ($recipes as $recipe)
            <div class="flex flex-col bg-blue-50 rounded">
                <img class="w-36 h-24 rounded-t" src="{{asset('storage/photos/'.$recipe->image_path)}}" alt="">
                
                <div class="w-36 flex items-center justify-center">
                    <a class=" px-2 py-1 text-gray-500 font-semibold hover:text-gray-900 text-center" href="/download/{{$recipe->id}}">{{$recipe->recipe_name}}</a>
                </div>
            </div>
            @endforeach
        </div>
        
        
    </div>
    <a class="absolute bottom-10 right-5 font-bold text-blue-500 hover:text-blue-700" href="{{route('dashboard')}}">Terug naar recepten</a>

    <script src="{{asset('js/app.js')}}"></script>

</body>
</html>