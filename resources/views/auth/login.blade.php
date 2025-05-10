<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ArenApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #232325;
            color: white;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
        .login-container {
            display: flex;
            min-height: 100vh;
        }
        .login-form-section {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-image-section {
            flex: 1;
            background-image: url('/images/login_img_bg.png');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .login-image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/images/pattern.svg');
            opacity: 0.1;
            z-index: 1;
        }
        .login-image-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }
        .form-input {
            background-color: #1E1E1E;
            border: 1px solid #333;
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            width: 100%;
            margin-bottom: 1rem;
        }
        .form-input:focus {
            border-color: #EAAD59;
            outline: none;
            box-shadow: 0 0 0 2px rgba(234, 173, 89, 0.2);
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #CCC;
        }
        .password-requirements {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .password-requirement {
            font-size: 0.75rem;
            color: #AAA;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .btn-primary {
            background-color: #EAAD59;
            text-align: center;
            color: white;
            border: none;
            padding: 1rem 1rem;
            border-radius: 0.375rem;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary:hover {
            background-color: #D99B47;
        }
        .btn-google {
            background-color: #333;
            color: white;
            border: 1px solid #444;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .btn-google:hover {
            background-color: #444;
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #666;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #333;
        }
        .divider::before {
            margin-right: 1rem;
        }
        .divider::after {
            margin-left: 1rem;
        }
        .rating-stars {
            color: #EAAD59;
            letter-spacing: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <a href="{{ route('home') }}" class="absolute top-4 left-4 z-10">
            <img src="/images/back_to_home_icon.png" alt="Arena Logo" class="w-18 h-auto">
        </a>
        <div class="login-form-section">
            <div class="form-container">
                <h1 class="text-2xl font-bold mb-6">ArenApp</h1>
                <h2 class="text-xl font-bold mb-2">Create your account</h2>
                <p class="text-gray-400 mb-6">We take your security very seriously</p>
                            
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" class="form-input @error('email') border-red-500 @enderror" 
                            id="email" name="email" value="{{ old('email') }}" 
                            placeholder="john.doe@domain.com" required autofocus>
                        @error('email')
                            <span class="text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Consider using a professional email address</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                        <input type="password" class="form-input @error('password') border-red-500 @enderror" 
                            id="password" name="password" required>
                        @error('password')
                            <span class="text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="password-requirements">
                        <div class="password-requirement">
                            <span>•</span> One uppercase character
                        </div>
                        <div class="password-requirement">
                            <span>•</span> One lowercase character
                        </div>
                        <div class="password-requirement">
                            <span>•</span> One number
                        </div>
                        <div class="password-requirement">
                            <span>•</span> 8 characters minimum
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox" name="remember" id="remember">
                            <span class="ml-2 text-sm text-gray-400">Remember me</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="h-8 btn-primary text-sm">Sign in</button>
                    
                    <p class="text-xs text-gray-500 mt-4">
                        By signing up, you agree to our <a href="#" class="text-blue-400">Terms Of Service</a> and 
                        <a href="#" class="text-blue-400">Privacy Policy</a>, including the way we collect and process your personal data.
                    </p>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-400">Already have an account? <a href="{{ route('login') }}" class="text-blue-400">Sign in</a></p>
                </div>
            </div>
        </div>
        
        <div class="login-image-section">
            <div class="login-image-content">
                <h2 class="text-3xl font-bold mb-4">Time is better spent<br>on design ideas</h2>
                <div class="rating-stars">★★★★★</div>
                <p class="text-sm mt-2">4.8/5 on Capterra</p>
            </div>
        </div>
    </div>
</body>
</html>