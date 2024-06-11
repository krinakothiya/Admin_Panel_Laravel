@extends('layouts.backend_app')


@section('heading')
<h4 class="mt-4"> Edit Product </h4>
@endsection 

@push('css')
<style>
  
    #image-preview {
        max-height: 92px;
        width: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding: 1px;
    }

    input[type="file"] {
        display: block;
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

    .removeImg {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }
</style>
@endpush

{{-- start create form --}}
@section('backend_content')
    
<div class="row">
    <!-- [ form-element ] start -->
    <div class="col-sm-12">
        <form id="myForm"  action="{{ route('user.update', $product->id) }}"  method="post" enctype="multipart/form-data" >
            @csrf
            @method('PATCH')

                {{-- edit form --}}
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="mb-2">Name *</label>
                                <input value="{{ old('name', $product->name) }}" type="text" name="name" id="name" class="form-control" placeholder="Enter Product Name">
                                <span class="text-danger error name"></span>         <!-- This will display the error message for the 'name' field -->
                            </div>

                            <div class=" col-md-6 mb-4">
                                <label for="quantity" class="mb-2">Quantity *</label>
                                <input value="{{ old('quantity', $product->quantity) }}" type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter Product quantity">
                                <span class="text-danger error quantity"></span>         <!-- This will display the error message for the 'name' field -->
                            </div>

                    
                            <div class="col-md-12 mb-4">
                                <label for="description"  class="mb-2">Description *</label>
                                <textarea name="description" id="description" rows="10">{{ old('description', $product->description) }}</textarea>      
                                <script>
                                    CKEDITOR.replace('description');
                                </script>
                                <span class="text-danger error description"></span> 
                            </div>
                    
                            <div class="form-group col-md-6 mb-4">
                                <label for="img">Image:</label>
                                <input type="file" id="img" name="img" accept="image/*" class="form-control mb-3" onchange="previewImage(event, 'img-preview')" onclick="product_thumbnailClicked(event)">
                            
                                @if ($product->img != "")
                                    <img id="img-preview" width="100" src="{{ asset('uploads/products/' . $product->img) }}" alt="">
                                @endif
                            </div>

                            <div class="form-check form-switch ms-3">
                                <input class="form-check-input" type="checkbox" name="status" id="customCheckinlh1" {{ ($product->status) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="customCheckinlh1">Is Active? </label>
                            </div>
                        

                        </div>
                    </div>
                </div>

                
                {{-- second form for variation details --}}
                <div class="card mb-5">
                    <div class="card-header">
                        <h4 class="card-title">Variations</h4>
                    </div>
                    <div class="card-body addfild">
                        @if(isset($variation) && $variation !== null && !$variation->isEmpty())
                            @foreach($variation as $var)
                                <div class="variation-details">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="umo">Unit of Measure *</label>
                                            <select id="umo" name="umo[]" class="form-control umo">
                                                <option value="">Select</option>
                                                <option value="KG" <?php echo ($var->umo == "KG") ? 'selected' : '-' ?>>KG</option>
                                                <option value="Gram" <?php echo ($var->umo == "Gram") ? 'selected' : '-' ?>>Gram</option>
                                                
                                            </select>
                                            <span class="text-danger error-umo"></span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="value">Value *</label>
                                            <input value="{{ old('value', $var->value) }}" type="text" name="value[]" class="form-control value">
                                            <span class="text-danger error-value"></span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="price">Price *</label>
                                            <input value="{{ old('price', $var->price) }}" type="text" name="price[]" class="form-control price">
                                            <span class="text-danger error-price"></span>
                                        </div>
                                        <div class="form-group col-md-1 align-self-end">
                                            @if(!$loop->first)
                                                <button type="button" class="btn btn-danger remove-variation"><i class="fa fa-minus"></i></button>
                                            @else
                                                <button type="button" class="btn btn-primary add-variation"><i class="fa fa-plus"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="variation-details">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="umo">Unit of Measure *</label>
                                        <select id="umo" name="umo[]" class="form-control umo">
                                            <option value="">Select</option>
                                            <option value="KG">KG</option>
                                            <option value="Gram">Gram</option>
                                        </select>
                                        <span class="text-danger error-umo"></span>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="value">value *</label>
                                        <input type="text" name="value[]" class="form-control value">
                                        <span class="text-danger error-value"></span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="price">Price *</label>
                                        <input type="text" name="price[]" class="form-control price">
                                        <span class="text-danger error-price"></span>
                                    </div>
                                    <div class="form-group col-md-1 align-self-end">
                                        <button type="button" class="btn btn-primary add-variation"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                

                {{-- edit maltipal Media --}}
                <div class="card mb-5">
                    <div class="card-header">
                        <h4 class="card-title">product Media</h4>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label class="form-label">Images*</label>

                            <div class="">
                                <input type="file" id="files" name="files[]" multiple accept=".jpg, .jpeg, .png"/>
                                @foreach($images as $media)

                                <span class="pip">
                                    <img class="imageThumb" src="{{ asset('uploads/products/' .$media->product_media_name) }}" title="">
                                    <br/><button class="remove" onclick="deleteimage({{$media->img_id }})">Remove image</button>
                                </span>
                                @endforeach
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
<!-- Include SweetAlert via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- Include Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>


<!-- CDN JavaScript files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- CDN CSS file -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.2/classic/ckeditor.js"></script>


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

{{-- this is use for  variation and append variation details --}}
<script>
    $(document).ready(function() {
        
        // Add variation
        $(".add-variation").click(function() {
            validateFields();                    // Validate fields before adding new variation field
            if ($('.is-invalid').length === 0) {                // Proceed if no validation errors
                appendVariationField();
            }
        });

        // Form submission
        $('#myForm').submit(function(e) {
            if (!validateFields()) {
                e.preventDefault();                      // Prevent form submission if there are validation errors
            }
        });

        // validation msg 
        function validateFields() {
            var isValid = true;

            $(".variation-details").each(function() {
                var umo = $(this).find('.umo').val().trim();
                var value = $(this).find('.value').val().trim();
                var price = $(this).find('.price').val().trim();

                $(this).find('.umo, .value, .price').removeClass('is-invalid').siblings('.error').text('');

                // Validate umo field
                if (umo === '') {
                    $(this).find('.umo').addClass('is-invalid').siblings('.error').text('The umo field is required.');
                    isValid = false;
                } 

                // Validate value field
                if (value === '') {
                    $(this).find('.value').addClass('is-invalid').siblings('.error').text('The value field is required.');
                    isValid = false;
                } 

                // Validate price field
                if (price === '') {
                    $(this).find('.price').addClass('is-invalid').siblings('.error').text('The price field is required.');
                    isValid = false;
                } 
            });

            return isValid;
        }

        // Append variation field
        function appendVariationField() {
            var variationField = `
                <div class="variation-details">
                    <div class="row">
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
            $(".addfild").append(variationField);
        }

        // Remove variation details
        $(".addfild").on('click', '.remove-variation', function() {
            $(this).closest('.variation-details').remove();
        });
    });
</script>


{{-- use for edit multipal imges --}}
<script>
    $(document).ready(function() {
        // Function to handle file input changes
        if (window.File && window.FileList && window.FileReader) {
            $("#files").on("change", function(e) {
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    if (f.type.match('image/jpeg') || f.type.match('image/jpg') || f.type.match('image/png')) {
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><button class=\"remove\" data-filename=\"" + file.name + "\">Remove image</button>" +
                                "</span>").insertAfter("#files");
                        });
                        fileReader.readAsDataURL(f);
                    } else {
                        $(this).val('');
                        alert("File type not supported. Please select a JPG, JPEG, or PNG file.");
                        return false;
                    }
                }
                console.log(files);
            });

            // Remove image functionality
            $(document).on("click", ".remove", function() {
                var filename = $(this).data("filename");
                $(this).parent(".pip").remove();
                function deleteimage(id) {
                    // AJAX call to delete image from the server
                    $.ajax({
                                    // url: "{{ route('delete_image', ['id' => '__id__']) }}".replace('__id__', id),

                        url: "product/delete_image/"+id, // Replace with your server endpoint
                        type: "POST",
                        data: {
                            filename: filename
                        },
                        success: function(response) {
                            // Handle success response
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        } else {
            alert("Your browser doesn't support the File API.");
        }
    });
</script>

@endpush