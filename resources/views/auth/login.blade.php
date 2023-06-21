@extends('layouts.auth')

@section('content')
<div id="basicwizard">
    <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
        <li class="nav-item">
            <a href="#student-tab" data-bs-toggle="tab" data-toggle="tab" class="nav-link active"> 
                <span class="number">1</span>
                <span class="d-none d-sm-inline"> Student Login</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#admin-tab" data-bs-toggle="tab" data-toggle="tab" class="nav-link">
                <span class="number">2</span>
                <span class="d-none d-sm-inline"> Admin Login</span>
            </a>
        </li>
    </ul>

    <style>
        .tab-content {
            padding: 1px 0 0 0 !important;
        }
    </style>

    <div class="tab-content b-0 mb-0">
        <div class="tab-pane active" id="student-tab">
            <div class="row">
                <div class="col-12">
                    @include('auth.student')
                </div>
            </div>
        </div>
        
        <div class="tab-pane" id="admin-tab">
            <div class="row">
                <div class="col-12">
                    @include('auth.admin')
                </div>
            </div>
        </div>

    </div>
</div>    
@endsection
