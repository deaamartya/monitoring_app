@extends('layout')
@section('css')
<!--Regular Datatables CSS-->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<!--Responsive Extension Datatables CSS-->
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
        
<style>
/*Form fields*/
.dataTables_wrapper select,
.dataTables_wrapper .dataTables_filter input {
    color: #4a5568; 			/*text-gray-700*/
    padding-left: 1rem; 		/*pl-4*/
    padding-right: 1rem; 		/*pl-4*/
    padding-top: .5rem; 		/*pl-2*/
    padding-bottom: .5rem; 		/*pl-2*/
    line-height: 1.25; 			/*leading-tight*/
    border-width: 2px; 			/*border-2*/
    border-radius: .25rem; 		
    border-color: #edf2f7; 		/*border-gray-200*/
    background-color: #edf2f7; 	/*bg-gray-200*/
}

/*Row Hover*/
table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
    background-color: #ebf4ff;	/*bg-indigo-100*/
}

/*Pagination Buttons*/
.dataTables_wrapper .dataTables_paginate .paginate_button		{
    font-weight: 700;				/*font-bold*/
    border-radius: .25rem;			/*rounded*/
    border: 1px solid transparent;	/*border border-transparent*/
}

/*Pagination Buttons - Current selected */
.dataTables_wrapper .dataTables_paginate .paginate_button.current	{
    color: #fff !important;				/*text-white*/
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); 	/*shadow*/
    font-weight: 700;					/*font-bold*/
    border-radius: .25rem;				/*rounded*/
    background: #667eea !important;		/*bg-indigo-500*/
    border: 1px solid transparent;		/*border border-transparent*/
}

/*Pagination Buttons - Hover */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover		{
    color: #fff !important;				/*text-white*/
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);	 /*shadow*/
    font-weight: 700;					/*font-bold*/
    border-radius: .25rem;				/*rounded*/
    background: #667eea !important;		/*bg-indigo-500*/
    border: 1px solid transparent;		/*border border-transparent*/
}

/*Add padding to bottom border */
table.dataTable.no-footer {
    border-bottom: 1px solid #e2e8f0;	/*border-b-1 border-gray-300*/
    margin-top: 0.75em;
    margin-bottom: 0.75em;
}

/*Change colour of responsive icon*/
table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
    background-color: #667eea !important; /*bg-indigo-500*/
}

</style>
@endsection
@section('content')
<div class="intro-y box p-5 mt-5 sm:mt-5 bg-blue-400 text-white" style="background-color: #1c3faa;">                        
    <div class="flex flex-row">
        <i data-feather="list"></i>
        <h2 class="text-lg font-medium mr-auto ml-3">Realisasi Proyek {{ $nama_proyek }}</h2>
    </div>
</div>

<div class="intro-y box p-5 mt-5">

<!--Container-->
<div class="container w-full ">
    @if($errors->any())
        <div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-31 text-theme-6">
            <i data-feather="alert-octagon" class="w-6 h-6 mr-2"></i>
            Data tidak berhasil disimpan. Mohon cek form kembali.
        </div>
    @endif
    @if(Session::has('success'))
    <div class="rounded-md w-35 flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9">
        <i data-feather="alert-circle" class="w-6 h-6 mr-2"></i>
        {{ Session::get('success') }}
    </div>
    @endif
    <br>
    <div class="intro-y block sm:flex items-center h-10">
        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
            <a href ="javascript:;" data-toggle="modal" data-target="#tambah_realisasi">
                <button class="ml-3 button box flex items-center shadow-md bg-blue-200 text-gray-700 buttons-html5 buttons-pdf"> <i data-feather="plus-circle" class="hidden sm:block w-4 h-4 mr-2"></i> Tambah Realisasi </button>
            </a>
        </div>
    </div> 
    <br>
    <!--Card-->
    <div class="px-2 py-1">
        <!-- <a href ="javascript:;" data-toggle="modal" data-target="#tambah_realisasi" class="button mb-6 mr-6 flex items-center justify-center bg-theme-1 text-white float-right block" style="float:right;" ><i data-feather="plus-circle" class="w-6 h-6 mr-2"></i>Tambah Realisasi</a> -->

        <table id="example" class="stripe hover display cell-border" style="width:100%; padding-top: 1em;  padding-bottom: 1em; text-align:center;">
            <thead>
                <tr>
                    <th>#</th>
                    <th data-priority="1">Tanggal</th>
                    <th data-priority="2">PV</th>
                    <th data-priority="3">EV</th>
                    <th data-priority="4">AC</th>
                    <th data-priority="5">Rencana</th>
                    <th data-priority="6">Realisasi</th>
                    <th data-priority="7"style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($progress as $p)
                <tr>
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->TANGGAL))}}</td>
                    <td>{{$p->PV}}</td>
                    <td>{{$p->EV}}</td>
                    <td>{{$p->AC}}</td>
                    @if($p->Rencana == "-")
                    <td>{{$p->Rencana}}</td>
                    @else
                    <td>{{$p->Rencana}}%</td>
                    @endif

                    @if($p->Realisasi == "-")
                    <td>{{$p->Realisasi}}</td>
                    @else
                    <td>{{$p->Realisasi}}%</td>
                    @endif
                    <td>
                    <div class="flex" style="justify-content: center;">
                        <a data-toggle="modal" data-target="#edit_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
                            <button href="javascript:;" title="Edit Realisasi" type="button" class="button px-3 mr-3 mb-3 bg-theme-17 text-theme-11">
                                <span class="flex items-center justify-center">
                                    <i data-feather="edit" class="w-7 h-7 mr-2"></i>Edit
                                </span>
                            </button>
                        </a>
                        <a data-toggle="modal" data-target="#delete_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
                            <button href="javascript:;" title="Hapus Realisasi" type="button" class="button px-3 mr-3 mb-3 bg-theme-31 text-theme-6">
                                <span class="flex items-center justify-center">
                                    <i data-feather="trash" class="w-6 h-6 mr-2"></i>Hapus
                                </span>
                            </button>
                        </a>
                    </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="modal" id="tambah_realisasi">
            <div class="modal__content modal__content py-5 pl-3 pr-1 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="plus-circle" class="w-8 h-8 mr-2"></i>Tambah Realisasi</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <form action="{{ route('realisasi.store') }}" method="POST">
                    @csrf
                    <input id="kode_proyek" type="hidden" name="KODE_PROYEK" value="{{ $kode_proyek }}">
                    <div class="modal-body">
                    <?php
                        function tgl_indo($tanggal){
                            $bulan = array (
                                1 =>   'Januari',
                                'Februari',
                                'Maret',
                                'April',
                                'Mei',
                                'Juni',
                                'Juli',
                                'Agustus',
                                'September',
                                'Oktober',
                                'November',
                                'Desember'
                            );
                            $pecahkan = explode('-', $tanggal);
                            return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
                        }
                    ?>

                        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Bulan</label>
                                <select id="select_tanggal" data-search="true" class="tail-select w-full" name="TANGGAL" required>
                                    <option selected disabled>Pilih bulan.....</option>
                                    @foreach($tgl_progress as $t)
                                        <option value="{{ $t->TANGGAL }}">{{ tgl_indo($t->TANGGAL) }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('TANGGAL'))
                                <small class="text-theme-6">Bulan Wajib Diisi.</small>
                                @endif
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">PV</label>
                                <input disabled id="pv_value" type="text" class="input w-full border mt-2 flex-1" name="PV_VALUE">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Rencana</label>
                                <input disabled id="rencana_value" type="text" class="input w-full border mt-2 flex-1" name="RENCANA_VALUE">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">EV</label>
                                <input type="number" class="input w-full border mt-2 flex-1" name="EV_VALUE">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">AC</label>
                                <input type="number" class="input w-full border mt-2 flex-1" name="AC_VALUE">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Realisasi</label>
                                <input type="number" class="input w-full border mt-2 flex-1" name="REALISASI_VALUE">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-5">
                        <div class="text-right mr-5">
                        <button type="button" class="button w-24 shadow-md mr-1 mb-2 bg-red-500 text-white" data-dismiss="modal">Cancel</button> 
                        <button class="button items-right w-24 shadow-md mr-5 mb-2 justify-right bg-theme-1 text-white shadow-md" type="submit">Simpan</button>
                       
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @foreach($progress as $p)
        <div class="modal" id="edit_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
            <div class="modal__content modal__content py-5 pl-3 pr-1 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="edit" class="w-8 h-8 mr-2"></i>Edit Realisasi #{{ $loop->iteration  }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <form action="{{ route('realisasi.update',$p->TANGGAL) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="KODE_PROYEK" value="{{ $kode_proyek }}">
                    <div class="modal-body">
                        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                            <div class="col-span-12"> 
                            <label class="font-semibold text-lg">Tanggal</label>
                            <input disabled class="input border mr-2 w-full mt-2"  value="{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
                            <input type="hidden" class="input border mr-2 w-full mt-2" name="TANGGAL_EDIT" value="{{ $p->TANGGAL }}">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">PV</label>
                                <input disabled type="number" class="input w-full border mt-2 flex-1" name="PV_VALUE_EDIT" value="{{ $p->PV }}" readonly>
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Rencana</label>
                                <input disabled type="number" class="input w-full border mt-2 flex-1" name="RENCANA_VALUE_EDIT" value="{{ $p->Rencana }}" readonly>
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">EV</label>
                                <input type="number" class="input w-full border mt-2 flex-1" name="EV_VALUE_EDIT" value="{{ $p->EV }}">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">AC</label>
                                <input type="number" class="input w-full border mt-2 flex-1" name="AC_VALUE_EDIT" value="{{ $p->AC }}">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Realisasi</label>
                                <input type="number" class="input w-full border mt-2 flex-1" name="REALISASI_VALUE_EDIT" value="{{ $p->Realisasi }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-5">
                        <div class="text-right mr-5">
                        <button type="button" class="button w-24 shadow-md mr-1 mb-2 bg-red-500 text-white" data-dismiss="modal">Cancel</button> 
                        <button class="button items-right w-24 shadow-md mr-5 mb-2 justify-right bg-theme-1 text-white shadow-md" type="submit">Update</button>
                       
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal" id="delete_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
            <div class="modal__content modal__content py-5 pl-3 pr-1 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="trash" class="w-8 h-8 mr-2"></i>Hapus Realisasi #{{ $loop->iteration }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <form action="{{ route('realisasi.destroy',$p->KODE_PROYEK) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="text-base mt-5 ml-3">
                        Apakah Anda yakin ingin menghapus nilai EV, AC dan realisasi pada tanggal {{ date('d-m-Y', strtotime($p->TANGGAL)) }} ?
                    </div>
                    <input type="hidden" name="TANGGAL_DELETE" value="{{ $p->TANGGAL }}">
                    <div class="text-base text-theme-6 ml-3">Data yang dihapus tidak dapat dikembalikan.</div>
                    <div class="modal-footer mt-5">
                        <div class="text-right mr-5">
                            <button type="button" class="button w-24 shadow-md mr-1 mb-2 bg-red-500 text-white" data-dismiss="modal">Tidak</button> 
                            <button class="button items-right w-24 shadow-md mr-5 mb-2 justify-right bg-theme-1 text-white shadow-md" type="submit">Ya</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach        
        
    </div>
    <!--/Card-->


</div>
<!--/container-->
</div>
@endsection
@section('script')
<!--Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable( {
                // "order": [ 0, 'asc' ],
                responsive: true,
            } )
            .columns.adjust()
            .responsive.recalc();
    });

    $('#select_tanggal').on('change', function(e){
      var tgl = $('#select_tanggal').val();
      var kd_proyek = $('#kode_proyek').val();
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
                type:"POST",
                url:"{{ url('admin/realisasi/get-rencana') }}",
                data:{
                  "tgl":tgl,
                  "kd_proyek":kd_proyek,
                  "_token": "{{ csrf_token() }}",//harus ada ini jika menggunakan metode POST
                },
                success : function(results) {
                  //console.log(JSON.stringify(results)); //print_r
                    
                    if(results.pesan_error != ""){
                        Swal.fire({
                            title: 'Kesalahan !',
                            text: results.pesan_error,
                            icon: 'error',
                        });
                        $('#pv_value').val("");
                        $('#rencana_value').val("");
                    }else{
                        $('#pv_value').val(results.pv_val);
                        $('#rencana_value').val(results.rencana_val+"%");
                    }
                },
                error: function(data) {
                    console.log(data);
                }
          });
    });
    
</script>
@endsection