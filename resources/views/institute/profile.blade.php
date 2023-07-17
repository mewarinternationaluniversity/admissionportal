@extends('layouts.l')
@section('content')

    @include('partials.body.breadcrumb', [
        'main' => 'Institute profile'
    ])
    <div class="row">
        <div class="col-lg-4 col-xl-4">
            @include('institute.details')
        </div>
        <div class="col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-body">
                    @include('status.index')
                    <div class="tab-content">
                        <div class="tab-pane active" id="edit-profile">
                            @include('institute.edit')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection