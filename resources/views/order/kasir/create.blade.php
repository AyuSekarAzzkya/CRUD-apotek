@extends('template.app')
@section('content')
    <div class="container mt-3">
        <form action="{{ route('store.pembelian') }}" class="card m-auto p-5" method="POST">
            @csrf
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif

            <p>Penanggung Jawab : <b>{{ Auth::user()->name }}</b></p>
            <div class="mb-3 row">
                <label for="name_customor" class="col-sm-2 col-form-label" >Nama Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" name="name_customor" id="name_customor" value="{{ old('name_customor') }}" class="form-control">
                </div>
            </div>

            <div id="medicines-wrapper">
                @if (old('medicines'))
                    @foreach (old('medicines') as $no => $item)
                        <div class="mb-4 row" id="medicines-{{$no}}">
                            <label for="medicines" class="col-sm-3 col-form-label label-style">Obat {{$no + 1}}
                                @if ($no > 0)
                                    <span style="cursor: pointer; font-weight: bold; padding: 5px; color:red;" onclick="deleteSelect('medicines-{{$no}}')">Hapus</span>                   
                                @endif
                            </label>
                            <div class="col-sm-9">
                                <select name="medicines[]" class="form-select form-select-lg" required style="border-radius: 10px; padding: 14px; font-size: 16px; background-color: #f1f1f1; border: 1px solid #ddd;">
                                    <option selected hidden disabled>Pesanan {{$no + 1}}</option>
                                    @foreach ($medicines as $item)
                                        <option value="{{ $item['id'] }}" @if($item['id'] == old('medicines')[$no]) selected @endif>{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mb-4 row" id="medicines-0">
                        <label for="medicines" class="col-sm-3 col-form-label label-style">Obat 1</label>
                        <div class="col-sm-9">
                            <select name="medicines[]" class="form-select form-select-lg" required style="border-radius: 10px; padding: 14px; font-size: 16px; background-color: #f1f1f1; border: 1px solid #ddd;">
                                <option selected hidden disabled>Pesanan 1</option>
                                @foreach ($medicines as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
            </div>

            <div>
                <p style="cursor: pointer" class="text-primary" id="add-select">+ Tambah obat</p>
            </div>

            <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi</button>
        </form>
    </div>
@endsection

@push('script')
    <script>
        let no = {{ old('medicines') ? count(old('medicines')) : 1 }};
        const medicines = @json($medicines); // Stok obat di backend

        // Fungsi untuk menambah select box baru
        $("#add-select").on("click", function() {
            let el = `
                <div class="mb-4 row" id="medicines-${no}">
                    <label for="medicines" class="col-sm-3 col-form-label label-style">Obat ${no + 1}
                        <span style="cursor: pointer; font-weight: bold; padding: 5px; color:red;" onclick="deleteSelect('medicines-${no}')">Hapus</span>
                    </label>
                    <div class="col-sm-9">
                        <select name="medicines[]" class="form-select form-select-lg" required style="border-radius: 10px; padding: 14px; font-size: 16px; background-color: #f1f1f1; border: 1px solid #ddd;">
                            <option selected hidden disabled>Pesanan ${no + 1}</option>
                            ${medicines.map(item => {
                                return `<option value="${item.id}">${item.name}</option>`;
                            }).join('')}
                        </select>
                    </div>
                </div>`;

            $("#medicines-wrapper").append(el);
            no++;
        });

        // Fungsi untuk menghapus obat
        function deleteSelect(id) {
            document.getElementById(id).remove();
        }
    </script>
@endpush
