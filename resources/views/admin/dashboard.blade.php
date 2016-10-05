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
			<div id="temps_div"></div>
			<?= $lava->render('LineChart', 'Temps', 'temps_div') ?>
		</div>
	</div>
@endsection