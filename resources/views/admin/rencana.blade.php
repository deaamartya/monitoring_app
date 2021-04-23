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
function tgl_indo_table($tanggal){
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
        <h2 class="text-lg font-medium mr-auto ml-3">Progress Plan #{{ $kode_proyek }} - {{ $nama_proyek }}</h2>
    </div>
</div>
<div class="grid grid-cols-12 gap-6">
        <div class="col-span-6 lg:col-span-6 mt-2">
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <div class="flex flex-col xl:flex-row xl:items-center">
                    <!--
                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <button class="dropdown-toggle button font-normal border dark:border-dark-5 text-white dark:text-gray-300 relative flex items-center text-gray-700"> Filter by Category <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                        <div class="dropdown-box w-40">
                            <div class="dropdown-box__content box dark:bg-dark-1 p-2 overflow-y-auto h-32"> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">PC & Laptop</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Smartphone</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Electronic</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Photography</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Sport</a> </div>
                        </div>
                    </div>
                    -->
                </div>
                <div class="report-chart">
                <!--
                    <canvas id="report-line-chart" height="160" class="mt-6"></canvas>
                    -->
                    <canvas id="line-chart" class="mt-6"></canvas>
                </div>
            </div>
        </div>
        <div class="col-span-6 lg:col-span-6 mt-2">
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <div class="flex flex-col xl:flex-row xl:items-center">
                    <!--
                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <button class="dropdown-toggle button font-normal border dark:border-dark-5 text-white dark:text-gray-300 relative flex items-center text-gray-700"> Filter by Category <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                        <div class="dropdown-box w-40">
                            <div class="dropdown-box__content box dark:bg-dark-1 p-2 overflow-y-auto h-32"> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">PC & Laptop</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Smartphone</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Electronic</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Photography</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Sport</a> </div>
                        </div>
                    </div>
                    -->
                </div>
                <div class="report-chart">
                <!--
                    <canvas id="report-line-chart" height="160" class="mt-6"></canvas>
                    -->
                    <canvas id="line-chart2" class="mt-6"></canvas>
                </div>
            </div>
        </div>
</div>
<div class="col-span-6 lg:col-span-8 mt-2">
    <div class="intro-y box p-5 mt-5">
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
   
    <div class="col-span-6 intro-y block sm:flex items-center h-10">
        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
            <a data-toggle="modal" data-target="#tambah_rencana">
                <button class="ml-3 button box flex items-center shadow-md bg-theme-33 text-white buttons-html5 buttons-pdf" href="#" type="button"> <i data-feather="plus-circle" class="hidden sm:block w-6 h-6 mr-2"></i> Tambah Progress Plan </button>
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
                    <th data-priority="3">Progress Plan(%)</th>
                    <th data-priority="4"style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($progress as $p)
                <tr>
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ tgl_indo_table($p->TANGGAL) }}</td>
                    <td>{{$p->PV}}</td>
                    <td>{{ $p->Rencana }}%</td>
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
            <div class="modal__content modal__content py-5 pl-3 pr-3 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="plus-circle" class="w-8 h-8 mr-2"></i>Tambah Progress Plan</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <form action="{{ route('rencana.store') }}" method="POST" class="needs-validation" novalidate id="tambah-rencana">
                    @csrf
                    <div class="intro-y box p-3 mt-3 sm:mt-3 mr-3 bg-blue-400 text-white" style="background-color: #1c3faa;">     
                        <div class="col-span-12">
                            <h2 class="font-medium mr-auto ml-3"  >Pelaksanaan Proyek : {{ tgl_indo_table($start_proyek) }} - {{ tgl_indo_table($end_proyek)}} </h2>
                        </div>
                    </div>
                    <input type="hidden" name="KODE_PROYEK" value="{{ $kode_proyek }}">
                    <br>
                    <div class="grid grid-cols-12 gap-4 row-gap-3 p-3">
                        <div class="col-span-6">
                            <label class="font-semibold text-lg">Bulan</label> 
                            <select data-search="true" class="tail-select w-full" name="bln"  placeholder="Select Bulan...">
                            <option selected disabled>Pilih Bulan.....</option>
                                <?php
                                $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                $jlh_bln=count($bulan);
                                for($c=0; $c<$jlh_bln; $c+=1){
                                    $i = $c+1;
                                    echo"<option value=$i> $bulan[$c] </option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-span-6">
                            <label class="font-semibold text-lg">Tahun</label> 
                            <select data-search="true" class="tail-select w-full" name="thn"  placeholder="Select Tahun...">
                                <option selected disabled>Pilih Tahun.....</option>
                                <?php
                                    $now=date('Y');
                                    for ($a=$now; $a<$now+10; $a++){ 
                                        echo "<option value=$a >$a</option>";
                                    }
                                    ?>
                            </select>
                        </div>

                        <div class="col-span-12">
                        @error('messages')
                        <small class="text-theme-6">Sudah terdapat progress plan pada bulan dan tahun tersebut.</small>
                         @enderror           
                        </div>
                    
                        <div class="col-span-12"> 
                            <label class="font-semibold text-lg">PV</label>
                            <input type="number" class="input w-full border mt-2 flex-1" name="PV_VALUE" required>
                        </div>

                        <div class="col-span-12"> 
                            <label class="font-semibold text-lg">Progress Plan (%)</label>
                            <input type="number" class="input w-full border mt-2 flex-1" name="RENCANA_VALUE" required>
                        </div>
                        
                        <div class="col-span-12"> 
                            <div class="modal-footer mt-5">
                                <div class="text-right">
                                    <button type="button" class="button w-24 shadow-md mr-1 mb-2 bg-red-500 text-white" data-dismiss="modal">Cancel</button> 
                                    <button class="button items-right w-24 shadow-md mr-1 mb-2 justify-right bg-theme-1 text-white shadow-md" type="submit">Simpan</button>
                                </div>
                            </div>
                        </div>
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
                        <h2 class="font-bold text-2xl flex"><i data-feather="edit" class="w-8 h-8 mr-2"></i>Edit Progress Plan #{{ $loop->iteration }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto" id="close_{{$p->TANGGAL}}"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>
                <br>
                <div class="modal-body">
                    <form action="{{ route('rencana.update', $p->TANGGAL) }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="KODE_PROYEK" value="{{ $kode_proyek }}">
                    <div class="col-span-12"> 
                        <label class="font-semibold text-lg">Tanggal</label>
                        <input disabled class="input border mr-2 w-full mt-2"  value="{{ tgl_indo_table($p->TANGGAL) }}">
                        <input type="hidden" class="input border mr-2 w-full mt-2" name="TANGGAL_EDIT" value="{{ $p->TANGGAL }}">
                    </div>
                <br>
                    <div class="col-span-12"> 
                        <label class="font-semibold text-lg">PV</label>
                        <input type="number" class="input w-full border mt-2 flex-1" name="PV_VALUE_EDIT" value="{{ $p->PV }}" required>
                    </div>
                <br>
                    <div class="col-span-12"> 
                        <label class="font-semibold text-lg">Progress Plan (%)</label>
                        <input type="number" class="input w-full border mt-2 flex-1" name="RENCANA_VALUE_EDIT" value="{{ $p->Rencana }}" required>
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

        <div class="modal" id="delete_{{ date('d-m-Y', strtotime($p->TANGGAL)) }}">
            <div class="modal__content modal__content--lg p-5 ml-auto">
                <div class="modal-header">
                    <div class="modal__content relative"> 
                    </div>
                    <div class="flex px-2 sm:pb-3 sm:pt-1 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-bold text-2xl flex"><i data-feather="trash-2" class="w-8 h-8 mr-2"></i>Hapus Progress Plan #{{ $loop->iteration }}</h2>
                        <a data-dismiss="modal" href="javascript:;" class="mr-3 ml-auto"><i data-feather="x" class="w-8 h-8 text-gray-500"></i></a>
                    </div>
                </div>

                <form action="{{ route('rencana.destroy', $p->KODE_PROYEK) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" value="{{$p->TANGGAL}}"name="TANGGAL_DELETE">
                    <input type="hidden" value="{{$p->ID_TIPE}}" name="ID_TIPE">
                    <div class="text-base mt-5">
                        Apakah Anda yakin ingin menghapus progress plan untuk proyek {{ $nama_proyek }} pada bulan {{ tgl_indo_table($p->TANGGAL) }} ?
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
</div>
    </div>
@endsection

@section('script')
<!--Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
            responsive: true
        })
        .columns.adjust()
        .responsive.recalc();
});
var ctx = document.getElementById('line-chart').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [<?php 
            foreach($data[1] as $c){
                foreach($c as $d){
                    echo '"'.$d->NAMA.'"'.",";
                }
            }
            ?>],
    datasets: [
        { 
            label: "PV",
            fill: false,
            lineTension: 0.1,
            backgroundColor: 'transparent',
            pointBorderColor: 'transparent',
            borderColor: "red", // The main line color
            borderCapStyle: 'square',
            borderDash: [], // try [5, 15] for instance
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "black",
            pointBorderWidth: 1,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "yellow",
            pointHoverBorderColor: "brown",
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            pointHitRadius: 10,
            // notice the gap in the data and the spanGaps: true
            data: [
                <?php 
                foreach($data[1] as $c){
                    foreach($c as $d){
                        if($d->VALUE == null){
                            echo "0,";
                        }
                        else{
                            echo $d->VALUE.",";
                        }
                    }
                } 
                ?>
            ],
            spanGaps: true,
        }, 
        {
            label: "EV",
            fill: true,
            lineTension: 0.1,
            backgroundColor: "transparent",
            borderColor: "rgb(167, 105, 0)",
            borderCapStyle: 'square',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "black",
            pointBackgroundColor: "transparent",
            pointBorderWidth: 1,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "yellow",
            pointHoverBorderColor: "brown",
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            pointHitRadius: 10,
            // notice the gap in the data and the spanGaps: false
            data: [
                <?php 
                foreach($data[2] as $c){
                    foreach($c as $d){
                        if($d->VALUE == null){
                            echo "0,";
                        }
                        else{
                            echo $d->VALUE.",";
                        }
                    }
                } 
                ?>
            ],
            spanGaps: false,
        },
        {
            label: "AC",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "transparent",
            borderColor: "green",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "black",
            pointBackgroundColor: "transparent",
            pointBorderWidth: 1,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "brown",
            pointHoverBorderColor: "yellow",
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            pointHitRadius: 10,
            data: [
                <?php 
                foreach($data[3] as $c){
                    foreach($c as $d){
                        if($d->VALUE == null){
                            echo "0,";
                        }
                        else{
                            echo $d->VALUE.",";
                        }
                    }
                } 
                ?>
            ],
            spanGaps: true,
        }
    ]
  },
});
var ctx = document.getElementById('line-chart2').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [<?php 
            foreach($data[1] as $c){
                foreach($c as $d){
                    echo '"'.$d->NAMA.'"'.",";
                }
            } 
            ?>],
    datasets: [{ 
        label: "Progress Plan",
        fill: true,
        lineTension: 0.1,
        backgroundColor: 'transparent',
        pointBorderColor: 'black',
        borderColor: "blue", // The main line color
        borderCapStyle: 'square',
        borderDash: [], // try [5, 15] for instance
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderWidth: 1,
        pointHoverRadius: 8,
        pointHoverBorderWidth: 2,
        pointRadius: 4,
        pointHitRadius: 10,
        // notice the gap in the data and the spanGaps: true
        data: [
            <?php 
            foreach($data[4] as $c){
                foreach($c as $d){
                    if($d->VALUE == null){
                        echo "0,";
                    }
                    else{
                        echo $d->VALUE.",";
                    }
                }
            } 
            ?>
        ],
        spanGaps: false,
        },{
        label: "Realisasi",
        fill: false,
        lineTension: 0.1,
        backgroundColor: "transparent",
        borderColor: "purple", // The main line color
        borderCapStyle: 'square',
        borderDash: [], // try [5, 15] for instance
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: "black",
        pointBackgroundColor: "transparent",
        pointBorderWidth: 1,
        pointHoverRadius: 8,
        pointHoverBackgroundColor: "yellow",
        pointHoverBorderColor: "brown",
        pointHoverBorderWidth: 2,
        pointRadius: 4,
        pointHitRadius: 10,
        data: [
            <?php 
            foreach($data[5] as $c){
                foreach($c as $d){
                    if($d->VALUE == null){
                        echo "0,";
                    }
                    else{
                        echo $d->VALUE.",";
                    }
                }
            } 
            ?>
        ],
      }]
  },

});
</script>
@endsection