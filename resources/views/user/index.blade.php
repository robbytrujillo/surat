@extends('layouts.index')

@section('content')
    <article class="container article">

        {{--  <h2 class="h2 article-title">Hi Elizabeth</h2>

        <p class="article-subtitle">Welcome to Surat</p>  --}}

        <!-- 
        - #HOME
        -->

        <section class="home">
            

       <div class="card profile-card">
        
        {{--  <a href="https://www.contoh.com" style="text-decoration: none; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 5px; display: inline-block;">
</a>  --}}

        <div class="section-title-wrapper">
            <h3 class="section-title">Daftar User</h3>
        </div>

        <a href="{{ route('user.create') }}" class="button" style="text-decoration: none; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 30px; display: inline-block;">Tambah User</a>
            <div class="table-wrapper">
                <table class="custom-table">

                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 220px;" style="text-align: center;">Nama</th>
                            <th style="width: 220px;" style="text-align: center;">Email</th>
                            <th style="width: 220px;" style="text-align: center;">Role</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role }}</td>
                                <td>
                                    <div class="action-buttons">


                                        <a href="{{ route('user.edit', $item->id) }}" 
                                        class="btn-table btn-edit" style="border-radius: 30px">Edit</a>

                                        <form action="{{ route('user.destroy', $item->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Are you sure?')" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-table btn-delete" style="border-radius: 30px">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-data">
                                    Tidak ada data!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </article>

    <!-- Modal Create -->
    {{--  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Surat</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('surat.create') }}">
                <select name="jenis" id="jenis" class="form-select">
                    @foreach ($jenissurat as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_surat }}</option>
                    @endforeach
                </select>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>  --}}

@endsection

