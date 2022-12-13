<!doctype html>

<title>Registration page</title>
<link rel="stylesheet" href="/app.css">
<script src="/app.js"></script>

<body>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Log out</button>
    </form>
    <div class="body-wrapper">
        <div class="admin-table">
            <div class="admin-table-row title">
                <div>Username</div>
                <div>Coins</div>
            </div>
            <form method="POST" action="/update">
                @csrf
            @foreach ($users as $user)
                <div class="admin-table-row">
                    <div id="username{{ $user->id }}">{{ $user->username }}</div>
                    <div id="coins{{ $user->id }}"><input onkeypress="return onlyNumberKey(event)" autocomplete="off" type='number' value="{{ $user->coins }}" name="coins[{{ $user->id }}]"></div>
                    @if (session()->has('coins'.$user->id))
                        <span class="auth-error"><p>{{ session('coins'.$user->id) }}</p></span>
                    @endif
                </div>
            @endforeach
                <div class="admin-table-row-end">
                    <button>Submit</button>
                </div>
            </form>
        </div>
    </div>
    @if (isset($success))
        <div class="success-alert-box">
            <p class="success-alert" id="success-alert">{{ $success }}</p>
        </div>
    @endif
</body>