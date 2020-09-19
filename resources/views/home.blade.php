@extends('layouts.main')
@section('title') Dashboard @endsection
@section('heading')
<script type="text/javascript" src="{{ asset('chart.js')}}"></script>
<script src="{{ asset('randomcolor.min.js') }}"></script>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
   <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
         class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<!-- Content Row -->
<div class="row">
   <!-- Earnings (Monthly) Card Example -->
   <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Payment</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ $total_payment }}</div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Earnings (Monthly) Card Example -->
   <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Saldo</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{$saldo_total}}
                  </div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-credit-card fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Earnings (Monthly) Card Example -->
   <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">jumlah tiket</div>
                  <div class="row no-gutters align-items-center">
                     <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $jml_tiket }} Tiket</div>
                  </div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-clone fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Pending Requests Card Example -->
   <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Pengunjung</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jml_visitor }} Orang</div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Content Row -->
<div class="row">
   <!-- Area Chart -->
   <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
         <!-- Card Header - Dropdown -->
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Pendapatan</h6>

            <div class="row">
               <div class="col-sm-12">
                  <select class="form-control" id="tahun">
                     <option value="">-- Pilih Tahun ---</option>
                     @foreach($paymenttahun as $datatahun)
                     <option value="{{ $datatahun->payment_date }}">
                        {{ $datatahun->payment_date }}</option>
                     @endforeach
                  </select>
                  <script>
                     document.getElementById("tahun").value = "{{ $year }}";

                     document.getElementById("tahun").addEventListener("change", function(){
                        window.location.href = "{{ url('home') }}?year=" + this.value;
                     });
                  </script>
               </div>
            </div>
         </div>
         <!-- Card Body -->
         <div class="card-body showchart">
            <canvas id="line-chart" width="800" height="450"></canvas>
         </div>
      </div>
   </div>
   <!-- Pie Chart -->
   <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
         <!-- Card Header - Dropdown -->
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Penjualan per kategori Tiket</h6>
            <div class="row">
               <div class="col-sm-12">
                  <select class="form-control" id="tahundonat">
                     <option value="">-- Pilih Tahun ---</option>
                     @foreach($paymenttahun as $datatahun)
                     <option value="{{ $datatahun->payment_date }}">
                        {{ $datatahun->payment_date }}</option>
                     @endforeach
                  </select>
                  <script>
                     document.getElementById("tahundonat").value = "{{ $yeard }}";
            
                                 document.getElementById("tahundonat").addEventListener("change", function(){
                                    window.location.href = "{{ url('home') }}?yeard=" + this.value;
                                 });
                  </script>
               </div>
            </div>
         </div>
         <!-- Card Body -->
         <div class="card-body">
            <canvas id="doughnut-chart" width="800" height="750"></canvas>
         </div>
      </div>
   </div>
</div>
<script src="{{asset('/vendor/jquery/jquery.min.js')}}"></script>

<script>
   $(document).ready(function () {
      var payments_year = <?=json_encode($payments_report)?>;
      console.log(payments_year);
      var labels = [];
      var data = [];
      var banyak_data = payments_year.length;

      // ubah format data baris dan kolom dari variabel payment_year agar sesuai dengan format sebaris pada
      // chartks
      for(var x = 0;  x < banyak_data; x++)
      {
         labels.push(payments_year[x].bulan.substr(0, 3));
         data.push(payments_year[x].total);
      }

      console.log(labels);
      console.log(data);

   new Chart(document.getElementById("line-chart"), {
   type: 'line',
   data: {
      labels: labels,
      datasets: [{
                  data: data,
                  label: "Total",
                  borderColor: "#3e95cd",
                  fill: false
                  }
               ]
      },
      options: {
         legend: { display: false },
         title: {
         display: true,
         text: 'Payment Tahun : <?=$year?>',
      }
   }
   });
   });
</script>
<script>
   $(document).ready(function () {
      var tiket_name = <?=json_encode($tiket_report)?>;
      var labeld = [];
      var datad = [];
      var banyak_tiket = tiket_name.length;
      var warna = randomColor({
         luminosity: 'bright',
         hue: 'random',
         count: tiket_name.length
      });
      for(var x = 0; x < banyak_tiket; x++) { 
         labeld.push(tiket_name[x].ticket_id);
         datad.push(tiket_name[x].total); }
      new Chart(document.getElementById("doughnut-chart"), {
      type: 'doughnut',
      data: {
      labels: labeld,
      datasets: [
      {
      label: "Jumlah tiket",
      backgroundColor: warna,
      data: datad
      }
      ]
      },
      options: {
      title: {
      display: true,
      text: 'Penjualan Tiket : <?=$yeard?>'
      }
      }
      });
   })
</script>

@endsection
@section('content')
@endsection