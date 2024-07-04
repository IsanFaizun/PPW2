@extends('master')

@section('title', 'Kategori')
@section('header', 'Kategori')

@section('content')

<button id="openCreateDialog" class="bg-blue-500 text-white px-4 py-2 rounded-md">
    Tambah Kategori
</button>

<table class="min-w-full bg-white mt-3">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4 border-b">ID</th>
            <th class="py-2 px-4 border-b">Nama Kategori</th>
            <th class="py-2 px-4 border-b">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data_kategori as $kategori)
            <tr>
                <td class="py-2 px-4 border-b">{{ $kategori->id }}</td>
                <td class="py-2 px-4 border-b">{{ $kategori->nama }}</td>
                <td class="py-2 px-4 border-b">
                    <button type="button" class="bg-green-500 text-white px-4 py-2 rounded-md" data-id="{{ $kategori->id }}" data-nama="{{ $kategori->nama }}" onclick="openEditDialog(this)">
                        Edit
                    </button>
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Hapus</button>
                    </form>
                </td>          
            </tr>
        @endforeach
    </tbody>
</table>

<dialog id="createDialog" class="rounded-lg p-5">
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <h5 class="text-lg font-semibold mb-4">Tambah Kategori</h5>
        <div class="mb-4">
            <input type="text" id="nama" name="nama" placeholder="Nama Kategori" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="flex justify-end">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2" onclick="closeCreateDialog()">Close</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
        </div>
    </form>
</dialog>

<dialog id="editDialog" class="rounded-lg p-5">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <h5 class="text-lg font-semibold mb-4">Edit Kategori</h5>
        <div class="mb-4">
            <input type="text" id="editNama" name="nama" placeholder="Nama Kategori" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="flex justify-end">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2" onclick="closeEditDialog()">Close</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save changes</button>
        </div>
    </form>
</dialog>

<script>
    const createDialog = document.getElementById('createDialog');
    const openCreateDialogButton = document.getElementById('openCreateDialog');
    const closeCreateDialog = () => createDialog.close();

    openCreateDialogButton.addEventListener('click', () => createDialog.showModal());

    const editDialog = document.getElementById('editDialog');
    const closeEditDialog = () => editDialog.close();

    function openEditDialog(button) {
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const editNamaInput = document.getElementById('editNama');
        const editForm = document.getElementById('editForm');

        editNamaInput.value = nama;
        editForm.action = '/kategori/' + id;
        editDialog.showModal();
    }
</script>
@endsection
