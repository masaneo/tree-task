@foreach($nodes as $node)
    <div id='node{{ $node->id }}' class='collapse' style='margin-left: 20px; display: block;'>
        <span>
            {{ $node -> name }}
            <button type="button" id="collapse-button" class='collapse-button' >-</button>
        </span>
        @if (count($node -> childs))
            @include('treenodes', ['nodes' => $node -> childs])
        @endif
    </div>
@endforeach