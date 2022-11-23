<table class="table">
    <thead>
        <tr>
            <th>image</th>
            <th>name</th>
            <th>description</th>
            <th>price</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d )
        <tr>
            <td>
                @foreach($d->image as $m)
                <img class="img-size" src="{{ asset('uploads').'/'.$m->image }}">
                @endforeach
            </td>
            <td>{{ $d->product_name }}</td>
            <th>{!! $d->product_description !!}</th>
            <th>{{ $d->product_price }}</th>
            <th>
                <button class="btn btn-sm btn-danger" onclick="_delete('{{ $d->id }}')">delete</button>
                <button class="btn btn-sm btn-primary" onclick="edit('{{ $d->id }}')">edit</button>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>