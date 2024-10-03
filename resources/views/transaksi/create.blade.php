@extends('layout.main')

@section('title', 'Transaksi')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="mb-2">Kasir</h1>
                </div>
            </div>
        </div>
    </div>

    @php
    $rolePrefix = auth()->user()->hasRole('kasir') ? 'kasir' : (auth()->user()->hasRole('manager') ? 'manager' : 'admin');
    @endphp

    <section class="content">
        <div class="container-fluid">
            <form id="transaction-form" action="{{ route($rolePrefix . '.transaksi.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="no_transaksi">No Transaksi</label>
                    <input type="text" name="no_transaksi" id="no_transaksi" class="form-control" required readonly>
                </div>

                <div class="form-group">
                    <label for="barang_id">Barang</label>
                    <select id="barang_id" class="form-control">
                        <option value="" disabled selected>Pilih Barang</option>
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}" data-stok="{{ $barang->stok }}">{{ $barang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" id="quantity" class="form-control" value="0" min="0">
                </div>

                <button type="button" id="add-item" class="btn btn-primary">Tambah</button>

                <table class="table table-bordered mt-3" id="items-table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row items akan ditambahkan di sini oleh JavaScript -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total</th>
                            <th colspan="2" id="total-price">Rp. 0</th>
                        </tr>
                        <tr>
                            <th colspan="2"><label for="uang_bayar">Uang Bayar</label></th>
                            <th colspan="2">
                                <div class="d-flex align-items-center">
                                    Rp. <input type="number" id="uang_bayar" name="uang_bayar" class="form-control ml-2" min="0" value="">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">Kembalian</th>
                            <th colspan="2" id="kembalian">Rp. 0</th>
                        </tr>
                    </tfoot>
                </table>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function generateTransactionNumber() {
            const randomNum = Math.floor(100000 + Math.random() * 900000);
            return 'KJ-00' + randomNum;
        }

        document.getElementById('no_transaksi').value = generateTransactionNumber();
    });

    const itemsTableBody = document.querySelector('#items-table tbody');
    const totalPriceElem = document.getElementById('total-price');
    const barangSelect = document.getElementById('barang_id');
    const quantityInput = document.getElementById('quantity');
    const uangBayarInput = document.getElementById('uang_bayar');
    const kembalianElem = document.getElementById('kembalian');

    // Fungsi untuk memformat harga menjadi format rupiah tanpa koma
    function formatRupiah(angka) {
        return 'Rp. ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function calculateTotals() {
        let totalPrice = 0;
        const rows = itemsTableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const subtotal = parseInt(row.querySelector('.subtotal').textContent.replace('Rp. ', '').replace(/\./g, '')) || 0;
            totalPrice += subtotal;
        });
        totalPriceElem.textContent = formatRupiah(totalPrice);
        calculateKembalian(totalPrice);
    }

    function calculateKembalian(totalPrice) {
        const uangBayar = parseInt(uangBayarInput.value) || 0;
        const kembalian = uangBayar - totalPrice;
        kembalianElem.textContent = formatRupiah(kembalian);
    }

    function addTableRow(barangId, barangName, quantity, harga) {
        const row = document.createElement('tr');
        const subtotal = harga * quantity;
        row.innerHTML = `
            <td>
                <input type="hidden" name="items[${itemsTableBody.rows.length}][barang_id]" value="${barangId}">
                <input type="hidden" name="items[${itemsTableBody.rows.length}][quantity]" value="${quantity}">
                ${barangName}
            </td>
            <td>${quantity}</td>
            <td class="subtotal">${formatRupiah(subtotal)}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button></td>
        `;
        itemsTableBody.appendChild(row);
        calculateTotals();
    }

    document.getElementById('add-item').addEventListener('click', () => {
        const barangName = barangSelect.options[barangSelect.selectedIndex].textContent;
        const harga = parseInt(barangSelect.options[barangSelect.selectedIndex].dataset.harga);
        const quantity = parseInt(quantityInput.value, 10) || 0;

        if (!barangSelect.value || quantity <= 0) {
            alert('Isi terlebih dahulu');
            return;
        }

        addTableRow(barangSelect.value, barangName, quantity, harga);

        barangSelect.value = '';
        quantityInput.value = '0';
    });

    itemsTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
            calculateTotals();
        }
    });

    uangBayarInput.addEventListener('input', () => {
        const totalPrice = parseInt(totalPriceElem.textContent.replace('Rp. ', '').replace(/\./g, '')) || 0;
        calculateKembalian(totalPrice);
    });

    document.getElementById('transaction-form').addEventListener('submit', function(event) {
        const totalPrice = parseInt(totalPriceElem.textContent.replace('Rp. ', '').replace(/\./g, '')) || 0;
        const uangBayar = parseInt(uangBayarInput.value) || 0;

        if (uangBayar < totalPrice) {
            event.preventDefault();
            alert('Uang tidak mencukupi');
        }
    });
</script>

@endsection
