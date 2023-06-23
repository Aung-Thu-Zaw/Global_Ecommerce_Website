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
                        Thank you for taking the time to report the bugs you encountered on our e-commerce website. We
                        greatly appreciate your
                        effort in helping us improve the user experience for all our customers. Your valuable feedback
                        plays a crucial role in
                        making our platform more reliable and efficient.

                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We want to assure you that we have received your bug report and our development team is actively
                        working to address the
                        issues you have identified. Our goal is to provide a seamless and enjoyable shopping experience,
                        and your input helps us
                        achieve that.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Rest assured that we take your feedback seriously, and we will thoroughly investigate and
                        prioritize each reported bug.
                        Our team will work diligently to fix the issues as quickly as possible.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We value your dedication to improving our platform, and we encourage you to continue providing
                        your suggestions and
                        ideas. Your insights are vital to our ongoing efforts to enhance the functionality and
                        performance of our website.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Once again, thank you for being an active member of our community and for helping us improve our
                        e-commerce website. If
                        you have any further questions or concerns, please feel free to reach out to us. We are always
                        here to assist you.
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
