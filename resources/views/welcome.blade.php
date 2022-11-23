<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cart Geek</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name=”description” content="Pets for life is platform where you can buy dog/puppies online. Here you get all dog breeds in budget">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" />
</head>
<style>
    .nav-link {
        color: black !important;
    }

    .error {
        color: red;
    }

    .img-size {
        width: 50px;
        height: 50px;
    }
</style>

<body>
    <section class="mt-5">
        <div class="container mb-2">
            <div class="row">
                <div class="col-12">
                    <h1 class="header-title" style="color: cornflowerblue">Available Product</h1>
                    <hr style="border: 1px solid cornflowerblue">
                </div>
            </div>
        </div>
        <div class="container ">
            <div class="row mb-5">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">Create Product</div>
                        <div class="card-body">
                            <form id="productForm" action="{{ route('product.create') }}" method="POST" enctype="multipart/form-data">
                                <div class="row form-group mt-2">
                                    <label>Product Name</label>
                                    <input type="text" name="name" class="form-control" id="name">
                                    <input type="hidden" name="id" class="form-control" id="id">
                                </div>
                                <div class="form-group row mt-2">
                                    <label>Product Description</label>
                                    <textarea class="form-control" name="description" id="description">

                                    </textarea>
                                </div>
                                <div class="form-group row mt-2">
                                    <label>Images</label>
                                    <input class="form-control" type="file" name="file[]" multiple accept="image/*">
                                </div>
                                @csrf()
                                <div class="row form-group mt-2">
                                    <label>Price</label>
                                    <input type="number" class="form-control" name="price" id="price">
                                </div>
                                <button type="submit" class="btn btn-success mt-2">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8" id="tableData">

                </div>
            </div>
        </div>
    </section>

    <!-- ./Footer -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" defer></script>

    <script>
        $(document).ready(function() {

            $('#productForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    description: {
                        required: true,
                        minlength: 2
                    },
                    "file[]": {
                        required: true,
                        accept: 'jpg,png,jpeg'
                    },
                    price: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter product name."
                    },
                    description: {
                        required: "Please enter description",
                        minlength: 2
                    },
                    "file[]": {
                        required: "Please upoad file.",
                        accept: 'Please only select jpg or png image.'
                    },
                    price: {
                        required: "Please enter price",
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: '{{ route("product.create") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data.flag == 1) {
                                alert(data.msg);
                                document.getElementById("productForm").reset();
                                load_data();
                            } else {
                                alert(data.msg);
                            }
                        },
                        error: function(error) {
                            alert(error.responseJSON.message);
                        }
                    });
                }
            });

            load_data();
        });

        function load_data() {
            $.ajax({
                url: '{{ route("product.show") }}',
                type: 'GET',
                success: function(data) {
                    $('#tableData').html(data)
                    $('.table').DataTable();

                },
                error: function(error) {
                    alert(error.responseJSON.message);
                }
            });
        }

        function _delete(id) {
            $.ajax({
                url: '{{ route("product.delete") }}',
                type: 'GET',
                data: {
                    'id': id
                },
                success: function(data) {
                    if (data.flag == 1) {
                        alert(data.msg);
                        load_data();
                    } else {
                        alert(data.msg);
                    }
                },
                error: function(error) {
                    alert(error.responseJSON.message);
                }
            });
        }

        function edit(id) {
            $.ajax({
                url: '{{ route("product.edit") }}',
                type: 'GET',
                data: {
                    'id': id
                },
                success: function(data) {
                    $('#name').val(data.product_name);
                    $('#price').val(data.product_price);
                    $('#description').val(data.product_description);
                    $('#id').val(data.id);
                },
                error: function(error) {
                    alert(error.responseJSON.message);
                }
            });
        }
    </script>
</body>

</html>