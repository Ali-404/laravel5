@extends("layouts.app")
@section("content")

    <div class="container d-flex flex-column gap-2">
        @if (session('success'))
        <div>{{ session('success') }}</div>
        @endif

        @if ($errors->has('code'))
            <div>{{ $errors->first('code') }}</div>
        @endif

        <form class="d-flex flex-column " method="POST" action="{{ route('verify.code') }}" onsubmit="disableSubmit(this)">
            @csrf
            <label class="form-label">Enter the code sent to your email:</label>
            <input class="form-control m-2" type="text" name="code" required>
            <button class="btn btn-primary" id="verify_submit" type="submit">Verify</button>
        </form>

        <form method="POST" onsubmit="disableResend(this)" action="{{ route('resend.code') }}" style="margin-top: 10px;">
            @csrf
            <span id="resend_code_text">You can resend after 2 minutes</span>
            <button  id="resend_code" disabled class="btn btn-outline-primary disabled" type="submit">Resend Code</button>
        </form>
    </div>

    <script>
        setTimeout(function(){
            document.getElementById("resend_code_text").remove()
            document.getElementById("resend_code").classList.remove("disabled")
            document.getElementById("resend_code").removeAttribute("disabled")
        },2000 * 60);

        function disableResend(e){
            document.querySelector("#resend_code").disabled = true;
            document.querySelector("#resend_code").classList.add("disabled")
        }


        function disableSubmit(){
            document.querySelector("#verify_submit").disabled = true;
            document.querySelector("#verify_submit").classList.add("disabled")
            document.querySelector("#verify_submit").innerHTML = 'Verification ...'
        }

    </script>
@endsection
