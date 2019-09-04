@if($error)
    <div>
        {{ $error }}
    </div>
@elseif(!$items)
    <div>
        <span>No results</span>
    </div>
@else
    @foreach($items as $item)
        <div>
            <a href="{{$item->url}}">{{$item->name}}</a>
            <span> Stars: {{$item->stargazers_count}} </span>
            <span> Forks: {{$item->forks_count}} </span>
            <span> Size: {{$item->size}} </span>
            <hr>
        </div>
    @endforeach
@endif