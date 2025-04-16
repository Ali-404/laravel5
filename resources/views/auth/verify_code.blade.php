@extends("layouts.app")
@section("content")

    <div class="container d-flex flex-column gap-2">
        @if (session('success'))
        <div>{{ session('success') }}</div>
        @endif

        @if ($errors->has('code'))
            <div>{{ $errors->first('code') }}</div>
        @endif

        <form class="d-flex flex-column " method="POST" action="{{ route('verify.code') }}">
            @csrf
            <label class="form-label">Enter the code sent to your email:</label>
            <input class="form-control m-2" type="text" name="code" required>
            <button class="btn btn-primary" type="submit">Verify</button>
        </form>

        <form method="POST" action="{{ route('resend.code') }}" style="margin-top: 10px;">
            @csrf
            <button class="btn btn-outline-primary" type="submit">Resend Code</button>
        </form>
    </div>
@endsection
