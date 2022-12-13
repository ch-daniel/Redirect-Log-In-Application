<!doctype html>

<title>Registration page</title>
<link rel="stylesheet" href="/app.css">
<script src="/app.js"></script>

<body>
    <h1>REDIRECTING..</h1>
@auth
    @if (auth()->user()->is_admin == True)
        <script type="text/javascript">
            // console.log("I am gere");
            window.location = '/dashboard';
        </script>
    @endif
    @if (auth()->user()->is_admin != True)
        <script type="text/javascript">
            // console.log("I am gere too");
            setTimeout(() => {
                window.location = '/exit';
            }, "1000");
        </script>
    @endif
@endauth

@guest
    <script type="text/javascript">
        window.location = "/login";
    </script>
@endguest

</body>