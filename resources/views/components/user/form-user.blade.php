<div>
    <button type="button" class="btn {{ $id ? 'btn-warning' : 'btn-primary' }}" data-toggle="modal" data-target="#formUser{{ $id ?? '' }}">
        @if ($id)
            <i class="fas fa-edit"></i>
        @else
        Users Baru
        @endif
    </button>
    <div class="modal fade" id="formUser{{ $id ?? '' }}">
        <form action="{{ $id ? route('users.update', $id) : route('users.store') }}" method="POST">
            @csrf
            @if($id)
                @method('PUT')
            @endif
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id ? 'Form Edit User' : 'Form User Baru' }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group my-1">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                value="{{ old('email', $email ?? '') }}">
                        </div>
                        <div class="form-group my-1">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $name ?? '') }}">
                        </div>
                        <div class="form-group my-1">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="supervisor" {{ old('role', $role ?? '') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="perawat" {{ old('role', $role ?? '') == 'perawat' ? 'selected' : '' }}>Perawat</option>
                            </select>
                        </div>
                        @if(!$id)
                        <div class="form-group my-1">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                value="{{ old('password', '12345678') }}">
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
</div>