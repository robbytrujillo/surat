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
        
        {{--  <a href="https://www.contoh.com" style="text-decoration: none; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 5px; display: inline-block;">  --}}
{{--  </a>  --}}

        <div class="section-title-wrapper">
            <h3 class="section-title">Tambah Surat</h3>
        </div>

        <a href="{{ route('surat.index') }}" class="button" style="text-decoration: none; padding: 10px 20px; background-color: #dee4ea; color: rgb(25, 24, 24); border-radius: 30px; display: inline-block;">Kembali</a>
            <div class="table-wrapper">
                {{--  <table class="custom-table">

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
                                        class="btn-table btn-view">Preview</a>

                                        <a href="{{ route('jenis-surat.edit', $item->id) }}" 
                                        class="btn-table btn-edit">Edit</a>

                                        <form action="{{ route('jenis-surat.destroy', $item->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-table btn-delete">
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

                </table>  --}}
                <form action="{{ route('surat.preview') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Pilih Surat</label>
                        <select name="jenis_surat_id" id="jenis_surat_id" class="form-control">
                            <option value="">--Pilih Surat--</option>
                            @foreach ($jenissurat as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_surat }}</option>
                            @endforeach
                        </select>

                        @error('jenis_surat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" 
                            name="nomor_surat" 
                            class="form-control @error('nomor_surat') is-invalid @enderror"
                            value="{{ old('nomor_surat', $nomor_surat) }}"
                            readonly>
                        
                        @error('nomor_surat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Surat</label>
                        <input type="date" 
                            name="tanggal_surat" 
                            class="form-control @error('tanggal_surat') is-invalid @enderror"
                            value="{{ old('tanggal_surat') }}"
                            placeholder="Masukkan tanggal surat">
                        
                        @error('tanggal_surat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penandatangan</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">--Pilih Penandatangan--</option>
                            @foreach ($penandatangan as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        
                        @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{--  <div class="mb-3">
                        <label class="form-label">Isi Surat</label>
                        <textarea name="isi_surat" 
                                rows="4"
                                class="form-control @error('isi_surat') is-invalid @enderror"
                                placeholder="Masukkan isi surat">{{ $template }}</textarea>
                        
                        @error('isi_surat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>  --}}

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" style="border-radius: 30px">
                            Selanjutnya
                        </button>
                    </div>
                </form>
            </div>

        </div>

       

    </article>
@endsection

