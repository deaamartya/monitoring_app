@extends('layout')
@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
        <!-- BEGIN: General Report -->
        <div class="col-span-12 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    General Report {{ $current_year }}
                </h2>
                <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="file-text" class="report-box__icon text-theme-33"></i> 
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">{{ $jml_proyek_this_month }}</div>
                            <div class="text-base text-gray-600 mt-1">Jumlah Proyek</div>
                            <div class="mt-4"> 
                            <span class="px-3 py-2 rounded-full bg-theme-33 text-white mr-1">Bulan Ini</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="file-text" class="report-box__icon text-theme-12"></i> 
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">{{ $jml_proyek_last_month }}</div>
                            <div class="text-base text-gray-600 mt-1">Jumlah Proyek</div>
                            <div class="mt-4">
                            <span class="px-3 py-2 rounded-full bg-theme-12 text-white mr-1">Bulan Lalu</span> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="file-text" class="report-box__icon text-theme-9"></i> 
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">{{ $jml_proyek_this_year }}</div>
                            <div class="text-base text-gray-600 mt-1">Jumlah Proyek</div>
                            <div class="mt-4">
                            <span class="px-3 py-2 rounded-full bg-theme-9 text-white mr-1">Tahun Ini</span> 
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="users" class="report-box__icon text-theme-11"></i> 
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">{{ $jml_proyek_all }}</div>
                            <div class="text-base text-gray-600 mt-1">Jumlah Proyek Keseluruhan</div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- END: General Report -->
        <!-- BEGIN: Sales Report -->
        <div class="col-span-12 lg:col-span-8 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Grafik Jumlah Proyek Per Tahun
                </h2>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <div class="flex flex-col xl:flex-row xl:items-center">
                    <div class="flex mb-5">
                        <div>
                            <div class="text-theme-20 dark:text-gray-300 text-lg xl:text-xl font-bold">{{ $jml_proyek_this_year }}</div>
                            <div class="text-gray-600 dark:text-gray-600">Tahun Ini</div>
                        </div>
                        <div class="w-px h-12 border border-r border-dashed border-gray-300 dark:border-dark-5 mx-4 xl:mx-6"></div>
                        <div>
                            <div class="text-gray-600 dark:text-gray-600 text-lg xl:text-xl font-medium">{{ $jml_proyek_last_year }}</div>
                            <div class="text-gray-600 dark:text-gray-600">Tahun Lalu</div>
                        </div>
                    </div>
                </div>
                <div class="report-chart">
                    <canvas id="line-chart" height="160" class="mt-6"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Sales Report -->
       
        <!-- BEGIN: Weekly Best Sellers -->
        @if(count($list_realisasi) > 0)
        <div class="col-span-12 xl:col-span-4 mt-6">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Input Realisasi Terbaru
                </h2>
            </div>
            
            <div class="mt-5">
            
                @foreach($list_realisasi as $list)
                    <div class="intro-y">
                        <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                            <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                                @if($list->ID_TIPE != 5)
                                <i class="w-8 h-8" data-feather="dollar-sign"></i>
                                @else
                                <i class="w-8 h-8" data-feather="percent"></i>
                                @endif
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="text-gray-600 text-xs mb-2">{{ $list->LAST_UPDATE }}</div>
                                <div> {{ $list->tipe->NAMA_TIPE }} {{ $list->VALUE }} 
                                    @if($list->ID_TIPE == 5)
                                    %
                                    @endif</div>
                                <div class="font-medium">Proyek #{{ $list->KODE_PROYEK }}</div>
                            </div>
                            <div class="py-1 px-2 rounded-full text-xs bg-theme-10 text-white cursor-pointer font-medium">NEW</div>
                        </div>
                    </div>
                @endforeach
                <a href="{{ url('admin/realiasi') }}" class="intro-y w-full mt-4 block text-center rounded-md py-4 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">View More</a> 
            </div>
        </div>
        @endif
        <!-- END: Weekly Best Sellers -->
       
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
var ctx = document.getElementById('line-chart').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [<?php foreach($data as $d){
                    echo $d->TAHUN.",";
                } ?>
    ],
    datasets: [{ 
        data: [
            <?php foreach($data as $d){
                echo $d->VALUE.",";
            } ?>
        ],
        borderColor: "#3e95cd",
        fill: false
      }]
  },
  options: {
    legend: {
        display: false
    }
  }
});

</script>
@endsection