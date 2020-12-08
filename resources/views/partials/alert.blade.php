@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    <!-- <i class="fa fa-check mx-2"></i> -->
    {{ ucwords(session()->get('success')) }}
</div>
@endif

@if(session()->has('delete'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    <!-- <i class="fa fa-check mx-2"></i> -->
    {{ ucwords(session()->get('delete')) }}
</div>
@endif

@if(session()->has('warning'))
<div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    <!-- <i class="fa fa-check mx-2"></i> -->
    {{ ucwords(session()->get('warning')) }}
</div>
@endif


@if(count($errors) > 0 )
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul class="p-0 m-0" style="list-style: none;">
        @foreach($errors->all() as $error)
        <li>{{ ucwords($error) }}</li>
        @endforeach
    </ul>
</div>
@endif