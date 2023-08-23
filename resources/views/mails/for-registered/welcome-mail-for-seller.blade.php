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
                        Dear {{ $name }},
                    </p>

                    <p class="text-md font-normal text-slate-800 ">
                        Thank you for creating a seller account <span class="text-yellow-600 font-bold">"{{ $shopName
                            }}"</span> on
                        our e-commerce platform. We appreciate your interest
                        in joining our vibrant
                        community of sellers. This email serves as a confirmation of your registration and outlines the
                        next steps for
                        activating your account.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Our team of administrators will now review the information you provided during the registration
                        process to ensure its
                        accuracy and legitimacy. We strive to maintain a secure and trustworthy environment for both
                        vendors and customers on
                        our platform.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Please note that your vendor account is currently inactive, pending verification by our
                        administrative team. We kindly
                        request your patience during this process, which typically takes [timeframe, e.g., 24-48 hours].
                        We understand that you
                        are eager to start selling your products, and we aim to expedite this process as much as
                        possible.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Once our administrators have reviewed your information and verified its correctness, you will
                        receive another email
                        notification regarding the status of your account. If everything is in order, your account will
                        be activated, and you
                        will gain full access to our vendor services.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        In the meantime, please ensure that you have provided accurate and up-to-date information during
                        the registration
                        process. If any additional documentation or details are required, our team will reach out to you
                        for further
                        clarification.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We are committed to creating a thriving marketplace where vendors like you can showcase their
                        products and reach a wide
                        customer base. Our platform offers a range of tools and features to help you effectively manage
                        your product listings,
                        process orders, and track your sales performance.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Should you have any questions or require assistance during this process, please do not hesitate
                        to contact our support
                        team at [provide contact details]. We are here to help and ensure a seamless onboarding
                        experience for you.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Once again, thank you for choosing our e-commerce platform to expand your business. We are
                        excited to have you join our
                        community and look forward to working together to create a successful online presence.
                    </p>
                    <br>

                    <p class="text-sm font-bold text-slate-600">
                        Best regards,
                    </p>
                    <p class="text-sm font-bold text-blue-600">
                        Global E-commerce
                    </p>
                    <p class="text-sm font-bold text-blue-600">
                        globalecommerce@gmail.com
                    </p>
                </div>


                <div class="w-full bg-blue-700 text-white text-sm my-5 p-3">
                    <p class="font-bold text-center">STILL HAVE QUESTIONS?
                        <a href="https://example.com" target="_blank" class="underline hover:animate-bounce">
                            GO TO HELP CENTER
                        </a>
                    </p>
                </div>

                <div class="flex items-center justify-center mt-3">
                    <a href="https://example.com" target="_blank"
                        class="text-slate-700 hover:text-blue-600 font-bold text-2xl mx-3">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="https://example.com" target="_blank"
                        class="text-slate-700 hover:text-pink-600 font-bold text-2xl mx-3">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://example.com" target="_blank"
                        class="text-slate-700 hover:text-sky-600 font-bold text-2xl mx-3">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="https://example.com" target="_blank"
                        class="text-slate-700 hover:text-red-600 font-bold text-2xl mx-3">
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
