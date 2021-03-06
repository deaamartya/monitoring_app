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
            return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
        }
    ?>
<div class="intro-y box p-5 mt-5 sm:mt-5 bg-blue-400 text-white" style="background-color: #1c3faa;">                        
    <div class="flex flex-row">
        <i data-feather="list"></i>
        <h2 class="text-lg font-medium mr-auto ml-3">Tabel Proyek</h2>
    </div>
</div>

<div class="intro-y box p-5 mt-5">

<!--Container-->
<div class="container w-full ">

    @include('admin.button-atas-proyek')

    <!--Card-->
    <div class="px-2 py-1">
    
        <table id="view" class="stripe hover display cell-border" style="width:100%; padding-top: 1em;  padding-bottom: 1em;" >
            <thead>
                <tr>
                    <th>No.</th>
                    <th data-priority="1">Kode Proyek</th>
                    <th data-priority="2">Nama Proyek</th>
                    <th data-priority="3">Start Proyek</th>
                    <th data-priority="4">End Proyek</th>
                    <th data-priority="6">Last Update</th>
                    <th data-priority="6">Created At</th>
                    <th data-priority="7">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($proyek as $p)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td >{{$p->KODE_PROYEK}}</td>
                    <td>{{$p->NAMA_PROYEK}}</td>
                    <td style="text-align:center">{{ tgl_indo($p->START_PROYEK) }}</td>
                    <td style="text-align:center">{{ tgl_indo($p->END_PROYEK) }}</td>
                    <td>{{$p->LAST_UPDATE}}</td>
                    <td>{{$p->CREATED_AT}}</td>
                    <td style="text-align: center;" width="18%">
                        <a href="{{url('/admin/rencana/'.$p->KODE_PROYEK)}}">
                            <button href="javascript:;" title="Detail" type="button" class="tooltip button px-2 mr-1 mb-2 bg-green-300 dark:text-gray-300">
                                <span class="w-5 h-5 flex items-center justify-center">
                                    <i data-feather="more-vertical" class="w-4 h-4 "></i>
                                </span>
                            </button>
                        </a>
                        <a data-toggle="modal" data-target="#edit_proyek{{ $p->ID_PROYEK }}" >
                            <button href="javascript:;" title="Edit" type="button" class="tooltip button px-2 mr-1 mb-2 bg-orange-300 dark:text-gray-300">
                                <span class="w-5 h-5 flex items-center justify-center">
                                    <i data-feather="edit" class="w-4 h-4 "></i>
                                </span>
                            </button>
                        </a>
                        <a data-toggle="modal" data-target="#delete_proyek{{ $p->ID_PROYEK }}">
                            <button href="javascript:;" title="Delete" type="button" class="tooltip button px-2 mr-1 mb-2 bg-red-300 dark:text-gray-300">
                                <span class="w-5 h-5 flex items-center justify-center">
                                    <i data-feather="trash-2" class="w-4 h-4 "></i>
                                </span>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
        <div class="modal" id="tambah_proyek">
            <div class="modal__content modal__content py-5 pl-3 pr-3 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="file-plus" class="w-8 h-8 mr-2"></i>Tambah Proyek</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>

                <form action="{{ route('menuproyek.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Kode Proyek</label>
                                <input type="text" class="input w-full border mt-2 flex-1" name="KODE_PROYEK" required>
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Nama Proyek</label>
                                <input type="text" class="input w-full border mt-2 flex-1" name="NAMA_PROYEK" required>
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Start Proyek</label>
                                    <div class="relative w-full mt-2 mx-auto"> 
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4"> 
                                            <i data-feather="calendar" class="w-4 h-4"></i> 
                                        </div> 
                                        <input type="text" class="datepicker input pl-12 border" name="START_PROYEK" data-single-mode="true" required> 
                                    </div> 
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">End Proyek</label>
                                    <div class="relative w-full mt-2 mx-auto"> 
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4"> 
                                            <i data-feather="calendar" class="w-4 h-4"></i> 
                                        </div> 
                                        <input type="text" class="datepicker input pl-12 border" name="END_PROYEK" data-single-mode="true" required> 
                                    </div> 
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

        @foreach($proyek as $p)
        <div class="modal" id="edit_proyek{{ $p->ID_PROYEK }}">
            <div class="modal__content modal__content py-5 pl-3 pr-3 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="edit" class="w-8 h-8 mr-2"></i>Edit Proyek</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>

                <form action="{{ route('menuproyek.update', $p->ID_PROYEK) }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                        <input type="hidden" name="ID_PROYEK" value="{{ $p->ID_PROYEK }}">
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Kode Proyek</label>
                                <input type="text" class="input w-full border mt-2 flex-1" value="{{ $p->KODE_PROYEK }}" name="KODE_PROYEK">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Nama Proyek</label>
                                <input type="text" class="input w-full border mt-2 flex-1" value="{{ $p->NAMA_PROYEK }}" name="NAMA_PROYEK">
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">Start Proyek</label>
                                    <div class="relative w-full mt-2 mx-auto"> 
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4"> 
                                            <i data-feather="calendar" class="w-4 h-4"></i> 
                                        </div> 
                                        <input type="text" class="datepicker input pl-12 border" name="START_PROYEK" data-single-mode="true" value="{{ $p->START_PROYEK }}"> 
                                    </div>
                            </div>
                            <div class="col-span-12"> 
                                <label class="font-semibold text-lg">End Proyek</label>
                                    <div class="relative w-full mt-2 mx-auto"> 
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4"> 
                                            <i data-feather="calendar" class="w-4 h-4"></i> 
                                        </div> 
                                        <input type="text" class="datepicker input pl-12 border" name="END_PROYEK" data-single-mode="true" value="{{ $p->END_PROYEK }}"> 
                                    </div> 
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

        
        <div class="modal" id="delete_proyek{{ $p->ID_PROYEK }}">
            <div class="modal__content modal__content--lg p-5 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="trash-2" class="w-8 h-8 mr-2"></i>Hapus Proyek #{{ $loop->iteration }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>

                <form action="{{ route('menuproyek.destroy', $p->ID_PROYEK) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" value="{{$p->ID_PROYEK}}"name="ID_PROYEK">
                    <input type="hidden" value="{{$p->KODE_PROYEK}}" name="KODE_PROYEK">
                    <input type="hidden" value="{{$p->NAMA_PROYEK}}" name="NAMA_PROYEK">
                    <div class="text-base mt-5">
                        Apakah Anda yakin ingin menghapus proyek dengan kode proyek {{ $p->KODE_PROYEK }} dan nama proyek {{ $p->NAMA_PROYEK }} ?
                    </div>
                    <div class="text-base text-theme-6">Data yang dihapus tidak dapat dikembalikan.</div>
                    <div class="modal-footer mt-5">
                        <div class="text-right">
                            <button type="button" class="button shadow-md mr-1 mb-2 bg-red-500 text-white" data-dismiss="modal">Tidak, batalkan.</button> 
                            <button class="button items-right shadow-md mr-1 mb-2 justify-right bg-theme-1 text-white shadow-md" type="submit">Ya, hapus.</button>
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
 
<script>
$(document).ready(function() {

    var table = $('#view').DataTable( {
        responsive: true,
    } )
    .columns.adjust()
    .responsive.recalc();
});

</script>
@endsection