<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Files section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>

<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Files section</h1>
        <div class="container-sm">
            <div class="mb-3">
                <form action="/files/upload-api" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="product" name="category" id="category">
{{--                <form action="/files/upload" method="post" enctype="multipart/form-data">--}}
                    <label for="file" class="form-label">Please upload your file</label>
                    <input class="form-control" type="file" id="file" name="file">
                    <button class="btn btn-primary btn-block mt-4">
                        Let's go!
                    </button>
                </form>
            </div>
        </div>

        @if(!isset($home) and empty($results))
            <div class="alert alert-success" role="alert">
                File uploaded successfully!
            </div>
        @endif

        @if(!empty($results))
            <div class="alert alert-danger" role="alert">
                @foreach ($results as $key => $error)
                    <div class="row">
                        <div class="col-4 text-start">
                            <div style=" color: #000">Error on row: <b>{{ $error['record'] }}</b></div>
                        </div>
                        <div class="col-8">
                            <div class="accordion accordion-flush" id="accordionFlushExample"
                                 style="margin-bottom: 10px; border-bottom: 1px #fff" ;>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading{{$key}}">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapse{{$key}}" aria-expanded="false"
                                                aria-controls="flush-collapse{{$key}}">
                                            See details
                                        </button>
                                    </h2>
                                    @foreach ($error['errors'] as $internalError)
                                        <div id="flush-collapse{{$key}}" class="accordion-collapse collapse"
                                             aria-labelledby="flush-heading{{$key}}"
                                             data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <small>- {{ $internalError }}</small>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>
</html>
