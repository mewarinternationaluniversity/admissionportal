<div class="row">
    <div class="col-12">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                <i class="mdi mdi-block-helper me-2"></i> <strong>{{ session('error') }}</strong>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <i class="mdi mdi-check-all me-2"></i> <strong>{{ session('success') }}</strong>
            </div>
        @endif
    </div>
</div>