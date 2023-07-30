@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [
    'main' => 'Stripe Payment',
    'one' => [
        'title' => 'Stripe Payment',
        'route' => '#',
    ],
])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('status.index')

                <div class="row">
                    <div class="col-xl-8">                        
                        <div class="error visually-hidden">
                            <div class="alert alert-danger fw-bold" role="alert"></div>
                        </div>
                        <div id="checkout-nav-pills-wizard" class="twitter-bs-wizard form-wizard-header">
                            
                            <form 
                                role="form" 
                                action="{{ route('applications.student.pay') }}" 
                                method="post" 
                                class="require-validation"
                                data-cc-on-file="false"
                                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                id="payment-form">

                                @csrf

                                <input type="hidden" name="id" value="{{ $application->id }}" id="id">

                                <div class="tab-content twitter-bs-wizard-tab-content">
                                    <div class="tab-pane active" id="payment-info">
                                        <div>
                                            <!-- Credit/Debit Card box-->
                                            <div class="border p-3 mb-3 rounded">
                                                <div class="float-end">
                                                    <i class="ri-bank-card-fill font-24 text-primary"></i>
                                                </div>
                                                <div class="form-check form-check-inline font-16 mb-0">
                                                    <input class="form-check-input" type="radio" name="billingOptions" id="BillingOptRadio2" checked="">
                                                    <label class="form-check-label" for="BillingOptRadio2">Credit / Debit Card</label>
                                                </div>
                                                <p class="mb-0 ps-3 pt-1">Safe money transfer using your bank account. We support Mastercard, Visa, Discover and Stripe.</p>
                                                
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="mb-2 form-group required">
                                                            <label for="card-name" class="form-label">Name on card</label>
                                                            <input value="Edward Mwangi" type="text" id="card-name-on" class="form-control " placeholder="Master Name">
                                                            <div class="invalid-feedback">This field required.</div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="mb-2 form-group required">
                                                            <label for="card-number" class="form-label">Card Number</label>
                                                            <input value="4242 4242 4242 4242" type="text" id="card-number" class="form-control card-number" data-toggle="input-mask" data-mask-format="0000 0000 0000 0000" placeholder="4242 4242 4242 4242">
                                                            <div class="invalid-feedback">Card number is required.</div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-2 form-group cvc required">
                                                            <label for="card-cvv" class="form-label">CVV code</label>
                                                            <input value="124" type="text" id="card-cvv" class="form-control card-cvv" data-toggle="input-mask" data-mask-format="000" placeholder="012">
                                                            <div class="invalid-feedback">Cvv is required.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2 form-group expiration required">
                                                            <label for="card-expiry-month" class="form-label">Expiry month</label>
                                                            <input value="07" type="text" id="card-expiry-month" class="form-control card-expiry-month" data-toggle="input-mask" data-mask-format="00" placeholder="MM">
                                                            <div class="invalid-feedback">This field required.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2 form-group expiration required">
                                                            <label for="card-expiry-year" class="form-label">Expiry year</label>
                                                            <input value="2028" type="text" id="card-expiry-year" class="form-control card-expiry-year" data-toggle="input-mask" data-mask-format="0000" placeholder="YYYY">
                                                            <div class="invalid-feedback">This field required.</div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                            </div>
                                            <!-- end Credit/Debit Card box-->
                                        </div>
                                        <ul class="pager wizard list-inline mt-3">
                                            <li class="list-inline-item float-end">
                                                <button type="submit" class="btn btn-success"><i class="mdi mdi-cash-multiple me-1"></i> Pay </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card mt-4 mt-xl-0">
                            <div class="card-body">
                                <h4 class="header-title mb-3">Order Summary</h4>

                                <div class="table-responsive">

                                    @php
                                        $stripefee = config('mewar.usd_fee') ?? 100;
                                    @endphp
                                    <table class="table table-centered table-nowrap mb-0">
                                        <tbody>
                                            <tr>
                                                <td>Application</td>
                                                <td>Fee</td>
                                                <td class="text-end">USD {{ $stripefee }}</td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="2">
                                                    <h6 class="m-0">Sub Total:</h6>
                                                </td>
                                                <td class="text-end">USD {{ $stripefee }}</td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="2">
                                                    <h5 class="m-0">Total:</h5>
                                                </td>
                                                <td class="text-end fw-semibold">USD {{ $stripefee }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
        <!-- end row -->
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>    
    <script type="text/javascript">
        $(function() {
        
            /*------------------------------------------
            --------------------------------------------
            Stripe Payment Code
            --------------------------------------------
            --------------------------------------------*/
            
            var $form = $(".require-validation");
            
            $('form.require-validation').bind('submit', function(e) {

                var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                                'input[type=text]', 'input[type=file]',
                                'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                
                $errorMessage = $form.find('.is-invalid'),
                valid = true;
            
                $form.removeClass('is-invalid');

                $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.addClass('is-invalid');
                    e.preventDefault();
                }
                });
            
                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvv').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }            
            });
            
            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    
                    $('.error')
                        .removeClass('visually-hidden')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];
                        
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
            
        });
    </script>
@endpush

@endsection
