<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>video</title>
</head>

<body>
    <style>
        div {

            display: flex;
            align-items: center;
            justify-content: center;
        }

        video {
            max-width: 100%;
            max-height: 80vh;
        }
    </style>
    <div>
        <video controls>
            <source src="{{ asset('assets/videos/products/' . $product->video) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</body>

</html>
