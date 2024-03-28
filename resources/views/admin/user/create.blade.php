@extends('template.master')
@section('title', 'User')
@section('contents')
    <div class="card">
        <div class="card-header bg-success">
            <div class="d-flex justify-content-between align-content-between">
                <h5>ការចុះឈ្មោះមន្ត្រីសំរាប់ធ្វើការកក់បន្ទប់ប្រជុំ</h5>
            </div>
        </div>

        <div class="card-body">
            <form action="/users" method="POST">
                @csrf
                <div class="form-row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label class="form-label" for="exampleFormControlInput1">ជាអក្សរឡាតាំង</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                placeholder="ជាអក្សរឡាតាំង" aria-describedby="nameHelp">
                            @error('name')
                                <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label class="form-label" for="exampleFormControlInput1">អ៊ីម៉ែល</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                id="exampleFormControlInput1" placeholder="អ៊ីម៉ែល" aria-describedby="emailHelp">
                            @error('email')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-group">
                            <label class="form-label" for="exampleFormControlInput1">លេខសម្ងាត់</label>
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control"
                                id="exampleFormControlInput1" placeholder="លេខសម្ងាត់" aria-describedby="passwordHelp">
                            @error('password')
                                <small id="passwordHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <br>

                <div class=" d-flex justify-between align-items-center">
                    <input type="submit" class="btn btn-primary btn-sm" value="រក្សាទុក">
                    <a class="btn btn-dark btn-sm ml-2" href="/users">ថយក្រោយ</a>
                </div>
            </form>
        </div>
    </div>
@endsection
