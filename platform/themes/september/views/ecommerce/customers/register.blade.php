<main class="page--inner">
    <div class="container">
        <div class="page__header">
            {!! Theme::partial('breadcrumbs') !!}
        </div>
        <section class="section--auth">
            <form class="form--auth" method="POST" action="{{ route('customer.register.post') }}">
                @csrf
                <div class="form__header">
                    <h3>{{ __('Register') }}</h3>
                    <p>{{ __('Please fill in the information below') }}</p>
                </div>
                <div class="form__content">
                    <div class="form-group">
                        <label for="txt-name">{{ __('Name') }} <sup>*</sup></label>
                        <input class="form-control" name="name" id="txt-name" type="text" value="{{ old('name') }}" placeholder="{{ __('Please enter your name') }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="txt-email">{{ __('Email Address') }}<sup>*</sup></label>
                        <input class="form-control" name="email" id="txt-email" type="email" value="{{ old('email') }}" placeholder="{{ __('Please enter your email address') }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="txt-password">{{ __('Password') }} <sup>*</sup></label>
                        <input class="form-control" type="password" name="password" id="txt-password" placeholder="{{ __('Please enter your password') }}">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="txt-password-confirmation">{{ __('Password confirmation') }} <sup>*</sup></label>
                        <input class="form-control" type="password" name="password_confirmation" id="txt-password-confirmation" placeholder="{{ __('Please enter your password confirmation') }}">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    {!! Captcha::display([], ['lang' => app()->getLocale()]) !!}

                    <div class="form__actions">
                        <p>{{ __('Have an account already?') }} <a href="{{ route('customer.login') }}">{{ __('Login') }}</a></p>
                        <button type="submit" class="btn--custom btn--rounded btn--outline">{{ __('Register') }}</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>
