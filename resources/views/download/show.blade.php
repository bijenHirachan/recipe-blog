<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="bg-blue-100">
    <div class="m-10 flex flex-col gap-10 md:grid grid-cols-9 ">
        <div class=" flex flex-col  items-center col-span-3 bg-blue-50 p-2 rounded">
            <h3 class="text-center text-3xl mb-5">Download het recept van <span class="font-bold"><a href="/download/recipe/{{$recipe->id}}">{{$recipe->recipe_name}}</a></span></h3>
            <img class="rounded w-96 h-72" src="{{asset('storage/photos/'.$recipe->image_path)}}" alt="">
        </div>
      
        
        <div class="md:mt-10 col-span-3 bg-blue-50 p-2 rounded">
            <h3 class="text-xl font-bold text-center text-gray-700">Benodigheden</h3>
            @foreach ($ingredients as $ingredient)
                <div class="flex justify-between font-semibold text-gray-800">
                    <div>{{$ingredient->ingredient}}</div><div>{{$ingredient->quantity}}</div>
                </div>
            @endforeach
        </div>

        <div class="md:mt-10 col-span-3 flex justify-center bg-blue-50 p-2 rounded">
            <div class="">
                <h3 class="text-xl font-bold text-center text-gray-700">Stappen</h3>
                @foreach ($steps as $key=>$value)
                    <div class="flex justify-between font-semibold text-gray-800">
                        <div>{{++$key}}. {{$value->step}}</div>
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>
      
    <a class="absolute bottom-10 right-5 font-bold text-blue-500 hover:text-blue-700" href="{{route('download-recipes')}}">Terug naar downloads</a>

    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>