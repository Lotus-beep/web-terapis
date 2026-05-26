@extends('layouts.admin')
@section('title','Kelola Users')
@section('page-title','Kelola Users')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Daftar Users</h6>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah User</a>
        </div>
        <form class="row g-2 mt-2" method="GET">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari username/email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <option value="customer" {{ request('role')=='customer'?'selected':'' }}>Customer</option>
                    <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                    <option value="terapis" {{ request('role')=='terapis'?'selected':'' }}>Terapis</option>
                </select>
            </div>
            <div class="col-auto"><button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-search"></i></button></div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Username</th><th>Email</th><th>No. Telepon</th><th>Role</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_telepon ?? '-' }}</td>
                        <td>
                            @php $rc=['admin'=>'danger','terapis'=>'info','customer'=>'success']; @endphp
                            <span class="badge bg-{{ $rc[$user->role_users] ?? 'secondary' }}">{{ ucfirst($user->role_users) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data user</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $users->withQueryString()->links() }}</div>
</div>
@endsection
