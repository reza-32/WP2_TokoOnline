<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $judul }}</h5>

                <form
                    action="{{ $user->exists ? route('backend.user.update', $user->id) : route('backend.user.store') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if ($user->exists)
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input id="nama" name="nama" type="text" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                        @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="0" @selected(old('role', $user->role ?? 0) == 0)>Admin</option>
                            <option value="1" @selected(old('role', $user->role) == 1)>Super Admin</option>
                            <option value="2" @selected(old('role', $user->role) == 2)>Customer</option>
                        </select>
                        @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="1" @selected(old('status', $user->status ?? 1) == 1)>Aktif</option>
                            <option value="0" @selected(old('status', $user->status) == 0)>Nonaktif</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="hp">Nomor HP</label>
                        <input id="hp" name="hp" type="text" class="form-control" maxlength="13" value="{{ old('hp', $user->hp) }}">
                        @error('hp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password {{ $user->exists ? '(kosongkan jika tidak diubah)' : '' }}</label>
                        <input id="password" name="password" type="password" class="form-control" @required(!$user->exists)>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" @required(!$user->exists)>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto</label>
                        @if ($user->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/img-user/'.$user->foto) }}" alt="Foto {{ $user->nama }}" width="80">
                            </div>
                        @endif
                        <input id="foto" name="foto" type="file" class="form-control-file" accept="image/*">
                        @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('backend.user.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
