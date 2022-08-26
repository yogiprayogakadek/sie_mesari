<div class="col-12">
    <form id="formAdd">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Member</div>
                <div class="card-options">
                    <button class="btn btn-info btn-data" type="button">
                        <i class="fa fa-eye"></i> Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control name" name="name" id="name" placeholder="masukkan nama">
                    <div class="invalid-feedback error-name"></div>
                </div>
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select name="gender" id="gender" class="form-control gender">
                        <option value="">Pilih jenis kelamin...</option>
                        <option value="1">Laki - Laki</option>
                        <option value="0">Perempuan</option>
                    </select>
                    <div class="invalid-feedback error-gender"></div>
                </div>
                <div class="form-group">
                    <label for="phone">No. Telp</label>
                    <input type="text" class="form-control phone" name="phone" id="phone" placeholder="masukkan no. telp">
                    <div class="invalid-feedback error-phone"></div>
                </div>
                <div class="form-group">
                    <label for="phone">Alamat</label>
                    <textarea name="address" id="address" class="form-control address" rows="6"></textarea>
                    <div class="invalid-feedback error-address"></div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-save pull-right" type="button">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>