@extends('templates.template_normal')
@section('main-content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <!-- Thẻ thông tin cơ bản -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-secondary"></i>
                    </div>
                    <h5 class="card-title">{{ $user->full_name }}</h5>
                    <p class="text-muted mb-1">{{ $user->student_code }}</p>
                    <p class="text-muted mb-4">Sinh viên</p>
                </div>
            </div>

            <!-- Thẻ thống kê -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="text-muted mb-2">Lớp đang học</h6>
                            <h5 class="mb-0">{{ $user->studentClasses()->where('status', 'Active')->count() }}</h5>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted mb-2">Lớp đã hoàn thành</h6>
                            <h5 class="mb-0">{{ $user->studentClasses()->where('status', 'Completed')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Thẻ thông tin chi tiết -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Thông tin chi tiết</h5>
                    <form action="{{ route('account.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Họ và tên</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                       name="full_name" value="{{ old('full_name', $user->full_name) }}">
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" value="{{ $user->school_email }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Số điện thoại</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mật khẩu hiện tại</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mật khẩu mới</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                       name="new_password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Xác nhận mật khẩu mới</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" class="form-control"
                                       name="new_password_confirmation">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}
.card-title {
    color: #333;
    font-weight: 600;
}
.form-control:disabled {
    background-color: #f8f9fa;
    border-color: #e9ecef;
}
</style>
@endsection
