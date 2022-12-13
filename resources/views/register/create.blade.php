<!doctype html>

<title>Registration page</title>
<link rel="stylesheet" href="/app.css">
<script src="/app.js"></script>

<body>
    <div class="register-btn">
        <a href="/login">Login</a>
    </div>
    <div class="auth-box">
        <?php
        // dd(get_loaded_extensions());
        ?>
        <div class="title">
            Register a new account:
        </div>
        <form method="POST" action="/register">
            @csrf
            <div class="auth-row">
                <input type="text" name="username" id="" value="{{ old('username') }}" required placeholder="Username.." autocomplete="off">
                @error('username')
                    <div class="auth-error"><p>{{ $message }}</p></div>
                @enderror
            </div>
            <div class="auth-row">
                <input type="email" name="email" id="" value="{{ old('email') }}" required placeholder="Email.." autocomplete="off">
                @error('email')
                    <div class="auth-error"><p>{{ $message }}</p></div>
                @enderror
            </div>
            <div class="auth-row">
                <input class="pwd" type="password" name="password1" id="" required placeholder="Password.." autocomplete="off">
                <img src="/eye-closed.png" alt="" width=20px height=20px onclick="eyeClick(this)">
                @error('password1')
                    <div class="auth-error"><p>{{ $message }}</p></div>
                @enderror
            </div>
            <div class="auth-row">
                <input class="pwd" type="password" name="password2" id="" required placeholder="Repeat password.." autocomplete="off">
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
