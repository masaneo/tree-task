@foreach($nodes as $node)
    <div id='node{{ $node->id }}' class='collapse' style='margin-left: 20px; display: block;'>
        <span>
            {{ $node -> name }}
            <button type="button" id="collapse-button" class='collapse-button' >-</button>
        </span>
        @if (count($node -> childs))
            @if(isset($sortOrder) && $sortOrder === 'asc')
                @include('treenodes', ['nodes' => $node -> childs -> sortBy('name')])
            @elseif(isset($sortOrder) && $sortOrder === 'desc')
                @include('treenodes', ['nodes' => $node -> childs -> sortByDesc('name')])
            @else
                @include('treenodes', ['nodes' => $node -> childs])
            @endif
        @endif
    </div>
@endforeach