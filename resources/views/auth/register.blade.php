<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgb(14, 134, 84) 35%, rgb(255, 255, 255) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Nunito', sans-serif;
            overflow: hidden;
            position: relative;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
        }

        .card-body {
            padding: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #ced4da;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        }

        .btn-primary {
            background-color: #012970;
            border-color: #012970;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }

        .error {
            color: red;
            font-size: 0.875em;
            margin-top: 0.5rem;
        }

        h2 {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #333;
        }

        .light {
            position: absolute;
            width: 2px;
            height: 100px;
            background: #fff;
            animation: fall 5s linear infinite;
            border-radius: 2px;
        }

        @keyframes fall {
            0% {
                transform: translateY(-100vh) rotate(180deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(180deg);
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <h2>Register</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>
               
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>

    {{-- <!-- Animasi lampu jatuh -->
    <div class="light" style="left: 10%; animation-delay: 1s;"></div>
    <div class="light" style="left: 30%; animation-delay: 2s;"></div>
    <div class="light" style="left: 50%; animation-delay: 3s;"></div>
    <div class="light" style="left: 70%; animation-delay: 4s;"></div>
    <div class="light" style="left: 90%; animation-delay: 5s;"></div> --}}
</body>

</html>
