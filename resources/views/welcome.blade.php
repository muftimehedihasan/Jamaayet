<!DOCTYPE html>
<html>

<head>
    <title>All dreams</title>
</head>

<body>
  
    @forelse ($dreams as $dream)
        <h1>{{ $dream->content }}</h1>
        <pre>- by {{$dream->name}}</pre>
        <small>{{ $dream->created_at->diffForHumans()}}</small>
        @empty
        <pre>No items found.</pre>
    @endforelse



</body>

</html>