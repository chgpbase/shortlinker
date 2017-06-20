@extends('main')
@section('main')
    <div class="links">
        Короткая ссылка: <a style="color:blue" href="{{ url('/') }}/{{ $shortLink->short_link }}">{{ url('/') }}/{{ $shortLink->short_link }}</a><br>
        Статистика: <a style="color:blue" href="{{ $shortLink->getStatisticUrl() }}">{{ $shortLink->getStatisticUrl() }}</a>
    </div>
@endsection
