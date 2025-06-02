<div class="form-group">
    <label for="kategori_pengeluaran_id">Kategori Pengeluaran</label>
    <select name="kategori_pengeluaran_id" id="kategori_pengeluaran_id" class="form-control">
        <option value="">Pilih Kategori</option>
    </select>
</div>

@push('after_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ url('admin/ajax/kategori-pengeluaran') }}')
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById('kategori_pengeluaran_id');
                data.forEach(item => {
                    let option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama;
                    select.appendChild(option);
                });
            });
    });
</script>
@endpush
