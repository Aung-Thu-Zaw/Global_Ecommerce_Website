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
                        We would like to express our sincere gratitude for taking the time to provide feedback and
                        rating our website. Your input is highly valuable to us as we strive to deliver an exceptional
                        user experience to all our visitors.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We greatly appreciate your feedback rating and the insights you shared. Your feedback helps us
                        identify areas where we can further improve and optimize our website's performance, design, and
                        functionality. Your participation in this process is crucial in shaping the future of our
                        platform.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We want you to know that we take your feedback seriously, and we will carefully analyze the
                        areas you highlighted. Our team will explore ways to address any concerns and implement
                        enhancements that will positively impact your browsing and shopping experience.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Your involvement and dedication as a valued user inspire us to continuously refine and elevate
                        our website. We are committed to providing a seamless, enjoyable, and intuitive platform, and
                        your feedback helps us achieve that goal.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        If you have any additional comments, suggestions, or concerns, please don't hesitate to reach
                        out to us. We are always here to listen and make improvements based on our users' needs.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Once again, thank you for your valuable feedback rating. We appreciate your support and look
                        forward to serving you even better in the future.
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