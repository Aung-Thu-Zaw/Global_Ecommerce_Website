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
                        Dear {{ $user->name }},
                    </p>

                    <p class="text-md font-normal text-slate-800 ">
                        We have received a request to delete your user account on our e-commerce platform. We are sorry
                        to see you go and would like to confirm that your account has been successfully deleted as per
                        your request.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We understand that circumstances may change, and it is entirely your prerogative to manage your
                        presence on our platform. If you ever decide to return, we will be more than happy to welcome
                        you back as a valued {{ $user->role }}.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Please note that by deleting your account, all associated data, order history, and saved
                        information have been permanently removed from our system. This action cannot be undone, and any
                        future transactions or inquiries will require the creation of a new account.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        We sincerely appreciate the time you spent as a user on our platform and hope that you had a
                        positive experience. If there are any specific reasons or feedback you would like to share
                        regarding your decision to delete your account, we would greatly appreciate hearing from you.
                        Your input helps us improve our services for our community of users and vendors.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Expert Tips and Insights: Stay informed with helpful tips, industry insights, and expert advice
                        related to our products and services.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        If you have any further questions or need assistance with any other matter, please feel free to
                        reach out to our support team at [supportglobalecommerce@gmail.com]. We are here to assist you.
                    </p>
                    <br>
                    <p class="text-md font-normal text-slate-800 ">
                        Thank you once again for your participation, and we wish you all the best in your future
                        endeavors.
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