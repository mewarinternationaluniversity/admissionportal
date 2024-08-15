<form method="POST" action="{{ route('manager.institute.save') }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id" id="id" value="{{ $institute->id }}">

    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> {{ __('Institute Info') }}</h5>

   
        <div class="col-md-6">
            <div class="mb-2">
                <label for="title" class="form-label">{{ __('Name') }}</label>
                <input id="title" type="text" class="form-control" value="{{ $institute->title }}" readonly>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-2">
                <label for="officername" class="form-label">{{ __('Officer name') }}</label>
                <input id="officername" type="text" class="form-control @error('officername') is-invalid @enderror" name="officername" value="{{ old('officername', $institute->officername) }}" required>
    
                @error('officername')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-2">
                <label for="officeremail" class="form-label">{{ __('Officer email') }}</label>
                <input id="officeremail" type="email" class="form-control @error('officeremail') is-invalid @enderror" name="officeremail" value="{{ old('officeremail', $institute->officeremail) }}" required>
    
                @error('officeremail')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-2">
                <label for="phone" class="form-label">{{ __('Phone number') }}</label>
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $institute->phone) }}" required>
    
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

 

        <div class="col-md-6">
            <div class="mb-2">
                <label for="ngnappamount" class="form-label">{{ __('Application Fee (NGN)') }}</label>
                <input id="ngnappamount" type="number" class="form-control @error('ngnappamount') is-invalid @enderror" name="ngnappamount" value="{{ old('ngnappamount', $institute->ngnappamount) }}" required>
    
                @error('ngnappamount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="mb-2">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea name="description" class="form-control @error('phone') is-invalid @enderror" id="description" required>{{ old('description', $institute->description) }}</textarea>    
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <h5 class="mb-3 text-uppercase bg-light p-2">
        <i class="mdi mdi-file me-1"></i> Uploads
    </h5>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Preview Thumbnail</th>
                    <th>Replace</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Logo</td>
                    <td>
                        @if($institute->logo)
                            <a href="{{ url($institute->logo) }}" target="_blank">
                                <img src="{{ $institute->logo }}" alt="image" class="img-fluid img-thumbnail" width="100">
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="logo" id="logo">
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Banner</td>
                    <td>
                        @if($institute->banner)
                            <a href="{{ url($institute->banner) }}" target="_blank">
                                <img src="{{ $institute->banner }}" alt="image" class="img-fluid img-thumbnail" width="100">
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="banner" id="banner">
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Seal</td>
                    <td>
                        @if($institute->seal)
                            <a href="{{ url($institute->seal) }}" target="_blank">
                                <img src="{{ $institute->seal }}" alt="image" class="img-fluid img-thumbnail" width="100">
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="seal" id="seal">
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>Signature</td>
                    <td>
                        @if($institute->signature)
                            <a href="{{ url($institute->signature) }}" target="_blank">
                                <img src="{{ $institute->signature }}" alt="image" class="img-fluid img-thumbnail" width="100">
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="signature" id="signature">
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>Letter Head</td>
                    <td>
                        @if($institute->letterhead)
                            <a href="{{ url($institute->letterhead) }}" target="_blank">
                                <img src="{{ $institute->letterhead }}" alt="image" class="img-fluid img-thumbnail" width="100">
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="letterhead" id="letterhead">
                    </td>
                </tr>

                <tr>
                    <th scope="row">6</th>
                    <td>Slider one</td>
                    <td>
                        @if($institute->sliderone)
                            <a href="{{ url($institute->sliderone) }}" target="_blank">
                                <img src="{{ $institute->sliderone }}" alt="image" class="img-fluid img-thumbnail" width="100">
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="sliderone" id="sliderone">
                    </td>
                </tr>

                <tr>
                    <th scope="row">7</th>
                    <td>Slider Two</td>
                    <td>
                        @if($institute->slidertwo)
                            <a href="{{ url($institute->slidertwo) }}" target="_blank">
                                <img src="{{ $institute->slidertwo }}" alt="image" class="img-fluid img-thumbnail" width="100">
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="slidertwo" id="slidertwo">
                    </td>
                </tr>

                <tr>
                    <th scope="row">8</th>
                    <td>Slider Three</td>
                    <td>
                        @if($institute->sliderthree)
                            <a href="{{ url($institute->sliderthree) }}" target="_blank">
                                <img src="{{ $institute->sliderthree }}" alt="image" class="img-fluid img-thumbnail" width="100">
                            </a>
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="sliderthree" id="sliderthree">
                    </td>
                </tr>                
            </tbody>
        </table>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
            <i class="mdi mdi-content-save"></i> {{ __('Save') }}
        </button>
    </div>
</form>
