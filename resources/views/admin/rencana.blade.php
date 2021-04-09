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
@if(Session::has('success'))
<div class="rounded-md w-35 flex items-center px-5 py-4 mb-2 mt-3 ml-5 bg-theme-18 text-theme-9"> <i data-feather="alert-circle" class="w-6 h-6 mr-2"></i>{{@session::get('success') }}</div>
@endif

<div class="content">
<div class="intro-y box p-5 mt-5 mb-5 sm:mt-5 bg-blue-400 text-white" style="background-color: #1c3faa;">                        
    <div class="flex flex-row">
        <i data-feather="list"></i>
        <h2 class="text-lg font-medium mr-auto ml-3">Table Rencana </h2>
    </div>
    
</div>

<!-- Tambah Rencana -->
                <div id="rencana">
                    <form action="{{ route('rencana.store') }}" method="POST" class="needs-validation" novalidate id="tambah-rencana">
                    @csrf
                    
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


<div class="intro-y box mt-5">
    <!--Container-->
    <!--Card-->
    
    <a href ="javascript:;" data-toggle="modal" data-target="#tambah_kategori" class="button mb-5 mr-6 mt-4 flex items-center justify-center bg-theme-1 text-white tombol-tambah-kategori" style="float:right;" ><i data-feather="plus-circle" class="w-6 h-6 mr-2"></i>Tambah Kategori Dokumen</a>
    
    <div class="container w-full">

        <div class="p-6 mt-6 lg:mt-0 rounded shadow">
            <table id="example" class="stripe hover display cell-border" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                       
                        <th data-priority="1">Tanggal</th>
                        <th data-priority="2">Ptosentase</th>
                        <th data-priority="3">Planning Value</th>
                        <th data-priority="4">Aksi</th>
                    </tr>
                </thead>

                <tbody style="text-align: center;">
                @foreach($rencana as $r)
                    <tr>
                        <td>{{$k->ID_KATEGORI}}</td>
                        <td>{{$k->jenis_kategori_dokumen->JENIS_KATEGORI}}</td>
                        <td>{{$k->KATEGORI}}</td>
                        <td>{{$k->NOMOR_URUT}}</td>
                        <td>
                        <div class="flex" style="justify-content: center;">
                            <a data-toggle="modal" data-target="#editKategori_{{ $k->ID_KATEGORI }}">
                                <button href="javascript:;" title="Edit Kategori" type="button" class="tooltip button px-2 mr-1 mb-2 bg-green-300 dark:text-gray-300">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i data-feather="edit" class="w-4 h-4 "></i>
                                    </span>
                                </button>
                            </a>
                            <a data-toggle="modal" data-target="#deleteKategori_{{$k->ID_KATEGORI}}">
                                <button href="javascript:;" title="Hapus Kategori" type="button" class="tooltip button px-2 mr-1 mb-2 bg-red-300 dark:text-gray-300">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i data-feather="trash-2" class="w-5 h-5 "></i>
                                    </span>
                                </button>
                            </a>
                        </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



        @foreach($kategori as $k)
        <div class="modal" id="editKategori_{{ $k->ID_KATEGORI }}">
            <div class="modal__content modal__content--lg py-5 pl-5 pr-5 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="info" class="w-8 h-8 mr-2"></i>Edit Kategori Dokumen #{{ $k->ID_KATEGORI }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto" id="close_{{$k->ID_KATEGORI}}"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kategori-dokumen.update', $k->ID_KATEGORI) }}" method="POST" class="needs-validation" novalidate">
                    @method('PUT')
                    @csrf
                    
                    <div class="grid grid-cols-12 gap-4 row-gap-3 mt-3">
                        <div class="col-span-12">
                            <label class="font-semibold text-lg mr-auto mt-3">Jenis Kategori Dokumen</label> 
                            <select class="input w-full border mt-2 flex-1" name="ID_JENIS_KATEGORI" required>
                                @foreach($jenis_kategori as $j)
                                <option value="{{ $j->ID_JENIS_KATEGORI }}" {{ ( $j->ID_JENIS_KATEGORI == $k->ID_JENIS_KATEGORI) ? 'selected' : '' }} >{{ $j->JENIS_KATEGORI }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-4 row-gap-3 mt-3">
                        <div class="col-span-12">
                            <label class="font-semibold text-lg mr-auto mt-3">Kategori Dokumen</label> 
                                <input type="text" class="input w-full border mt-2 flex-1" placeholder="Kategori Dokumen" name="KATEGORI_DOKUMEN" value="{{ $k->KATEGORI }}" required >
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-4 row-gap-3 mt-3">
                        <div class="col-span-12">
                            <label class="font-semibold text-lg mr-auto mt-3">Nomor Urut</label> 
                                <input type="number" min="1" class="input w-full border mt-2 flex-1" placeholder="Nomor Urut" name="NOMOR_URUT" value="{{ $k->NOMOR_URUT }}" required >
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

        <div class="modal editModal" id="deleteKategori_{{ $k->ID_KATEGORI }}">
            <div class="modal__content modal__content--lg p-5 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="trash-2" class="w-8 h-8 mr-2"></i>Delete Kategori Dokumen #{{ $k->ID_KATEGORI }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <form action="{{ route('kategori-dokumen.destroy',$k->ID_KATEGORI) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="text-base mt-5">
                        Apakah Anda yakin ingin menghapus kategori dokumen "{{ $k->KATEGORI }}" ?
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