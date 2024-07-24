<table>
    <thead>
        <tr>
            @foreach($titles as $title)
                <th>{{ $title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                @foreach($titles as $title)
                    <td>{{ $row->$title }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>