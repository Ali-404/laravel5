<h2>Scan this with Microsoft Authenticator</h2>
<img src="{{ $qrCodeUrl }}">

<p>Or enter manually: <strong>{{ $secret }}</strong></p>

<form action="{{ route('2fa.verify') }}" method="POST">
    @csrf
    <label>Enter code from your Authenticator app:</label>
    <input type="text" name="code" required>
    <button type="submit">Verify</button>
</form>
