@extends('layouts.l')
@section('content')

    @include('partials.body.breadcrumb', [
        'main' => 'Institute profile'
    ])
    
    <div class="row">
        <h1>{{ $institute->title }}</h1>
    </div>

@endsection