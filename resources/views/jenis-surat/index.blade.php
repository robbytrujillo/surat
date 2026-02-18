@extends('layouts.index')

@section('content')
    <article class="container article">

        <h2 class="h2 article-title">Hi Elizabeth</h2>

        <p class="article-subtitle">Welcome to Jenis Surat</p>

        <!-- 
        - #HOME
        -->

        <section class="home">
            

       <div class="card profile-card">
        
        {{--  <a href="https://www.contoh.com" style="text-decoration: none; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 5px; display: inline-block;">  --}}
</a>

        <div class="section-title-wrapper">
            <h3 class="section-title">Daftar Jenis Surat</h3>
        </div>

        <a href="{{ route('jenis-surat.create') }}" class="button" style="text-decoration: none; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 30px; display: inline-block;">Tambah Jenis Surat</a>
            <div class="table-wrapper">
                <table class="custom-table">

                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 220px;" style="text-align: center;">Jenis Surat</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($jenissurat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_surat }}</td>
                                <td>
                                    <div class="action-buttons">

                                        <a href="{{ route('jenis-surat.show', $item->id) }}" 
                                        class="btn-table btn-view" target="_blank" style="border-radius: 30px">Preview</a>

                                        <a href="{{ route('jenis-surat.edit', $item->id) }}" 
                                        class="btn-table btn-edit" style="border-radius: 30px">Edit</a>

                                        <form action="{{ route('jenis-surat.destroy', $item->id) }}" 
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
                                <td colspan="3" class="empty-data">
                                    Tidak ada data!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

       

    </article>
@endsection

