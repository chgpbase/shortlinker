@extends('main')
@section('main')
<div class="form">
    <form method="post" action="{{ route('shorten') }}">
        {{ csrf_field() }}
        @if(isset($invalid))
            @foreach($invalid as $field)
                @foreach($field as $value)
                <span style="color:red">{{ $value }}</span><br>
                @endforeach
            @endforeach
        @endif
        <input type="text" id="url" name="url" placeholder="http://example.com/example/" size="100"/><input type="submit" value="Сократить"/>
        <br><label for="life_to">Срок действия до</label><input type="date" name="life_to"/>
    </form>
</div>
@endsection