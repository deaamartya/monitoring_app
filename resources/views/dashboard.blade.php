@extends('layout')
@section('content')
<div class="col-span-12 lg:col-span-8 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Grafik Jumlah Proyek Tahun {{ $current_year }}
                </h2>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <div class="flex flex-col xl:flex-row xl:items-center">
                    <div class="flex mb-5">
                        <div>
                            <div class="text-theme-20 dark:text-gray-300 text-lg xl:text-xl font-bold">{{ $jml_proyek_this_month }}</div>
                            <div class="text-gray-600 dark:text-gray-600">Bulan Ini</div>
                        </div>
                        <div class="w-px h-12 border border-r border-dashed border-gray-300 dark:border-dark-5 mx-4 xl:mx-6"></div>
                        <div>
                            <div class="text-gray-600 dark:text-gray-600 text-lg xl:text-xl font-medium">{{ $jml_proyek_last_month }}</div>
                            <div class="text-gray-600 dark:text-gray-600">Bulan Lalu</div>
                        </div>
                    </div>
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
                    <canvas id="line-chart" height="160" class="mt-6"></canvas>
                </div>
            </div>
        </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
var ctx = document.getElementById('line-chart').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct', 'Nov', 'Dec'],
    datasets: [{ 
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
        data: [65, 59, 80, 81, 56, 55, 40,60,55,30,78, 90],
        spanGaps: true,
        }, {
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
        data: [10, 20, 60, 95, 60, 78, 90,70,40,70,89,29],
        spanGaps: false,
        },{
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
        // notice the gap in the data and the spanGaps: false
        data: [0, 25, 30, 15, 34, 70, 80,77,43,60,80,65],
        spanGaps: true,
        },{
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
        data: [33, 40, 50, 45, 66, 75, 49,80,25,35,76, 40],
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
        // notice the gap in the data and the spanGaps: true
        data: [
            <?php echo $januari ?>,
            <?php echo $februari ?>,
            <?php echo $maret ?>,
            <?php echo $april ?>,
            <?php echo $mei ?>,
            <?php echo $juni ?>,
            <?php echo $juli ?>,
            <?php echo $agustus ?>,
            <?php echo $september ?>,
            <?php echo $oktober ?>,
            <?php echo $november ?>,
            <?php echo $desember ?>
        ],
        spanGaps: true,
        }]
  },
});
</script>
@endsection