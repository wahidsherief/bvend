@extends('admin.admin')

@section('content')
    <form action="{{ route('vend') }}" method="POST">
        @csrf
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
<div class="card mt-4">
<img class="card-img-top" src="{{ $product->image }}" alt="Card image cap">
<div class="card-body">
<h5 class="card-title">{{ $product->product_name }}</h5>
<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
<button type='submit' class="btn btn-block btn-success">Vend</button>
</div>
</div>
                </div>
            @endforeach
        </div>
    </form>
@endsection
