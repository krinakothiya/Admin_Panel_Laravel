@extends('layouts.backend_app')

@section('heading')
<h4 class="mt-4"> Create Product </h4>
@endsection 

@push('css')
 
<style>
    #image-preview {
        max-height: 92px;
        width: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding: 5px;
    }

    .imageThumb {
        max-width: 121px;
        max-height: 118px;
        border: 2px solid;
        cursor: pointer;
    }

    input[type="file"] {
            display: block;               /* it is used to make an element render as a block-level element. */
    }


    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }

    .remove {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }

    .remove:hover {
        background: white;
        color: black;
    }

</style>

@endpush

{{-- start create form --}}
@section('backend_content')
    
<div class="row">
        <!-- [ form-element ] start -->
        <div class="col-sm-12">
            <form id="myForm" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data" >
                @csrf

                {{-- create form --}}
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="mb-2">Name *</label>
                                <input value="{{ old('name') }}" type="text" name="name" id="name" class="form-control" placeholder="Enter Product Name">
                                <span class="text-danger error name"></span>         <!-- This will display the error message for the 'name' field -->
                            </div>

                            <div class=" col-md-6 mb-4">
                                <label for="quantity" class="mb-2">Quantity *</label>
                                <input value="{{ old('quantity') }}" type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter Product quantity">
                                <span class="text-danger error quantity"></span>       
                            </div>

                       
                            <div class="col-md-12 mb-4">
                                <label for="description"  class="mb-2">Description *</label>
                                <textarea value="{{ old('description') }}"   name="description" id="description" rows="10"></textarea>      
                                <script>
                                    CKEDITOR.replace('description');
                                </script>
                                <span class="text-danger error description"></span> 
                            </div>
                    
                            <div class="form-group col-md-6 mb-4">
                                <label for="img" class="mb-2">Image *</label><br>

                                <input value="{{ old('img') }}" type="file" name="img" id="img" accept="image/*"  class="form-control mb-3" onchange="previewImage(event)">
                                <img id="img-preview" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;">
                                <span class="text-danger error img"></span>
                            </div>

                            <div class="form-check form-switch ms-3">
                                <input class="form-check-input" type="checkbox" name="status" id="customCheckinlh1" checked>
                                <label class="form-check-label" for="customCheckinlh1">Is Active? </label>
                            </div>
                        

                        </div>
                    </div>
                </div>

                {{-- create product variation --}}
                <div class="card mb-5">
                    <div class="card-header">
                        <h4 class="card-title">Variations</h4>
                    </div>
                    <div class="card-body">
                        <div class="variation-details">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="umo" class="mb-2">Unit of Measure *</label>
                                    <select id="umo" name="umo[]" class="form-control umo">
                                        <option value="">Select</option>
                                        <option value="KG">KG</option>
                                        <option value="Gram">Gram</option>
                                    </select>
                                    {{-- <input value="{{ old('umo') }}" type="text" name="umo[]" class="form-control umo" placeholder="Select a UOM"> --}}
                                    <span class="text-danger error umo"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="value" class="mb-2">Value *</label>
                                    <input value="{{ old('value') }}" type="text" name="value[]" class="form-control value" placeholder="Value">
                                    <span class="text-danger error value"></span>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="price" class="mb-2">Price *</label>
                                    <input value="{{ old('price') }}" type="text" name="price[]" class="form-control price" placeholder="Price">
                                    <span class="text-danger error price"></span>
                                </div>

                                <div class="form-group col-md-1 align-self-end">
                                    <button id="addvariation" type="button" class="btn btn-primary add-variation"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- add multipal imges --}}
                <div class="card  mb-5">
                    <div class="card-header">
                        <h4 class="card-title">product Media</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Images*</label>

                            <div class="">                
                                <input type="file" id="files" name="files[]" multiple />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- buttons  --}}
                <div class="card-footer mb-5">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection 

@push('javascript')

{{-- this use for img preview --}}
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var imgPreview = document.getElementById('img-preview');
            imgPreview.src = reader.result;
            imgPreview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

{{-- this validation for first form --}}
<script src="{{ asset('backend-assets/js/product_validation.js') }}"></script>


{{-- this is use for  variation  and append education details --}}
<script>
    $(document).ready(function() {
        // Add variation
        $("#addvariation").click(function() {
            if (validateFields()) {
                appendVariationField();
            }
        });

        // Form submission
        $('#myForm').submit(function(e) {
            if (!validateFields()) {
                e.preventDefault();  // Prevent form submission if there are validation errors
            }
        });

        // Validate fields
        function validateFields() {
            var isValid = true;

            $(".variation-details").each(function() {
                var umo = $(this).find('.umo').val().trim();
                var value = $(this).find('.value').val().trim();
                var price = $(this).find('.price').val().trim();

                $(this).find('.umo, .value, .price').removeClass('is-invalid').siblings('.error').text('');

                if (!validateUmo($(this).find('.umo'), umo)) {
                    isValid = false;
                }
                if (!validateValue($(this).find('.value'), value)) {
                    isValid = false;
                }
                if (!validatePrice($(this).find('.price'), price)) {
                    isValid = false;
                }
            });

            return isValid;
        }

        function validateUmo(umoField, umo) {
            if (umo === '') {
                umoField.addClass('is-invalid').siblings('.error').text('The umo field is required.');
                return false;
            } else if (!/^[a-zA-Z\s]+$/.test(umo)) {
                umoField.addClass('is-invalid').siblings('.error').text('The umo field must be a string.');
                return false;
            } else if (umo.length > 255) {
                umoField.addClass('is-invalid').siblings('.error').text('The umo field must not exceed 255 characters.');
                return false;
            }
            return true;
        }

        function validateValue(valueField, value) {
            if (value === '') {
                valueField.addClass('is-invalid').siblings('.error').text('The value field is required.');
                return false;
            }
            return true;
        }

        function validatePrice(priceField, price) {
            if (price === '') {
                priceField.addClass('is-invalid').siblings('.error').text('The price field is required.');
                return false;
            } 
            return true;
        }


        // Append variation field
        function appendVariationField() {
            var variationField = `
                <div class="variation-details">
                    <div class="row mt-4">
                        <div class="form-group col-md-4">
                            <label for="umo">Unit of Measure *</label>
                            <select id="umo" name="umo[]" class="form-control umo">
                                <option value="">Select</option>
                                <option value="KG">KG</option>
                                <option value="Gram">Gram</option>
                            </select>
                            <span class="text-danger error umo"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="value">Value *</label>
                            <input type="text" name="value[]" class="form-control value">
                            <span class="text-danger error value"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="price">Price *</label>
                            <input type="text" name="price[]" class="form-control price">
                            <span class="text-danger error price"></span>
                        </div>
                        <div class="form-group col-md-1 align-self-end">
                            <button type="button" class="btn btn-danger remove-variation"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
            `;
            $(".variation-details").last().after(variationField);
        }

        // Remove variation
        $(document).on('click', '.remove-variation', function() {
            $(this).closest('.variation-details').remove();
        });
    });
</script>


{{-- this is use for multipal img --}}
<script>

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result);
                $('#image-preview').hide();
                $('#image-preview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    if (window.File && window.FileList && window.FileReader) {
        $("#files").on("change", function(e) {
            var files = e.target.files,
                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                        "<br/><span class=\"remove\">Remove image</span>" +
                        "</span>").insertAfter("#files");
                    $(".remove").click(function() {
                        $(this).parent(".pip").remove();
                    });

                });
                fileReader.readAsDataURL(f);
            }
            console.log(files);
        });

    } else {
        alert("Your browser doesn't support to File API")
    }

</script>

@endpush