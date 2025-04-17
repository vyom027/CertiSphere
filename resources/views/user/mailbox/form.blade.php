<div class="container">
    <h4>Connect to College Mail</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('mailbox.connect') }}">
        @csrf
        <div class="mb-3">
            <label>UserName:</label>
            <input type="text" class="form-control" value="{{ $student->enrollment_no }}" disabled>
        </div>
        <div class="mb-3">
            <label>Enter Mail Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Connect</button>
    </form>
</div>