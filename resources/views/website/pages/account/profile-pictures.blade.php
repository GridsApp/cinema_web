<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            font-family: "Inter", sans-serif;
        }
        .asp {
            position: relative;
            height: 0;
            overflow: hidden;
            width: 100%;
        }

        img {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .asp-2-2 {
            padding-bottom: calc(calc(100% * 2) / 2);
        }

        .main-container {
            padding-left: 2.25rem;
  
            padding-right: 2.25rem;
          
            max-width: 1600px;
            margin: auto;
        }
        label{

            color: #C51A24;
            text-decoration: underline;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-align: center;
            display: flex;
            justify-content: center;
            padding-top: 10px
        }
    </style>
</head>

<body style="overflow: hidden">
    <div class="main-container" style="max-width:100px">
        <form id="profile-image-form" enctype="multipart/form-data" method="POST"
            action="{{ route('addImage', [
                'cinema_prefix' => request()->route('cinema_prefix'),
                'language_prefix' => request()->route('language_prefix'),
            ]) }}">
            @csrf

            <div class="asp asp-2-2">
                <img src="{{$user->profile_picture ? get_image($user->profile_picture) : '/images/profile.png' }}"
                    alt="Profile Image" style="border-radius: 9999px; object-fit: cover;"
                    class="rounded-full object-cover">
            </div>
                {{-- </div>z --}}
                {{-- <div> --}}
                    <label for="profile_picture">add image</label>
                    <input type="file" style="display: none" name="profile_picture" id="profile_picture" required
                        onchange="this.form.submit()">
                {{-- </div> --}}
        </form>

    </div>

</body>

</html>
