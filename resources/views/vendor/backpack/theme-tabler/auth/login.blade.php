@extends(backpack_view('layouts.plain'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('backpack.auth.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" name="email" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        <!-- Кнопка входа как гость -->
                        <form method="POST" action="{{ route('guest.login') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-secondary w-100">Login as Guest</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
