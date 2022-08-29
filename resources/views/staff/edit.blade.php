<div class="col-12">
    <form id="formEdit">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Staff</div>
                <div class="card-options">
                    <button class="btn btn-info btn-data" type="button">
                        <i class="fa fa-eye"></i> Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input type="hidden" name="user_id" id="user_id" value="{{$staff->user_id}}">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control name" name="name" id="name" placeholder="masukkan nama" value="{{$staff->name}}">
                    <div class="invalid-feedback error-name"></div>
                </div>
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select name="gender" id="gender" class="form-control gender">
                        <option value="">Pilih jenis kelamin...</option>
                        <option value="1" {{$staff->gender == 1 ? 'selected' : ''}}>Laki - Laki</option>
                        <option value="0" {{$staff->gender == 0 ? 'selected' : ''}}>Perempuan</option>
                    </select>
                    <div class="invalid-feedback error-gender"></div>
                </div>
                <div class="form-group">
                    <label for="phone">No. Telp</label>
                    <input type="text" class="form-control phone" name="phone" id="phone" placeholder="masukkan no. telp" value="{{$staff->phone}}">
                    <div class="invalid-feedback error-phone"></div>
                </div>
                <div class="form-group">
                    <label for="phone">Alamat</label>
                    <textarea name="address" id="address" class="form-control address" rows="6">{{$staff->address}}</textarea>
                    <div class="invalid-feedback error-address"></div>
                </div>
                <div class="form-group">
                    <label for="user">Username</label>
                    <input type="text" class="form-control user" name="user" id="user" placeholder="masukkan username" value="{{$staff->user->username}}">
                    <div class="invalid-feedback error-user"></div>
                </div>
                <div class="form-group">
                    <label for="current-password">Password Sekarang</label>
                    <input type="password" class="form-control current_password" name="current_password" id="current-password" placeholder="masukkan password sekarang">
                    <div class="invalid-feedback error-current_password"></div>
                </div>
                <div class="form-group">
                    <label for="new-password">Password Baru</label>
                    <input type="password" class="form-control new_password" name="new_password" id="new-password" placeholder="masukkan password baru">
                    <div class="invalid-feedback error-new_password"></div>
                </div>
                <div class="form-group">
                    <label for="confirmation-password">Re-Password</label>
                    <input type="password" class="form-control confirmation_password" name="confirmation_password" id="confirmation-password" placeholder="masukkan konfirmasi password">
                    <div class="invalid-feedback error-confirmation_password"></div>
                </div>
                <div class="form-group">
                    <label for="image">Foto</label>
                    <input type="file" class="form-control image" name="image" id="image" placeholder="masukkan image">
                    <span class="text-muted text-small">*kosongkan jika tidak ingin mengganti foto</span>
                    <div class="invalid-feedback error-image"></div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-update pull-right" type="button">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>