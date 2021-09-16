<!DOCTYPE html>
<html>
   <head>
      <title>Stripe Payment Page - HackTheStuff</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <style type="text/css">
         .panel-title {
         display: inline;
         font-weight: bold;
         }
         .display-table {
         display: table;
         }
         .display-tr {
         display: table-row;
         }
         .display-td {
         display: table-cell;
         vertical-align: middle;
         width: 61%;
         }
      </style>
   </head>
   <body>
      <div class="container border p-4" style="width:35%;margin-top:70px;background-color:#f2f2f2;" >
           <div class="panel panel-default credit-card-box" >
              <div class="panel-heading display-table" >
                 <div class="row display-tr" >
                    <h3 class="panel-title display-td" >Payment Details</h3>
                 </div>
              </div>
              <div class="panel-body m-2">
                 @if (Session::has('success'))
                 <div class="alert alert-success text-center">
                    <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> -->
                    <p>{{ Session::get('success') }}</p>
                 </div>
                 @endif
                 
                 <form
                    role="form"
                    action="{{ route('stripe.post') }}"
                    method="post"
                    class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                    id="payment-form">
                    @csrf
                    <div class='form-row row'>
                        <div class='col-md-12 form-group required mt-3'>
                            <label class='control-label'>Name on Card</label>
                            <input class='form-control' size="4" type='text'>
                        </div>
                    </div>
                    <div class='form-row row'>
                       <div class='col-md-12 form-group required'>
                          <label class='control-label'>Card Number</label> <img src="https://img.icons8.com/color/36/000000/visa.png" style="height:30px;width:30px;margin-left:5px;"> <img src="https://img.icons8.com/color/36/000000/mastercard.png" style="height:30px;width:30px;margin-left:5px;"><img src="https://img.icons8.com/color/36/000000/amex.png"  style="height:30px;width:30px;margin-left:5px;"><img src="https://img.icons8.com/color/48/000000/paypal.png"  style="height:30px;width:30px;margin-left:5px;"/> <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                       </div>
                    </div>
                    <div class='form-row row'>
                       <div class='col-xs-12 col-md-4 form-group cvc required'>
                          <label class='control-label'>CVC</label><img src="https://img.icons8.com/wired/64/000000/card-verification-value.png" style="height:20px;width:20px;margin-left:5px;"/> <input autocomplete='off'
                             class='form-control card-cvc' size='4'
                             type='text'>
                       </div>
                       <div class='col-xs-12 col-md-4 form-group expiration required'>
                          <label class='control-label'>Expiration Month</label> <input
                             class='form-control card-expiry-month' placeholder='MM' size='2'
                             type='text'>
                       </div>
                       <div class='col-xs-12 col-md-4 form-group expiration required'>
                          <label class='control-label'>Expiration Year</label> <input
                             class='form-control card-expiry-year' placeholder='YYYY' size='4'
                             type='text'>
                       </div>
                    </div>
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group invisible'>
                                <div class='alert-danger alert'></div>
                            </div>
                        </div>
                    
                    <div class="row">
                       <div class="col-xs-12 pl-4 ">
                          <button class="btn btn-primary btn-lg btn-block " type="submit">Pay Now </button>
                       </div>
                    </div>
                 </form>
              </div>
           </div>
            
         
      </div>
   </body>
   <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
   <script type="text/javascript">
      $(function() {
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
        $errorMessage.addClass('visible');
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('invisible');
                e.preventDefault();
            }
        });
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
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
</html>