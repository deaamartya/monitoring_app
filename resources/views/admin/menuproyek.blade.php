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
        <h2 class="text-lg font-medium mr-auto ml-3">Tabel Menu Proyek</h2>
    </div>
</div>

<div class="intro-y box p-5 mt-5">

<!--Container-->
<div class="container w-full ">

    <div class="intro-y block sm:flex items-center h-10">
        <!-- <h2 class="text-lg font-medium truncate mr-5">
            Print Tabel Permohonan yang Sudah Dikonfirmasi
        </h2> -->
        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
            <a href="{{url('/admin/addproyek')}}">
                <button class="button box flex items-center shadow-md bg-gray-200 text-gray-700 buttons-html5 buttons-pdf" id="print"> <i data-feather="file-plus" class="hidden sm:block w-4 h-4 mr-2"></i> Tambah Proyek Baru </button>
            </a>
            <a target="_blank" href="{{url('/admin/exportexcel')}}">
                <button class="ml-3 button box flex items-center shadow-md bg-gray-200 text-gray-700 buttons-html5 buttons-pdf" id="print"> <i data-feather="download" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel </button>
            </a>
        </div>
        <!-- <div class="flex items-center sm:ml-auto mt-3 sm:mt-0"> -->
            
        <!-- </div> -->
    </div>  
    <br>

    <!--Card-->
    <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
    
        <table id="view" class="stripe hover display cell-border" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead>
                <tr>
                    <th data-priority="1">Kode Proyek</th>
                    <th data-priority="2">Nama Proyek</th>
                    <th data-priority="3">Start Proyek</th>
                    <th data-priority="4">End Proyek</th>
                    <th data-priority="5">Status</th>
                    <th data-priority="6">Last Update</th>
                    <th data-priority="7">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($proyek as $p)
                <tr>
                    <td>{{$p->KODE_PROYEK}}</td>
                    <td>{{$p->NAMA_PROYEK}}</td>
                    <td>{{ date('d F Y',strtotime($p->START_PROYEK)) }}</td>
                    <td>{{ date('d F Y',strtotime($p->END_PROYEK)) }}</td>
                    <td>{{$p->STATUS}}</td>
                    <td>{{$p->LAST_UPDATE}}</td>
                    <td style="text-align: center;">
                        <div class="flex" style="justify-content: center;">
                            <a href="{{url('/admin/rencana/'.$p->KODE_PROYEK)}}">
                                <button href="javascript:;" title="Rencana" type="button" class="tooltip button px-2 mr-1 mb-2 bg-blue-300 dark:text-gray-300">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i data-feather="file-text" class="w-4 h-4 "></i>
                                    </span>
                                </button>
                            </a>
                            <a href="{{route('realisasi.show',$p->KODE_PROYEK)}}">
                                <button href="javascript:;" title="Realisasi" type="button" class="tooltip button px-2 mr-1 mb-2 bg-orange-300 dark:text-gray-300">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i data-feather="layers" class="w-4 h-4 "></i>
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