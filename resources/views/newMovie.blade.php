<!DOCTYPE html>
<html>
<head>
    <title>VideoStore | Add New Movie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
</head>
<body>

<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            @include('nav-bar')
        </div>
        <div class="card-body">
            <form id="ajax-form" action="{{ route('movie.createMovie') }}">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Movie Name:</label>
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>
                <div class="alert alert-danger" role="alert">

                </div>
                <div class="mb-3 text-center">
                    <button class="btn btn-success btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


</body>
</html>
<script type="text/javascript">
    $('#ajax-form').submit(function(e) {
        e.preventDefault();

        var url = $(this).attr("action");
        let formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,

            success: (response) => {
                alert(response.error.title);

            },

        });
    });
</script>