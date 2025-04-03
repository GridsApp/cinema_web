<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Survey</title>
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            background-color: #f4f4f9;

        }

        .mt-40px{
          margin-top: 30px;
        }

        .survey-container {
            max-width: 800px;
            margin:  20px auto 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .surveyFormContent {
            padding-bottom: 20px;
        }

        .surveyFormlabel {
            font-weight: 600;
            display: block;
            margin-bottom: 10px;
        }

        .surveyFormContent input[type="radio"] {
            margin-right: 10px;
            margin-left: 20px;
            margin-top: 0;
        }

        .surveyFormContent input[type="radio"]:first-of-type {
            margin-left: 0;
        }


        .surveyFormContent li {
            list-style: none;
            margin-bottom: 10px;
        }

        .surveyFormContent textarea {
            width: 100%;
            /* padding: 10px; */
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
        }

        button[type="submit"] {
            background-color: #c51a24;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }


        .surveyFormContent input[type="radio"]:checked {
            accent-color: #C51A23;



        }

        .surveyFormContent input[type="radio"] {
            text-transform: uppercase !important;
            font-size: 1em;
            -ms-transform: scale(1.2);

            transform: scale(1.2);
        }

        .section {
            padding-bottom: 20px;
        }

        label {
            cursor: pointer;
            display: flex;
            align-items: center;

        }

        .items-flex {
            display: flex;
            gap: 20px;
            padding-top: 10px;
        }

        .items-flex-font {
            font-weight: 600;
        }

        .component-flex {
            display: flex;
            gap: 20px;
            font-size: 14px;
        }

        li {
            padding-top: 5px;
            font-size: 14px;

            /* display: flex; */
        }

        span {
            /* max-width: 143px; */
            /* min-width: 150px !important; */
            display: inline-block;
            /* font-weight: 600; */
            padding-bottom: 12px;
            line-height: 26px;
        }

        @media (max-width: 768px) {
            .component-flex {
                display: flex;
                flex-direction: column;
            }
        }

        .flex-container {
            display: flex;
            gap: 10px;
            /* Default gap */
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .flex-container {
                gap: 5px;
                /* Reduced gap for smaller screens */
            }
        }


        @media (max-width: 480px) {
            .flex-container {
                gap: 3px;
                /* Further reduced gap for very small screens */
            }
        }

        @media (max-width: 768px) {
            ol {
                padding-left: 15px;
            }
        }
        .success-message{
            font-size: 13px;
            text-transform: uppercase;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 20px;
        }
    </style>
</head>

<body>
<div class="mt-40px" style="display: flex; justify-content: center">
    <img  src="/assets/logo2.svg" alt="" width="200">
</div>
@if (!session('success'))
<div class="survey-container">
    <form action="/survey" method="POST" class="surveyForm">
        @csrf
        <input type="hidden" name="order_id" value="{{ $purchase->id }}">
        <input type="hidden" name="user_id" value="{{ $purchase->user_id }}">

        <div class="section">
            <div class="surveyFormContent">

                <div class="surveyFormlabel">{{$title['ar']}} </div>
                <div class="surveyFormlabel">{{$title['en']}}</div>


            </div>
        </div>
        <div class="section">
            <div class="surveyFormContent">
                <div class="flex-container">

                    <div class="surveyFormlabel">كيف كان فيلمك ؟</div>
                    <div class="surveyFormlabel">How was your movie?</div>
                </div>

                @include('components.survey-rating', [
                    'name' => 'rating_movie',
                    'value1' => 'Low - منخفض',
                    'value2' => 'Average -  متوسط',
                    'value3' => 'Good - جيد',
                    'value4' => 'Very Good - جيد جدًا',
                ])


            </div>

        </div>
        <div class="section">
            <div class="surveyFormContent">
                <div class="flex-container">
                    <div class="surveyFormlabel">
                        كيف كانت الاغراض التي اشتريتها من الكافتيريا ؟

                    </div>
                    <div class="surveyFormlabel">How were your purchased items from the cafeteria?</div>

                </div>


                <ol>
                    <li style="list-style: number">
                        <span>Popcorn & Draft Drinks - البوشار والمشروبات الغازية</span>
                        @include('components.survey-rating', [
                            'name' => 'rating_popcorn_pepsi',
                            'value1' => 'Low - منخفض',
                            'value2' => 'Average -  متوسط',
                            'value3' => 'Good - جيد',
                            'value4' => 'Very Good - جيد جدًا',
                        ])

                    </li>

                    <li style="list-style: number">
                        <span>Other items - اغراض اخرى</span>
                        @include('components.survey-rating', [
                            'name' => 'rating_other_items',
                            'value1' => 'Low - منخفض',
                            'value2' => 'Average -  متوسط',
                            'value3' => 'Good - جيد',
                            'value4' => 'Very Good - جيد جدًا',
                        ])


                    </li>
                </ol>
            </div>
        </div>
        <div class="section">
            <div class="surveyFormContent">
                <div class="flex-container">
                    <div class="surveyFormlabel">
                        كيف كانت خدمتنا؟

                    </div>
                    <div class="surveyFormlabel">How was our service?</div>

                </div>


                <ol>
                    <li style="list-style: number"><span>Ticketing - حجز التذاكر</span>
                        @include('components.survey-rating', [
                            'name' => 'rating_ticketing_service',
                            'value1' => 'Low - منخفض',
                            'value2' => 'Average -  متوسط',
                            'value3' => 'Good - جيد',
                            'value4' => 'Very Good - جيد جدًا',
                        ])


                    </li>
                    <li style="list-style: number"><span>Cafeteria - الكافتيريا</span>

                        @include('components.survey-rating', [
                            'name' => 'rating_cafeteria_service',
                            'value1' => 'Low - منخفض',
                            'value2' => 'Average -  متوسط',
                            'value3' => 'Good - جيد',
                            'value4' => 'Very Good - جيد جدًا',
                        ])

                    </li>
                    <li style="list-style: number"><span>Users - الموظفين</span>
                        @include('components.survey-rating', [
                            'name' => 'rating_users_service',
                            'value1' => 'Low - منخفض',
                            'value2' => 'Average -  متوسط',
                            'value3' => 'Good - جيد',
                            'value4' => 'Very Good - جيد جدًا',
                        ])

                    </li>
                </ol>
            </div>
        </div>
        <div>
            <div class="surveyFormContent">

                <div class="flex-container">
                    <div class="surveyFormlabel">How was our team's friendliness?</div>
                    <div class="surveyFormlabel">
                        كيف كانت ودية فريقنا؟

                    </div>
                </div>


                <ol>
                    <li style="list-style: number"><span>Ticketing - حجز التذاكر</span>
                        @include('components.survey-rating', [
                            'name' => 'rating_ticketing_friendliness',
                            'value1' => 'Low - منخفض',
                            'value2' => 'Average -  متوسط',
                            'value3' => 'Good - جيد',
                            'value4' => 'Very Good - جيد جدًا',
                        ])

                    </li>
                    <li style="list-style: number"><span>Cafeteria - الكافتيريا</span>
                        @include('components.survey-rating', [
                            'name' => 'rating_cafeteria_friendliness',
                            'value1' => 'Low - منخفض',
                            'value2' => 'Average -  متوسط',
                            'value3' => 'Good - جيد',
                            'value4' => 'Very Good - جيد جدًا',
                        ])

                    </li>
                    <li style="list-style: number"><span>Users - الموظفين</span>
                        @include('components.survey-rating', [
                            'name' => 'rating_users_friendliness',
                            'value1' => 'Low - منخفض',
                            'value2' => 'Average -  متوسط',
                            'value3' => 'Good - جيد',
                            'value4' => 'Very Good - جيد جدًا',
                        ])

                    </li>
            </div>
        </div>
        <div class="surveyFormContent">

            <div class="flex-container">
                <div class="surveyFormlabel">
                    كيف كانت نظافة السينما؟


                </div>
                <div class="surveyFormlabel"> How was the cleanliness ? </div>

            </div>
            <ol>
                <li style="list-style: number"><span>Ticketing - حجز التذاكر</span>
                    @include('components.survey-rating', [
                        'name' => 'rating_ticketing_cleanliness',
                        'value1' => 'Low - منخفض',
                        'value2' => 'Average -  متوسط',
                        'value3' => 'Good - جيد',
                        'value4' => 'Very Good - جيد جدًا',
                    ])

                </li>
                <li style="list-style: number"><span>Cafeteria - الكافتيريا</span>
                    @include('components.survey-rating', [
                        'name' => 'rating_cafeteria_cleanliness',
                        'value1' => 'Low - منخفض',
                        'value2' => 'Average -  متوسط',
                        'value3' => 'Good - جيد',
                        'value4' => 'Very Good - جيد جدًا',
                    ])

                </li>
                <li style="list-style: number"><span>Users - الموظفين</span>
                    @include('components.survey-rating', [
                        'name' => 'rating_users_cleanliness',
                        'value1' => 'Low - منخفض',
                        'value2' => 'Average -  متوسط',
                        'value3' => 'Good - جيد',
                        'value4' => 'Very Good - جيد جدًا',
                    ])

                </li>
            </ol>
        </div>
        <div class="section">
            <div class="surveyFormContent">
                {{-- <label class="surveyFormlabel">How do you rate the app?</label> --}}
                <div class="flex-container">
                    <div class="surveyFormlabel"> كيف تقيم التطبيق؟</div>
                    <div class="surveyFormlabel">How do you rate the app?</div>
                </div>
                @include('components.survey-rating', [
                    'name' => 'rating_app',
                    'value1' => 'Low - منخفض',
                    'value2' => 'Average -  متوسط',
                    'value3' => 'Good - جيد',
                    'value4' => 'Very Good - جيد جدًا',
                ])

            </div>
        </div>
        <div class="section">
            <div class="surveyFormContent">

                <div class="surveyFormlabel">

                    رأيك يهمنا.يرجى ترك تعليقك حول تجربتك بصورة عامة :


                </div>
                <div class="surveyFormlabel">Your opinion matters to us. Please leave your comments about your
                    overall
                    experience:</div>



                <textarea name="message" cols="20" rows="10" maxlength="200"></textarea>
            </div>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>
@else
<div class="survey-container">
    <h2 class="success-message">
        ملاحظاتك مهمة بالنسبة لنا. شكرا لمساعدتنا في خدمتك بشكل أفضل!
    </h2>
    <h2 class="success-message">Your feedback is important to us. Thank you for helping us serve you better!</h2>


</div>
@endif

</body>

</html>
