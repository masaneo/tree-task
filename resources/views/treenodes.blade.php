<ul>
    @foreach($nodes as $node)
        <li>
            {{$node -> name}}

            @if (count($node -> childs))
                @include('treenodes', ['nodes' => $node -> childs])
            @endif
        </li>
    @endforeach
</ul>