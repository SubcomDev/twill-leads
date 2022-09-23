<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />

<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-10 offset-1 mt-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white"> Contact US Form</h3>
                </div>
                <div class="card-body">

                    @if (Session::has('error'))
                        <div class="alert alert-danger m-3">{{ Session::get('error') }}</div>
                        {{ Session::forget('error') }}
                    @endif


                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.us.store') }}" id="contactUSForm">
                        {{ csrf_field() }}
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>FirstName:</strong>
                                    <input type="text" name="first_name" class="form-control" placeholder="FirstName"
                                        value="{{ old('first_name') }}" required>
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>last_name:</strong>
                                    <input type="text" name="last_name" class="form-control" placeholder="last_name"
                                        value="{{ old('last_name') }}" required>
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <input type="text" name="email" class="form-control" placeholder="email"
                                        value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Phone_nr:</strong>
                                    <input type="text" name="phone_nr" class="form-control" placeholder="Phone_nr"
                                        value="{{ old('phone_nr') }}" required>
                                    @if ($errors->has('phone_nr'))
                                        <span class="text-danger">{{ $errors->first('phone_nr') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>company:</strong>
                                    <input type="text" name="company" class="form-control" placeholder="company"
                                        value="{{ old('company') }}" required>
                                    @if ($errors->has('company'))
                                        <span class="text-danger">{{ $errors->first('company') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Message:</strong>
                                    <textarea name="message" rows="3" class="form-control" required>{{ old('message') }}</textarea>
                                    @if ($errors->has('message'))
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-success btn-submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
