@extends('admin.layouts.app')
@section('title', $page)
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">Today's Stats</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3 col-lg-3">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-3">
											<i class="fa fa-pencil-square-o fa-3x"></i>
										</div>
										<div class="col-md-9 text-right">
											<div class="huge">{{$todayStats['quizzes']}}</div>
											<div>New Quizzes</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-3">
											<i class="fa fa-user fa-3x"></i>
										</div>
										<div class="col-md-9 text-right">
											<div class="huge">{{$todayStats['users']}}</div>
											<div>New Users</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="panel panel-info">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-3">
											<i class="fa fa-check-square fa-3x"></i>
										</div>
										<div class="col-md-9 text-right">
											<div class="huge">{{$todayStats['attempts']}}</div>
											<div>New Quiz Attempts</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-3">
											<i class="fa fa-share fa-3x"></i>
										</div>
										<div class="col-md-9 text-right">
											<div class="huge">{{$todayStats['shares']}}</div>
											<div>New Quiz Shares</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">Overall Stats</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3 col-lg-3">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-3">
											<i class="fa fa-pencil-square-o fa-3x"></i>
										</div>
										<div class="col-md-9 text-right">
											<div class="huge">{{$overallStats['quizzes']}}</div>
											<div>Total Quizzes</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-3">
											<i class="fa fa-user fa-3x"></i>
										</div>
										<div class="col-md-9 text-right">
											<div class="huge">{{$overallStats['users']}}</div>
											<div>Total Users</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="panel panel-info">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-3">
											<i class="fa fa-check-square fa-3x"></i>
										</div>
										<div class="col-md-9 text-right">
											<div class="huge">{{$overallStats['attempts']}}</div>
											<div>Total Quiz Attempts</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-3">
											<i class="fa fa-share fa-3x"></i>
										</div>
										<div class="col-md-9 text-right">
											<div class="huge">{{$overallStats['shares']}}</div>
											<div>Total Quiz Shares</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="barchart_material" style="width: 900px; height: 500px"></div>
		</div>
	</div>
@endsection
@section('admin-scripts')
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    	google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
        	var data = google.visualization.arrayToDataTable([['Date', 'Quiz Attempts', 'New Registrations'],
        	@foreach($lastNDaysActivity as $activity)
        		['{{$activity["date"]}}', {{$activity['attempts']}}, {{ $activity['users'] }}],
        	@endforeach
    	]);

        var options = {
	            title: 'Quiz Attempts, New Registrations: last 30 days Analysis',
	            subtitle: 'Quiz Attempts, New Registrations: last 30 days',
	            curveType: 'function',
	          	legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('barchart_material'));

        chart.draw(data, options);
      }
    </script>
@endsection