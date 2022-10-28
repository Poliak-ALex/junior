@extends('layouts.layout')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h2 class="card-header bg-secondary text-white">
                    Edit User
                    <a class="btn btn-primary" style="position: absolute; top: 20%; right: 1%;" href="{{ route('users.index') }}"> Back</a>
                </h2>
                <div class="card-body">    
                    <form action="{{ route('users.update',$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                         <div class="row">
                            {{-- Name field --}}
                            <div class="col-xs-6 col-sm-6 col-md-6"> 
                                <strong>Name:</strong>
                                <input type="text" name="name" maxlength="250" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       value="{{ old('name') == "" ? $user->name : old('name') }}" placeholder="Name" autofocus>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div> 
                            {{-- Email field --}}
                             <div class="col-xs-6 col-sm-6 col-md-6"> 
                                <strong>Email:</strong>
                                <input type="email" name="email" maxlength="250" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       value="{{ old('email') == "" ? $user->email : old('email') }}" placeholder="Email">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            {{-- Password field --}}
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <strong>Password:</strong>
                                <input type="password" name="password"
                                       class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       placeholder="··············">
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                        
                            {{-- Confirm password field --}}
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <strong>Confirm password:</strong>
                                <input type="password" name="password_confirmation"
                                       class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                       placeholder="··············">
                                @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-xs-2 col-sm-2 col-md-2 row" style="margin-top: 2%;">
                                <label for="is_admin" style="margin-left: 10%;"> Admin: </label>
                                <div class="col-md-6" >
                                    <span class="switch">
                                        <input type="checkbox" class="switch" id="is_admin" value="1" {{ $user->is_admin == 1 ? 'checked="checked"' : ""}} name="is_admin">
                                        <label for="is_admin"></label>
                                    </span>
                                </div>
                            </div>
                         
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection

