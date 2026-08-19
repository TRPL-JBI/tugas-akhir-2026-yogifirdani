@extends('template')

@section('content')
<style>
    /* Paksa navbar menjadi hitam di halaman ini */
    #ftco-navbar .nav-link, 
    #ftco-navbar .navbar-brand,
    #ftco-navbar .navbar-toggler {
        color: #000000 !important;
    }
    #ftco-navbar .nav-link {
        font-weight: 700 !important;
    }
    #ftco-navbar .cta .nav-link span {
        color: #000000 !important;
        border: 1px solid rgb(87, 201, 209) !important;
    }
    #ftco-navbar.scrolled .nav-link {
        color: #000000 !important;
    }
</style>
<div class="main-login-wrapper" style="background-color: #fafafaff; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 100px 20px 40px 20px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 ftco-animate">
                
                <div class="login-card" style="background: #ffffff; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
                    
                    <div class="text-center mb-5">
                        <h3 style="font-weight: 800; color: #222; font-size: 28px; margin-bottom: 10px;">{{ __('messages.register_title') }}</h3>
                        <p style="color: #888; font-size: 14px;">{{ __('messages.register_welcome') }}</p>
                    </div>

                    <form action="{{ lroute('register') }}" method="POST" class="login-form">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger" style="border-radius: 12px; font-size: 13px; border: none; background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <style>
                            .custom-input {
                                border: 2px solid #eee !important;
                                border-radius: 12px !important;
                                padding: 12px 15px 12px 45px !important;
                                height: auto !important;
                                font-size: 14px !important;
                                transition: all 0.3s ease !important;
                                background-color: #fcfcfc !important;
                            }
                            .custom-input:focus {
                                border-color: rgb(87, 201, 209) !important;
                                background-color: #fff !important;
                                box-shadow: 0 0 0 4px rgba(87, 201, 209, 0.1) !important;
                            }
                            .input-group-icon {
                                position: absolute;
                                left: 18px;
                                top: 50%;
                                transform: translateY(-50%);
                                color: rgb(87, 201, 209);
                                font-size: 16px;
                                z-index: 10;
                                transition: all 0.3s ease;
                                opacity: 0.7;
                            }
                            .form-group:focus-within .input-group-icon {
                                opacity: 1;
                                transform: translateY(-50%) scale(1.1);
                            }
                            .btn-login {
                                background-color: rgb(87, 201, 209);
                                border: none;
                                border-radius: 12px;
                                padding: 14px;
                                color: #fff;
                                font-weight: 700;
                                font-size: 15px;
                                letter-spacing: 1px;
                                transition: all 0.3s ease;
                                box-shadow: 0 5px 15px rgba(87, 201, 209, 0.3);
                            }
                            .btn-login:hover {
                                background-color: rgb(68, 189, 199);
                                transform: translateY(-2px);
                                box-shadow: 0 8px 20px rgba(87, 201, 209, 0.4);
                                color: #fff;
                            }
                        </style>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4" style="position: relative;">
                                    <i class="fa fa-user input-group-icon"></i>
                                    <input type="text" name="name" class="form-control custom-input" placeholder="{{ __('messages.register_name_ph') }}" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4" style="position: relative;">
                                    <i class="fa fa-envelope input-group-icon"></i>
                                    <input type="email" name="email" class="form-control custom-input" placeholder="{{ __('messages.register_email_ph') }}" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4" style="position: relative;">
                                    <i class="fa fa-lock input-group-icon"></i>
                                    <input type="password" name="password" class="form-control custom-input" placeholder="{{ __('messages.register_password_ph') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4" style="position: relative;">
                                    <i class="fa fa-lock input-group-icon"></i>
                                    <input type="password" name="password_confirmation" class="form-control custom-input" placeholder="{{ __('messages.register_confirm_password_ph') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-login w-100">{{ __('messages.register_btn') }}</button>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p style="color: #888; font-size: 14px;">{{ __('messages.register_already_have_account') }} <a href="{{ lroute('login') }}" style="color: rgb(87, 201, 209); font-weight: 700; text-decoration: none;">{{ __('messages.register_login_link') }}</a></p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection