@extends('layouts.app')
@section('content')
 <div class="container d-flex flex-column align-items-center justify-content-center">
 <h2>Scan this with :</h2>
  <ul>
  <li>Authy</li>
  <li>Google Authenticator</li>
  <li>Microsoft Authenticator</li>
</ul>



 <div class="d-flex align-items-center " style="gap: 5px;">
       <img src="{{ asset('img/1.png') }}" alt="" width="70px">
       <img src="{{ asset('img/2.png') }}" alt="" width="70px">
       <img src="{{ asset('img/3.webp') }}" alt="" width="70px">
 </div>



@if ($qrCodeUrl)
<img src="{{ $qrCodeUrl }}">
<p>Or enter manually: <strong>{{ $secret }}</strong></p>
@endif


<form action="{{ route('2fa.verify') }}" method="POST" class="d-flex flex-column" style="gap:20px">
    @csrf
    <label class="form-label">Enter code from your Authenticator app:</label>
    <input type="text" class="form-control" name="code" required  >
    <button type="submit" class="btn btn-primary ">Verify</button>
</form>
 </div>
@endsection
