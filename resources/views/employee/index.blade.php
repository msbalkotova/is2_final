@extends('layout')

@section('styles')
	<style>
		.spinner {
		  margin: 100px auto;
		  width: 50px;
		  height: 40px;
		  text-align: center;
		  font-size: 10px;
		}

		.spinner > div {
		  height: 100%;
		  width: 6px;
		  display: inline-block;
		  
		  -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
		  animation: sk-stretchdelay 1.2s infinite ease-in-out;
		}

		.spinner .rect2 {
		  -webkit-animation-delay: -1.1s;
		  animation-delay: -1.1s;
		}

		.spinner .rect3 {
		  -webkit-animation-delay: -1.0s;
		  animation-delay: -1.0s;
		}

		.spinner .rect4 {
		  -webkit-animation-delay: -0.9s;
		  animation-delay: -0.9s;
		}

		.spinner .rect5 {
		  -webkit-animation-delay: -0.8s;
		  animation-delay: -0.8s;
		}

		@-webkit-keyframes sk-stretchdelay {
		  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
		  20% { -webkit-transform: scaleY(1.0) }
		}

		@keyframes sk-stretchdelay {
		  0%, 40%, 100% { 
		    transform: scaleY(0.4);
		    -webkit-transform: scaleY(0.4);
		  }  20% { 
		    transform: scaleY(1.0);
		    -webkit-transform: scaleY(1.0);
		  }
		}
		
		.tableGoesHere {
		  margin-top: 15px;
		}
	</style>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-5">
			<input class="form-control" type="text" name="search" id="name" placeholder="Имя и/или фамилия">	
		</div>
		<div class="col-md-5">
			<select class="form-control" name="department" id="department">
				<option value="">Все департаменты</option>
				@foreach($departments as $department)
					<option value="{{$department->dept_no}}">{{$department->dept_name}}</option>
				@endforeach
			</select>	
		</div>
		<div class="col-md-2">
			<button id="searchFilter" class="btn btn-primary form-control">Поиск</button>
		</div>
	</div>
	
	<div class="tableGoesHere"></div>

	<div class="spinner">
		<div class="rect1 bg-primary"></div>
		<div class="rect2 bg-primary"></div>
	    <div class="rect3 bg-primary"></div>
		<div class="rect4 bg-primary"></div>
		<div class="rect5 bg-primary"></div>
	</div>
@endsection

@section('scripts')
	<script>
		$(function() {
			$.ajax({
				type: 'POST',
				url: '/',
				data: {dept: $('#department').val(), name: $('#name').val()},
				success: function(data) {
					$('.spinner').css('display','none')
					$('.tableGoesHere').html(data)
				}
			})

			$('#searchFilter').click(function() {
				$('.tableGoesHere').empty()
				$('.spinner').css('display','block')
				$.ajax({
					type: 'POST',
					url: '/',
					data: {dept: $('#department').val(), name: $('#name').val()},
					success: function(data) {
						$('.spinner').css('display','none')
						$('.tableGoesHere').html(data)
					}
				})
			})
		})
	</script>

	<script>
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
	</script>
@endsection