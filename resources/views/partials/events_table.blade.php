@foreach ($data as $event)
    <tr>
        <th scope="row">
            <a href="#">{{ $event->no_notice }}</a>
        </th>
        <td>{{ $event->no_polisi }}</td>
        <td>
            {{ $event->nama }}
        </td>
        <td>{{ $event->alamat }}</td>
        <td>
            {{ formatrupiah($event->total_pajak) }}
        </td>
        <td>
            {{ $event->keterangan }}
        </td>
        <td class="text-center">
            <i class="bi bi-pencil-square"></i>
        </td>
@endforeach
