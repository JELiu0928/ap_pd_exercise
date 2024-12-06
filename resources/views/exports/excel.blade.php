@if($data->count() > 0)
<table>
    <thead>
        <tr>
           @foreach($data->first()->getattributes() as $key => $value)
            <th>{{ $key }}</th>
           @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $value)
        <tr>
            @foreach($value->getattributes() as $val)
                <td>{{ $val }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
@endif