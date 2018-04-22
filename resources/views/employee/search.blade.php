<table class="table table-hover">
	<thead>
		<tr>
			<th>Имя</th>
			<th>Фамилия</th>
			<th>Дата рождения</th>
			<th>Дата наема</th>
			<th>Пол</th>
			<th>Департамент</th>
			<th>Должность</th>
			<th>Зарплата</th>
			<th>Менеджер</th>
		</tr>
	</thead>
	<tbody>
		@foreach($employees as $employee)
			<tr style="cursor: pointer;" data-toggle="modal" data-target="#specInfo" onclick="specInfo('{{$employee->first_name.' '.$employee->last_name}}', {{$employee->emp_no}});">
				<td>{{$employee->first_name}}</td>
				<td>{{$employee->last_name}}</td>
				<td>{{$employee->birth_date}}</td>
				<td>{{$employee->hire_date}}</td>
				<td>{{$employee->gender}}</td>
				<td>{{$employee->dept_name}}</td>
				<td>{{$employee->title}}</td>
				<td>{{$employee->salary}}</td>
				@php
					if(in_array($employee->emp_no, $dept_managers)) {
						echo "<td>&#10004;</td>";
					} else {
						echo "<td></td>";
					}
				@endphp
			</tr>
		@endforeach
	</tbody>
</table>

{{-- {{$employees->links()}} --}}

<div id="specInfo" class="modal fade" role="dialog">
	<div class="modal-dialog">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	<h4 class="modal-title" id="name">[фамилия имя]</h4>
	        </div>
	      	<div class="modal-body">
	        	<div class="salCharGoesHere">
	        		<canvas id="salariesChart" width="400" height="400"></canvas>
	        		<table class="table depsT">
	        			<thead>
	        				<tr>
	        					<th>Департамент</th>
	        					<th>Начал</th>
	        					<th>До</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        		
	        			</tbody>
	        		</table>
	        		<table class="table titlesT">
	        			<thead>
	        				<tr>
	        					<th>Должность</th>
	        					<th>Начал</th>
	        					<th>До</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        		
	        			</tbody>
	        		</table>
	        	</div>
	      	</div>
	    </div>
	</div>
</div>

<script>
	$('.table.table-hover').DataTable({
		'dom': 'tipr'
	});

	function specInfo(name, no) {
		$('.modal-header .modal-title').html(name);
		resultSL = [];
		resultSD = [];

		$.ajax({
			type: 'GET',
			url: '/employee/' + no,
			dataType: 'json',
			success: function(data) {
				for(i = 0; i < data.salaries.length; i++) {
					if(data.salaries[i].to_date == '9999-01-01'){
						resultSL.push('н/д')
					} else {
						resultSL.push(String(data.salaries[i].to_date));
					}
				 	resultSD.push(String(data.salaries[i].salary));
				}
				        	
				$('#salariesChart').remove();
  				$('.salCharGoesHere').append('<canvas id="salariesChart" width="400" height="400"></canvas>');


				var ctx = document.getElementById("salariesChart").getContext("2d");
				var myLineChart = new Chart(ctx, {
				    type: 'line',
				    data: {
				        labels: resultSL,
				        datasets: [{
				            label: 'Зарплаты за период работы',
				            data: resultSD,
				            backgroundColor: [
				                'rgba(255, 99, 132, 0.2)'
				            ],
				            borderColor: [
				                'rgba(255,99,132,1)'
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

				htmlD = '';
				for(i = 0; i < data.depts.length; i++) {
					if(data.depts[i].to_date == '9999-01-01') {
						htmlD += '<tr><td>'+data.depts[i].dept_name+'</td><td>'+data.depts[i].from_date+'</td><td>н/д</td></tr>'
					} else {
						htmlD += '<tr><td>'+data.depts[i].dept_name+'</td><td>'+data.depts[i].from_date+'</td><td>'+data.depts[i].to_date+'</td></tr>'
					}
				}
				$('.salCharGoesHere .depsT tbody').html(htmlD);

				htmlT = '';
				for(i = 0; i < data.titles.length; i++) {
					if(data.titles[i].to_date == '9999-01-01') {
						htmlT += '<tr><td>'+data.titles[i].title+'</td><td>'+data.titles[i].from_date+'</td><td>н/д</td></tr>'
					} else {
						htmlT += '<tr><td>'+data.titles[i].title+'</td><td>'+data.titles[i].from_date+'</td><td>'+data.titles[i].to_date+'</td></tr>'
					}
				}
				$('.salCharGoesHere .titlesT tbody').html(htmlT);
			}
		})
	}
</script>