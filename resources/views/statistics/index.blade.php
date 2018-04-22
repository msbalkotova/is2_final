@extends('layout')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<h4>Показатель текучести кадров компании</h4>
			<canvas id="tekuchestChart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6">
			<form action="">
				<h4>Количество определенных должностей в департаменте</h4>
				<select name="dept" id="dept">
					@foreach($departments as $department)
						<option value="{{$department->dept_no}}">{{$department->dept_name}}</option>
					@endforeach
				</select>
			</form>
			<div class="tPD">
				<canvas id="titlesPodepamChart" width="400" height="400"></canvas>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(function() {
			$.ajax({
				type: 'GET',
				url: '/employees/' + $('#dept').val(),
				dataType: 'json',
				success: function(data) {
					resultSL = []; resultSD1 = []; resultSD2 = [];
					for(i = 0; i < data.tekuchest.length; i++) {
						resultSL.push(data.tekuchest[i].year)
						resultSD1.push(data.tekuchest[i].hired)
						resultSD2.push(data.tekuchest[i].fired)
					}

					resultTPD = [data.titlesPodepam[0].asseng,data.titlesPodepam[0].eng,data.titlesPodepam[0].manager,data.titlesPodepam[0].seneng,data.titlesPodepam[0].senstaff,data.titlesPodepam[0].staff,data.titlesPodepam[0].techleader]

					console.log(resultTPD)
					var ctx1 = document.getElementById("titlesPodepamChart").getContext("2d");
					var myLineChart1 = new Chart(ctx1, {
					    type: 'bar',
					    data: {
					        labels: ['Assistant Engineer', 'Engineer', 'Manager', 'Senior Engineer', 'Senior Staff', 'Staff', 'Technique Leader'],
					        datasets: [{
					        	label: 'Число человек в ' + $('#dept').children("option").filter(":selected").text(),
					            data: resultTPD,
					            fill:false,
					            backgroundColor: [
					                '#0033cc',
					                '#0033cc',
					                '#0033cc',
					                '#0033cc',
					                '#0033cc',
					                '#0033cc',
					                '#0033cc',
					            ],
					            borderColor: [
					                '#0099ff',
					                '#0099ff',
					                '#0099ff',
					                '#0099ff',
					                '#0099ff',
					                '#0099ff',
					                '#0099ff',
					            ],
					            borderWidth: 1
					        }]
					    },
					    options: {
					        scales: {
					            yAxes: [{
					                ticks: {
					                    beginAtZero:true
					                }
					            }]
					        }
					    }
					});

					///ssss
 					var ctx = document.getElementById("tekuchestChart").getContext("2d");
					var myLineChart = new Chart(ctx, {
					    type: 'line',
					    data: {
					        labels: resultSL,
					        datasets: [{
					            label: 'Количество ушедших сотрудников',
					            data: resultSD1,
					            fill:false,
					            backgroundColor: [
					                'rgba(255, 99, 132, 0.2)'
					            ],
					            borderColor: [
					                'rgba(255,99,132,1)'
					            ],
					            borderWidth: 1
					        }, {
					            label: 'Количество новых сотрудников',
					            data: resultSD2,
					            fill:false,
					            backgroundColor: [
					                '#b8dedf'
					            ],
					            borderColor: [
					                '#648196'
					            ],
					            borderWidth: 1
					        }]
					    },
					    options: {
					        scales: {
					            yAxes: [{
					                ticks: {
					                    beginAtZero:true
					                }
					            }]
					        }
					    }
					});
				}
			})

			$('#dept').change(function() {
				$('#titlesPodepamChart').remove();
  				$('.tPD').append('<canvas id="titlesPodepamChart" width="400" height="400"></canvas>');
				$.ajax({
					type: 'GET',
					url: '/employees/' + $('#dept').val(),
					dataType: 'json',
					success: function(data) {
						resultTPD = [data.titlesPodepam[0].asseng,data.titlesPodepam[0].eng,data.titlesPodepam[0].manager,data.titlesPodepam[0].seneng,data.titlesPodepam[0].senstaff,data.titlesPodepam[0].staff,data.titlesPodepam[0].techleader]

						console.log(resultTPD)
						var ctx1 = document.getElementById("titlesPodepamChart").getContext("2d");
						var myLineChart1 = new Chart(ctx1, {
						    type: 'bar',
						    data: {
						        labels: ['Assistant Engineer', 'Engineer', 'Manager', 'Senior Engineer', 'Senior Staff', 'Staff', 'Technique Leader'],
						        datasets: [{
						        	label: 'Число человек в ' + $('#dept').children("option").filter(":selected").text(),
						            data: resultTPD,
						            fill:false,
						            backgroundColor: [
						                '#0033cc',
						                '#0033cc',
						                '#0033cc',
						                '#0033cc',
						                '#0033cc',
						                '#0033cc',
						                '#0033cc',
						            ],
						            borderColor: [
						                '#0099ff',
						                '#0099ff',
						                '#0099ff',
						                '#0099ff',
						                '#0099ff',
						                '#0099ff',
						                '#0099ff',
						            ],
						            borderWidth: 1
						        }]
						    },
						    options: {
						        scales: {
						            yAxes: [{
						                ticks: {
						                    beginAtZero:true
						                }
						            }]
						        }
						    }
						});
					}
				})
			})
		})
	</script>
@endsection