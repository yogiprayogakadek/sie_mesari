<div class="col-12">
    <form id="formEdit">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Kategori</div>
                <div class="card-options">
                    <button class="btn btn-info btn-data" type="button">
                        <i class="fa fa-eye"></i> Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input type="hidden" name="id" id="id" value="{{$category->id}}">
                    <label for="name">Nama Kategori</label>
                    <input type="text" class="form-control name" name="name" id="name" placeholder="masukkan nama kategori" value="{{$category->name}}">
                    <div class="invalid-feedback error-name"></div>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                        <select name="status" id="status" class="form-control status">
                            <option value="">Pilih Status</option>
                            <option value="1" {{$category->status == 1 ? 'selected' : ''}}>Aktif</option>
                            <option value="0" {{$category->status == 0 ? 'selected' : ''}}>Tidak Aktif</option>
                        </select>
                        <div class="invalid-feedback error-status"></div>
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