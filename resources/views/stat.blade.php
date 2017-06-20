@extends('main')
@section('main')
    <h1 class="title">Статистика переходов</h1>
    <div class="table">
        <table cellpadding="5" cellspacing="0" border="1">
            <tr>
                <th>Дата, время</th>
                <th>Страна</th>
                <th>Город</th>
                <th>User-agent</th>
            </tr>
    @foreach($data as $item)
        <tr>
            <td>{{$item->created_at->format('d.m.Y H:i:s')}}</td>
            <td>{{ $item->country }}</td>
            <td>{{ $item->city }}</td>
            <td>{{ $item->user_agent }}</td>
        </tr>
    @endforeach
</table>
</div>
@endsection