@extends('frontend.layouts.master')

@section('heading')
Cart Page 
@endsection

@section('frontend_content')

   <div class="container">
        <h2>Your Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart_arr as $item)
                    <tr>
                        <td><img src="{{ $item['image'] }}" alt="" width="50"></td>
                        <td>{{ $item['product_name'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>{{ $item['product_qty'] }}</td>
                        <td>${{ number_format($item['total'], 2) }}</td>
                        <td>
                            <form action="{{ $item['remove'] }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
@endsection
