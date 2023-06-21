<div class="row">
    <div class="col-12">
        <div class="page-title-box page-title-box-alt">
            <h4 class="page-title">{{ $main }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
                    @if (isset($one) && $one)
                        <li class="breadcrumb-item">
                            <a href="{{ $one['route'] }}">{{ $one['title'] }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active">
                        {{ $main }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>