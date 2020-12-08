@extends('admin')

    @section('tasks')
    	<div class='row'>
	    	<div class="col-md-6">
	    		<form action="{{route('add.category')}}" method="POST">
	    			@csrf
			    	<label>Add Category</label>
			    	<input class="form-control" name='name' type="text" placeholder="Category">
			    	<button class="btn btn-success mt-2 btn-sm">Save</button>
		    	</form>
	    	</div>
	    	<div class="col-md-6">
	    		<ul class="list-group">
				  <li class="list-group-item active">Categories</li>
				  @foreach($categories as $category)
				  <li class="list-group-item">{{ $category->name }}</li>
				  @endforeach
				</ul>
	    	</div>
		</div>
    @endsection
