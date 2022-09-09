@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'employees',
])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Add Employee') }}
                    <a href="{{ route('employees') }}" class="btn btn-sm btn-primary" style="margin-left: 10px;">{{ __('Back to list') }}</a>
                </div>

                <div class="card-body">
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-12">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <form method="post" action="{{ route('employee.store') }}" autocomplete="off">
                        @csrf
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-company-id">{{ __('Company') }}</label>
                                <select name="company_id"
                                    class="form-control form-control-alternative{{ $errors->has('company_id') ? ' is-invalid' : '' }}"
                                    id="input-company-id" aria-label="{{ __('Company Id') }}" required autofocus>
                                    <option selected value="">Select Company</option>
                                    @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{ $company->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('company_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}" style="margin-top: 10px;">
                                <label class="form-control-label" for="input-first-name">{{ __('First Name') }}</label>
                                <input type="text" name="first_name" id="input-first-name" class="form-control form-control-alternative{{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}" style="margin-top: 10px;">
                                <label class="form-control-label" for="input-last-name">{{ __('Last Name') }}</label>
                                <input type="text" name="last_name" id="input-last-name" class="form-control form-control-alternative{{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}" style="margin-top: 10px;">
                                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}" style="margin-top: 10px;">
                                <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}">

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
