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
        <h2 class="text-lg font-medium mr-auto ml-3">Rencana Proyek {{ $nama_proyek }}</h2>
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
    <div class="intro-y block sm:flex items-center h-10">
        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
            <a href ="javascript:;" data-toggle="modal" data-target="#tambah_rencana">
                <button class="ml-3 button box flex items-center shadow-md bg-blue-200 text-gray-700 buttons-html5 buttons-pdf"> <i data-feather="plus-circle" class="hidden sm:block w-4 h-4 mr-2"></i> Tambah Rencana </button>
            </a>
        </div>
    </div> 
    <br>
    <!--Card-->
    <div class="px-2 py-1">
       

        <table id="example" class="stripe hover display cell-border" style="width:100%; padding-top: 1em;  padding-bottom: 1em; text-align:center;">
            <thead>
                <tr>
                    <th>#</th>
                    <th data-priority="1">Tanggal</th>
                    <th data-priority="2">PV</th>
                    <th data-priority="3">Rencana</th>
        
                    <th data-priority="4"style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($progress as $p)
                <tr>
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->TANGGAL))}}</td>
                    <td>
                    @if($p->ID_TIPE == 1)
                        @if(isset($p->VALUE))
                            {{$p->VALUE}}
                        @else
                            -
                        @endif 
                    @endif
                    </td>
                    <td>
                    @if($p->ID_TIPE == 4)
                        @if(isset($p->VALUE))
                            {{$p->VALUE}}%
                        @else
                            -
                        @endif 
                    @endif 
                    </td>
                    <td>
                    <div class="flex" style="justify-content: center;">
                        <a data-toggle="modal" data-target="#edit_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
                            <button href="javascript:;" title="Edit Rencana" type="button" class="button px-3 mr-3 mb-3 bg-theme-17 text-theme-11">
                                <span class="flex items-center justify-center">
                                    <i data-feather="edit" class="w-7 h-7 mr-2"></i>Edit
                                </span>
                            </button>
                        </a>
                        <a data-toggle="modal" data-target="#delete_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
                            <button href="javascript:;" title="Hapus Rencana" type="button" class="button px-3 mr-3 mb-3 bg-theme-31 text-theme-6">
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

   

<div class="modal" id="tambah_rencana">
            <div class="modal__content modal__content py-5 pl-3 pr-1 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="plus-circle" class="w-8 h-8 mr-2"></i>Tambah Rencana</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <form action="{{ route('rencana.store') }}" method="POST" class="needs-validation" novalidate id="tambah-rencana">
                    @csrf
                    
                    <input type="hidden" name="KODE_PROYEK" value="{{ $kode_proyek }}">
                    <div class="mr-5 mb-5 grid grid-cols-12 gap-4 row-gap-3">
                        <div class="col-span-12">
                             <label class="font-semibold text-lg">Tanggal</label> 
                                    <div class="relative mx-auto mt-2 mb-5"> 
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4"><i data-feather="calendar" class="w-4 h-4"></i></div> 
                                            <input type="text" class="datepicker input pl-12 border" data-single-mode="true" name="TANGGAL"> 
                                    </div>
                        </div>
                    </div>
                 
                    <div class="grid grid-cols-12 gap-4 row-gap-3 mt-3">
                        <div class="col-span-12">
                            <label class="font-semibold text-lg mr-auto mt-3">Planning Value</label> 
                                <input type="number" class="input w-full border mt-2 flex-1" placeholder="Planning Value" name="PV_VALUE" required >
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-4 row-gap-3 mt-3">
                        <div class="col-span-12">
                            <label class="font-semibold text-lg mr-auto mt-3">Prosentase</label> 
                                <input type="number" class="input w-full border mt-2 flex-1" placeholder="Prosentase" name="RENCANA" required >
                        </div>
                    </div>
               
                    <div class="text-right"> 
                        <button class="button items-right w-24 shadow-md mr-1 mb-2 justify-right bg-theme-1 text-white shadow-md" type="submit">Simpan</button>
                    </div>
              
                </form>
            </div>
        </div>




        @foreach($progress as $p)
        <div class="modal" id="edit_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
            <div class="modal__content modal__content--lg py-5 pl-5 pr-5 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="info" class="w-8 h-8 mr-2"></i>Edit Rencana #{{ $p->TANGGAL }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto" id="close_{{$p->TANGGAL}}"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rencana.update', $p->TANGGAL) }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="KODE_PROYEK" value="{{ $kode_proyek }}">
                    <div class="modal-body">
                    <div class="mr-5 mb-5 grid grid-cols-12 gap-4 row-gap-3">
                        <div class="col-span-12">
                             <label class="font-semibold text-lg">Tanggal</label> 
                                    <div class="relative mx-auto mt-2 mb-5"> 
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4"><i data-feather="calendar" class="w-4 h-4"></i></div> 
                                            <input type="text" class="datepicker input pl-12 border" data-single-mode="true" name="TANGGAL"> 
                                    </div>
                        </div>
                    </div>
                 
                    <div class="grid grid-cols-12 gap-4 row-gap-3 mt-3">
                        <div class="col-span-12">
                            <label class="font-semibold text-lg mr-auto mt-3">Planning Value</label> 
                                <input type="number" class="input w-full border mt-2 flex-1" placeholder="Planning Value" name="PV_VALUE" required >
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-4 row-gap-3 mt-3">
                        <div class="col-span-12">
                            <label class="font-semibold text-lg mr-auto mt-3">Prosentase</label> 
                                <input type="number" class="input w-full border mt-2 flex-1" placeholder="Prosentase" name="RENCANA" required >
                        </div>
                    </div>
                    </div>
                <div class="modal-footer mt-5">
                    <div class="text-right">
                    <button type="button" class="button w-24 shadow-md mr-1 mb-2 bg-red-500 text-white" data-dismiss="modal">Cancel</button> 
                    <button class="button items-right w-24 shadow-md mr-1 mb-2 justify-right bg-theme-1 text-white shadow-md" type="submit">Simpan</button>
                   
                    </div>
                </div>

                </form>
            </div>
        </div>

        <div class="modal editModal" id="delete_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
            <div class="modal__content modal__content--lg p-5 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="trash-2" class="w-8 h-8 mr-2"></i>Hapus Rencana #{{ $loop->iteration }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>

                <form action="{{ route('rencana.destroy', $p->KODE_PROYEK) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" value="{{$p->TANGGAL}}"name="TANGGAL">
                    <input type="hidden" value="{{$p->ID_TIPE}}" name="ID_TIPE">
                    <div class="text-base mt-5">
                        Apakah Anda yakin ingin menghapus rencana proyek "{{ $p->proyek->NAMA_PROYEK }}" untuk bulan {{ date('F Y',strtotime($p->TANGGAL)) }} ?
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




@endsection

@section('script')
<!--Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {

    var table = $('#example').DataTable( {
            order: [[ 4, "asc" ], [0,"asc"]],
            responsive: true
        } )
        .columns.adjust()
        .responsive.recalc();


    

});


</script>
@endsection