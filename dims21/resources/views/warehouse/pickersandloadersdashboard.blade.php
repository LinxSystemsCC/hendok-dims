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

		<style>
			td{
				font-weight: 600;
			}
		</style>

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
							<th scope="col">REF</th>
							<th scope="col">CREATED</th>
							<th scope="col">ROUTE</th>
							<th scope="col">BAY</th>
							<th scope="col">PICKER</th>
							<th scope="col">LOADER</th>
							<th scope="col">LEADER</th>
							<th scope="col">STAGED</th>
							<th scope="col">LOADED</th>
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

	});

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
				$.each((data), function(index, item){
					if ((item.isStaged) == 1){
						row += '<tr id="row" class = "table bg-warning">';
					}else if ((item.isLoaded) == 1){
						row += '<tr id="row" class = "table bg-success">';
					}else{
						row += '<tr id="row" class = "table bg-danger">';
					}
					row += '<td id="Reference">'+item.strUnickReference+'</td>';
					row += '<td id="dtmCreated">'+item.dtmCreated+'</td>';
					row += '<td id="strRoute">'+item.strRoute+'</td>';
					row += '<td id="strStagingBay">'+item.strStagingBay+'</td>';
					row += '<td id="strPicker">'+item.strPicker+'</td>';
					row += '<td id="strLoader">'+item.strLoader+'</td>';
					row += '<td id="strTeamLeader">'+item.strTeamLeader+'</td>';
					row += '<td id="isStaged">'+item.isStaged+'</td>';
					row += '<td id="isLoaded">'+item.isLoaded+'</td>';
				}); 

				$('#datatable').append(row);
			},
		});
	};
</script>