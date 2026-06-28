<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Customer</th>
            <th>Layanan</th>
            <th>Terapis</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
    @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->booking_code }}</td>
            <td>{{ $booking->user->name }}</td>
            <td>{{ $booking->service->name }}</td>
            <td>{{ $booking->therapist->name }}</td>
            <td>{{ $booking->status }}</td>
            <td>{{ $booking->booking_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>