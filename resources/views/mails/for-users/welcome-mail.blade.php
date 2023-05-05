<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/18c274e5f3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js','resources/css/app.css'])



</head>

<body class="font-sans antialiased">

    <div class="bg-gray-50 min-h-screen flex items-center justify-center px-3">
        <div class="lg:w-[900px] border bg-white shadow">
            <div class="py-5">
                <h3 class="font-bold w-full text-center my-10 text-slate-800 text-2xl">GLOBAL E-COMMERCE</h3>

                <div class="px-10">
                    <p class="text-md font-semibold text-slate-600 mb-5">
                        Hey Aung Thu Zaw!
                    </p>

                    <p class="text-md font-normal text-slate-800 ">
                        Welcome to our online store!
                        Thank you for creating a global e-commerce account.
                    </p>
                    <p class="text-md font-normal text-slate-800 ">
                        Please make yourself at home and enjoy shopping with us.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        But before you start, here's a short tutorial we created for our new clients. It will help you
                        easy to use our online shopping website. <a href="#"
                            class="font-bold text-blue-600 underline">Tutorial Link</a>
                    </p>


                    <img src="https://img.freepik.com/free-vector/online-shopping-concept-illustration_114360-1084.jpg"
                        alt="" class=" h-[300px] object-cover mx-auto">


                    <div class="p-5 bg-blue-100 rounded-sm flex flex-col items-center justify-center">
                        <p class="text-sm font-semibold text-slate-800">
                            Enjoy your welcome gift now.Use this code <span
                                class="text-blue-600 font-bold uppercase">"New
                                Client"</span> in
                            your shopping cart and
                            received a $50 discount
                            when
                            you spend minimun $250.
                        </p>

                        <button
                            class="font-bold text-sm px-10 uppercase py-3 shadow bg-blue-600 text-white rounded-sm mt-3 ">
                            Shop Now
                        </button>
                    </div>

                    <br>
                    <p class="text-sm font-bold text-slate-600">
                        See you around,

                    </p>
                    <p class="text-sm font-bold text-slate-600">
                        The Customer Support Team at
                        <a href="#" class="text-blue-600 underline">Global Ecommerce</a>
                    </p>
                </div>


                <div class="w-full bg-blue-700 text-white text-sm my-5 p-3">
                    <p class="font-bold text-center">STILL HAVE QUESTIONS?
                        <a href="#" class="underline hover:animate-bounce">
                            GO TO HELP CENTER
                        </a>
                    </p>
                </div>

                <div class="flex items-center justify-center mt-3">
                    <a href="#" class="text-slate-700 hover:text-blue-600 font-bold text-2xl mx-3">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" class="text-slate-700 hover:text-pink-600 font-bold text-2xl mx-3">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="text-slate-700 hover:text-sky-600 font-bold text-2xl mx-3">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="text-slate-700 hover:text-red-600 font-bold text-2xl mx-3">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>

            <p class="text-center text-sm font-bold text-slate-600 mb-5">
                This is an automatically generated e-mail.Please do not reply to this e-mail.
            </p>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

</body>

</html>