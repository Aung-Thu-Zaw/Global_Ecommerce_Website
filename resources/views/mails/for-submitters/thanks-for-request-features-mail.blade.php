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
                        Hi there,
                    </p>

                    <p class="text-md font-normal text-slate-800 ">
                        Thank you for reaching out to us and suggesting a new feature for our e-commerce website. We
                        appreciate your input and value your ideas on how we can enhance our platform to better meet the
                        needs of our users.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We understand that each customer has unique preferences and requirements, and your feature
                        request highlights an
                        opportunity for us to improve the overall user experience. Our team carefully reviews all
                        suggestions and evaluates
                        their feasibility and potential impact on our platform.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We want you to know that your feature request has been noted, and we will discuss it with our
                        development team during
                        our next planning cycle. While we cannot guarantee immediate implementation of every request,
                        please rest assured that
                        we consider each suggestion seriously, and it helps us shape the future direction of our
                        website.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We genuinely appreciate your engagement and dedication to making our e-commerce platform even
                        better. Your feedback
                        plays an essential role in our continuous improvement efforts, and we encourage you to continue
                        sharing your thoughts
                        and ideas with us.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Should there be any updates or progress regarding your feature request, we will make sure to
                        keep you informed.
                        Meanwhile, if you have any further suggestions or questions, please do not hesitate to reach
                        out. We are always eager to
                        listen and engage with our valued users.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">

                        Thank you once again for your valuable contribution to our e-commerce community. Together, we
                        can create an exceptional
                        online shopping experience for all our customers.
                    </p>
                    <br>


                    <p class="text-sm font-bold text-slate-600">
                        Best regards,

                    </p>
                    <p class="text-sm font-bold text-blue-600">
                        Global E-commerce
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