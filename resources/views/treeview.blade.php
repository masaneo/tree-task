<html>
    <head></head>
    <body>
        <form action="submit" method="POST">
            @csrf
            <input type="text" name="name" placeholder="name">
            <input type="number" name="parentId" placeholder="parentId" min=0>
            <button type="submit">Dodaj</button>
        </form>

        
        @foreach($tree as $key => $row)
            @if ($row -> parentId === 0)
                {{$row -> id}}
                {{$row -> name}}
                {{$row -> parentId}}<br/>
            @endif
        @endforeach
        
    </body>
</html>