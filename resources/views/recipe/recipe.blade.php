<!-- layout -->

<head>
    <title>Recipe</title>
</head>

<body>
    <h1>{{$recipe->title}}</h1>
    <p>{{$recipe->description}}</p>
    <div>
        <img src="{{asset('storage/'.$recipe->image_path)}}">
    </div>
</body>

@if(Auth::user()->id === $recipe->user_id)
<button>Edit</button>
<button>Delete</button>
@endif