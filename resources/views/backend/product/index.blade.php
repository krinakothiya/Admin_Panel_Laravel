@extends('layouts.backend_app')

@section('heading')
<h1 class="mt-4">Product List</h1>
@endsection

@section('backend_content')
<div class="row">
    <!-- table start -->
    <div class="col-sm-12">
        
        <div class="card">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('create') }}" class="btn btn-dark mb-3 mt-4 me-5" role="button" style="text-decoration: none;">Add New</a>
            </div>
            @if (Session::has('success'))
            <div class="col-md-10">
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            </div>
            @endif
            <div class="card-body">
                <div class="dt-responsive table-responsive">

                    <table class="table table-striped table-bordered nowrap text-center">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Img</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>
                                        @if ($product->img != "")
                                        <img width="75" src="{{ asset('uploads/products/'.$product->img) }}" alt="">
                                        @endif
                                    </td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->quantity}}</td>

                                    {{-- <td>{{ trim(strip_tags(html_entity_decode($product->description))) }}</td>    this is use to remove html tag from description --}}
                                    @php
                                        // Strip HTML tags and decode HTML entities
                                        $cleanedDescription = trim(strip_tags(html_entity_decode($product->description)));

                                        // Split the description into words
                                        $words = explode(' ', $cleanedDescription);

                                        // Get the first 50 words
                                        $shortDescription = implode(' ', array_slice($words, 0, 5));

                                        // Append ellipsis if the description is longer than 50 words
                                        if (count($words) > 50) {
                                            $shortDescription .= '...';
                                        }
                                    @endphp

                                    <td>{{ $shortDescription }}</td>

                                    <td>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="status" data-id="{{$product->id}}" class="form-check-input custom-control-input input-primary switch-language" id="customCheckinlh1{{$product->id}}" {{ ($product->status) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="customCheckinlh1"></label>
                                        </div>
                                    <td>
                                        <a class='btn btn-icon btn-rounded  btn-outline-dark me-2' href='{{route('edit',$product->id)}}'>
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        
                                        <a href="#" onclick="deleteProduct({{ $product->id }});" class="btn btn-icon btn-rounded btn-outline-danger delete-record" >
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                        <form id="delete-product-from-{{ $product->id }}" action="{{ route('user.delete', $product->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function deleteProduct(id){
            if (confirm("Are you sure you want to delete this product?")) {
                document.getElementById("delete-product-from-"+id).submit();
            }
        }
    </script>
@endpush