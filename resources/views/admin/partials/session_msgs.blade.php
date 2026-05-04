@if(session('success'))
    <div class="alert alert-success p-1">{{ session('success') }}</div>
@endif

@if(session('failed'))
    <div class="alert alert-danger p-1">{{ session('failed') }}</div>
@endif
