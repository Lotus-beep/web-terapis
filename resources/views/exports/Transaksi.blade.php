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
            <td>{{ $booking->id }}</td>
            <td>{{ $booking->customer->username }}</td>
            <td>{{ $booking->service->name }}</td>
            <td>{{ $booking->terapis->usernames }}</td>
            <td>{{ $booking->status_payment }}</td>
            <td>{{ $booking->date_booking }}</td>
        </tr>
    @endforeach
    </tbody>
</table>