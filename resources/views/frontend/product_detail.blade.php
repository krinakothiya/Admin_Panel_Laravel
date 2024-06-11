@extends('frontend.layouts.master')

@section('heading')
Product Datails
@endsection

{{-- css --}}
@push('css')
<style>
    .table{
        width: 341px;
        height: auto;
    }
</style>
    
@endpush


@section('frontend_content')

    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach($images as $index => $val)
                            <li data-target="#product-carousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                    
                    <!-- Carousel inner -->
                    <div class="carousel-inner border">
                        @foreach($images as $index => $val)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                {{-- <img class="w-100 h-100" src="{{ asset('/uploads/products/' . ) }}" alt="Image"> --}}
                                <img class="w-100 h-100" src="{{ asset('/uploads/products/' . $val->product_media_name) }}" alt="Image">
                            </div>    
                        @endforeach
                    </div>
                    
                    <!-- Controls -->
                    <a class="carousel-control-prev" href="#product-carousel" role="button" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" role="button" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
                
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{$product->name}}</h3>
               
                
                <div class="d-flex mb-3 mt-4">
                    <div class="custom-control custom-radio custom-control-inline">
                        <table class="table table-striped table-bordered nowrap text-center">
                            <thead>
                                <tr>
                                    <th class="text-dark">Umo</th>
                                    <th class="text-dark">Value</th>
                                    <th class="text-dark">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($variation as $val)
                                <tr>
                                    <td>{{$val->umo}}</td>
                                    <td>{{$val->value}}</td>
                                    <td>{{$val->price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>

                </div>

                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus" >
                            <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                </div>
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <h3>Description</h3>

                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>{!! nl2br(e(trim(strip_tags(html_entity_decode($product->description))))) !!}</p>
                    </div>
                   
                   
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->
@endsection

@push('javascript')
    <!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endpush