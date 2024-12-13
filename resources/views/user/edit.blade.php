@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid">
            <div class="page-header min-height-100 border-radius-xl mt-4"
                style="background-image: url('/assets/img/curved-images/curved00.jpg'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6">
                <div class="row gx-4">
                    <div class="col-auto">
                    </div>
                    <div class="col-lg-6 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <h6 class="mb-0">{{ __('User Information') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">

                </div>
                <div class="card-body pt-4 p-3">
                    <form method="post" action="{{ route('user.update',$user->id) }} " enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        @if ($errors->any())
                            <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                                <span class="alert-text text-white">
                                    {{ $errors->first() }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success"
                                role="alert">
                                <span class="alert-text text-white">
                                    {{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-control-label">{{ __('Username') }}</label>

                                <div class="@error('name')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="{{ old('name', $user->name) }}" type="text"
                                        required id="name" name="name">
                                    @error('username')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-control-label">{{ __('Default password') }}</label>

                                <div class="@error('password')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="password" value="{{$user->password}}" required id="password" name="password">
                                    @error('password')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_id" class="form-control-label">{{ __('Department') }}</label>
                                    <select name="department_id" class="form-select" id="department_id" required>
                                        @foreach ($departments as $department)
                                            <option value={{ $department->id }}>
                                                {{ $department->code }}&nbsp;{{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">{{ __('Email') }}</label>
                                    <div class="@error('email')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ old('email', $user->email) }}" type="email"
                                            required placeholder="xx@yyyy.zzz" id="email" name="email">
                                        @error('email')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="role" class="form-control-label">{{ __('Role') }}</label>
                                <select name="role" class="form-select" id="role" required>
                                    <option value="pgam">
                                        PGAM
                                    </option>
                                    <option value="director">
                                        Director
                                    </option>
                                    <option value="coordinator">
                                        Coordinator
                                    </option>
                                    <option value="user">
                                        Lecturer
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="staff_id" class="form-control-label">{{ __('Staff') }}</label>
                                <select name="staff_id" class="form-select" id="staff_id" required>
                                    @foreach ($staffs as $staff)
                                        <option value={{ $staff->id }}>
                                            {{ $staff->title }}&nbsp;{{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="notes" class="form-control-label">{{ __('Notes') }}</label>
                                <div class="@error('notes')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ $user->about_me }}</textarea>
                                    @error('notes')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
