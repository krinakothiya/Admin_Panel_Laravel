@extends('frontend.layouts.master')



@section('frontend_content')

{{-- search bar --}}
<div class="col-lg-4 col-4 text-left ml-5">
    <form id="searchForm">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Search for products">
            <div class="input-group-append">
                <button id="searchButton" class="btn btn-primary" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Products Start -->
@if(count($product) > 0)
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2"> Products</span></h2>
    </div>
    <div class="row px-xl-5 pb-3" id="productList">

        @foreach($product as $key => $val)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1 product-item {{ $key > 2 ? ' mrtop40' : '' }}">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    {{-- images --}}
                    <a href="{{url('product-details')}}\{{$val['sku']}}" class="rcplstcolink">
                        @if($val->img != null)
                        <img class="img-fluid w-100" src="{{asset('/uploads/products/' . $val->img)}}" alt="product">
                        @else
                        <img src="{{ asset('/uploads/products/') }}" alt="article">
                        @endif
                    </a>
                </div>

                {{-- heading --}}
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h5 class="text-truncate mb-3">
                        <a href="{{url('product-details')}}\{{$val['sku']}}" class="rcpctsbttllink font-three">{{ $val->name }}</a>
                    </h5>

                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{url('product-details')}}\{{$val['sku']}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    <a href="#" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    @else
    <p>No Products Found</p>
    @endif
</div>

@endsection



@push('javascript')
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Function to filter products by title
    function filterProductsByTitle(query) {
        const productList = document.getElementById('productList');
        const productItems = productList.getElementsByClassName('product-item');

        // Loop through each product and show/hide based on the title match
        for (let i = 0; i < productItems.length; i++) {
            const productLink = productItems[i].querySelector('.rcpctsbttllink');
            const productName = productLink.textContent.toLowerCase();

            // Check if the product title contains the search query
            if (productName.includes(query.toLowerCase())) {
                productItems[i].style.display = 'block'; // Show the product
            } else {
                productItems[i].style.display = 'none'; // Hide the product

            }
        }
    }

    // Event listener for the search button click
    document.getElementById('searchButton').addEventListener('click', function() {
        const query = document.getElementById('searchInput').value.trim(); // Get search query
        filterProductsByTitle(query); // Filter products by title

    });

    // Event listener for the Enter key press in the search input
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const query = document.getElementById('searchInput').value.trim(); // Get search query
        filterProductsByTitle(query); // Filter products by title
    });
</script>

@endpush

@push('javascript')
<!-- Include jQuery library (required for AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.add-to-cart').on('click', function(e) {
            e.preventDefault();

            let productId = $(this).data('product-id');
            let productQty = 1; // You can change this value or get it dynamically if needed

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    product_qty: productQty
                },
                success: function(response) {
                    if (response.status) {
                        alert('Product added to cart successfully!');
                        // Optionally update cart count or other UI elements here
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ', status, error);
                }
            });
        });
    });
</script>

@endpush