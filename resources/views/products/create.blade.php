<form action="/produk" method="POST">
    @csrf

    <label>Nama Produk</label>
    <input type="text" name="nama_produk">

    <label>Kategori Produk</label>
    <select name="category_id">

        @foreach($categories as $category)

            <option value="{{ $category->id }}">
                {{ $category->nama_kategori }}
            </option>

        @endforeach

    </select>

    <button type="submit">
        Simpan
    </button>

</form>