<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link href="{{ asset('/css/sb-admin-2.min.css')}}" rel="stylesheet">
	<script src="{{asset('/js/qrcode.min.js')}}"></script>
</head>

<body>
	 <div class="container text-dark">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2 mt-4">

                    </div>
                    <div class="col-md-8">
                        <center>
                            <br><br>
                            <h2>Kampung Sarosah</h2>
                            <h5><b>Payakumbuh</b></h5>
                            <span><span class="fa fa-envelope"></span> E-mail : kampungsarosah@gmail.com,
                                <span class="fa fa-phone"></span> phone :
                                081122334455</span>
                        </center>
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-12">
                        <hr style="border-top:4px double black">
                        <br>


                        <table style="width: 100%;">
                        	<tr>
                        		<td rowspan="3">
                        			<div id="qrcode"></div>
						            <script type="text/javascript">
						            new QRCode(document.getElementById("qrcode"), {
						                text:  "{{ $visitor->visitor_id }}",
						                width: 150,
						                height: 150,
						               });
						            </script>
                        		</td>
                        		<td style="text-align: left; width: 100px;">
                        			Registrasi
                        		</td>
                        		<td style="width: 5px; ">:</td>
                        		<td style="text-align: left;">{{ $visitor->user->register_date}}</td>
                        	</tr>
                                                   	<tr>
                        		<td style="text-align: left;">
                        			Nama
                        		</td>
                        		<td style="width: 5px; ">:</td>
                        		<td style="text-align: left;">{{ $visitor->visitor_name }}</td>
                        	</tr>

                        	<tr>
                        		<td style="text-align: left;">
                        			Email
                        		</td>
                        		<td style="width: 5px; ">:</td>
                        		<td style="text-align: left;">{{ $user->email }}</td>
                        	</tr>
                        </table>


                    </div>
                </div>
			<br>
			</div>
		</div>
	</div>
</body>

</html>A