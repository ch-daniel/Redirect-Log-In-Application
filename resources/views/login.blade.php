<!doctype html>

<title>Authorisation page</title>
<link rel="stylesheet" href="/app.css">
<script src="/app.js"></script>

<body>
    <div class="register-btn">
        <a href="/register">Register</a>
    </div>
    <div class="auth-box">
        <div class="title">
            Enter your credentials:
        </div>
        <form method="POST" action="/login">
            @csrf
            <div class="auth-row">
                <input type="text" name="email" id="" value="{{ old('email') }}" required placeholder="Email.." autocomplete="off">
                @error('email')
                    <div class="auth-error"><p>{{ $message }}</p></div>
                @enderror
            </div>
            <div class="auth-row">
                <input class="pwd" type="password" name="password" id="" required placeholder="Password.." autocomplete="off">
                <img src="/eye-closed.png" alt="" width=20px height=20px onclick="eyeClick(this)">
            </div>
            <div class="auth-submit">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
    @if (session()->has('success'))
        <div class="success-alert-box">
            <p class="success-alert" id="success-alert">{{ session('success') }}</p>
        </div>
    @endif

</body>