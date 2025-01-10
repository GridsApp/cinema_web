@extends('website.layouts.main')

@section('content')
    <div class="page-content main-spacing main-container">


        <div class="mt-30">
            @include('website.components.title', ['title' => 'Register'])

            <form class="auth-form" method="post" action="">
                @csrf
                <div class="input-group">
                    <input type="text" class="phone-numb" placeholder="phone number">
                </div>
                <input type="hidden" name="phone_country_code" value="">
                <input type="hidden" name="phone_without_code" value="">
                <div class="input-group">
                    <input type="password" min="6" name="password" placeholder="password"> <a
                        href="javascript:;" class="passHide"><i class="fa-solid fa-eye"></i><i
                            class="fa-solid fa-eye-slash"></i></a>
                </div>
                <div class="input-group">
                    <input type="password" min="6" name="confirm_password"
                        placeholder="{{ __('texts.confirm-password') }}"> <a href="javascript:;" class="passHide"><i
                            class="fa-solid fa-eye"></i><i class="fa-solid fa-eye-slash"></i></a>
                </div>
                <div class="il">
                    We collect your phone number and email to:
                    <ul>
                        <li> Maintain your Cinema Wallet Account </li>
                        <li>
                            Maintain your Rewards Section
                        </li>
                        <li>
                            Provide WhatsApp Chat Support (If required)
                        </li>
                    </ul>


                </div>
                <div class="radio ">
                    <input id="radio-1" required name="agree" value="1" type="radio">
                    <label for="radio-1" class="radio-label">I understant thank you</label>
                </div>
                <button type="submit" class="custom-button mt-30">
                 Register
                </button>

                <p class="centering mt-50 mb-50">
              already have account  <a
                        href="/auth/sign-in">sign in</a>
                </p>
            </form>

        </div>
    </div>
@endsection
