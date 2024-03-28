@extends('template.master')

@section('contents')
    <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-12 mx-auto">
            <div class="login-register-cover">
                <div class="text-center">
                    <h2 class="mb-2 text-brand-1">ចូលប្រព័ន្ធកក់បន្ទប់ប្រជុំ</h2>
                    <p class="font-sm text-muted mb-30">login to IAUOFFSA booking meeting room</p>
                </div>
                <form class="login-register text-start mt-20" action="/users/login" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="input-3">Username *</label>
                                <input class="form-control" id="input-3" type="text" required="" name="username"
                                    placeholder="iauoffsa.gov.kh">
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="input-4">Password *</label>
                                <input class="form-control" id="input-4" type="password" required="" name="password"
                                    placeholder="************">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default hover-up w-100" type="submit" name="login">Login</button>
                    </div>
                    <div class="text-muted text-center">Don't have an account?
                        <a href="/admins">Go to Admin Sing In</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
