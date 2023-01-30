<!doctype html>
<html lang="en">
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<title>Dashboard</title>
		<link rel="icon" href="{{asset('images/1024.png')}}" type="image/icon type">
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">

	</head>
	<body>
		<div class="col-md-12 ms-sm-auto col-lg-12" style="padding:0px !important;">
			<header class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 shadow">
				<h1 id="stats" style="padding: 10px;">PICKING AND LOADING DASHBOARD</h1><br>
			</header>
			
			<div class="table-responsive">
				<table class="table table-dark table-lg" id="datatable">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">AREAS</th>
							<th scope="col">ORDER/ROUTE TYPE</th>
							<th scope="col">DRIVER</th>
							<th scope="col">ASSISTANT</th>
							<th scope="col">TRUCK</th>
							<th scope="col">STATUS</th>
							<th scope="col">STOPS</th>
							<th scope="col">STOPS DEL</th>
							<th scope="col">RETURNS</th>
							<th scope="col">LOADING BAY</th>
							<th scope="col">TIME SPENT</th>
							<th scope="col">AMOUNT</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>

		<div class="modal fade" id="routemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen"> 
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Route Report</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body row">
						<div class="px-3" id="ordertable" style="height: 100%; width:50%;"></div>
						<div class="p-3" id="map" style="height: 100%; width:50%;"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
	</body>

</html>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<!--script src="../assets/dist/js/bootstrap.bundle.min.js"></script-->
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="{{asset('js/main.js')}}"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5vAgb-nawregIa5gRRG34wnabasN3blk"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('focus', ':input', function() {
        $(this).attr('autocomplete', 'off');
    });
	
    $(document).ready(function() {
		getDashboard();

		function getDashboard(){
			$.ajax({
				url: '{!!url("/getpickersandloadersdashboard")!!}',
				type: "GET",
				data: {

				},
				success: function(data) {
					//console.log(data);
					var row = '';

					//location.reload();
					$.each(JSON.parse(data), function(index, item){
						if ((item.doneBusy) == "done"){
							row += '<tr id="row" class = "table bg-success">';
						}else{
							row += '<tr id="row" class = "table bg-danger">';
						}
						row += '<td id="RouteID">'+item.DeliveryDateRoutingID+'</td>';
						row += '<td id="Route">'+item.Route+'</td>';
						row += '<td id="OrderType">'+item.OrderType+'</td>';
						row += '<td id="DriverName">'+item.DriverName+'</td>';
						row += '<td id="Assistant">'+item.ASSIS+'</td>';
						row += '<td id="TruckName">'+item.TruckName+'</td>';
						row += '<td id="Status">'+item.doneBusy+'</td>';
						row += '<td id="Stops">'+item.NoOfStops+'</td>';
						row += '<td id="StopsDelv">'+item.stopsDelv+'</td>';
						row += '<td id="Returns">'+item.cReq+'</td>';
						row += '<td id="LoadingBay">'+item.strDoorName+'</td>';
						row += '<td id="TravelTime">'+item.Travelling+'</td>';
						row += '<td id="Amount">'+item.routeAmaount+'</td>';
						row += '</tr>';
					}); 

					$('#datatable').append(row);
				},
			});
		};

	});
</script>