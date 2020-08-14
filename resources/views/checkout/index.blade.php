@extends('layouts.app')
@section('extra-script')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
    <div class="col-md-12">
        <h1>Paye here</h1>
        <div class="row">
            <div class="col-md-6">
                <form id="payment-form" class="my-4">

                    <div id="card-element"><!--Stripe.js injects the Card Element--></div>
              
                    <button class="btn btn-success mt-4" id="submit">
              
                      <div class="spinner hidden" id="spinner"></div>
              
                      <span id="button-text">Pay</span>
              
                    </button>
              
                    <p id="card-error" role="alert"></p>
              
                    <p class="result-message hidden">
              
                      Payment succeeded, see the result in your
              
                      <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
              
                    </p>
              
                  </form>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
    <script>
        var stripe = Stripe("pk_test_51HG4gyKRxgNRtLuT2ow8LoEvXe1XdPAD60qAJTDc3agATRLxLPa5imvS9KI4L2rzr54a3THsZ0tLgPrOHIgMiP5i00iXBvqNQd");
        var elements = stripe.elements();

        // The items the customer wants to buy
        var purchase = {
            items: [{ id: "xl-tshirt" }]
        };

        // Disable the button until we have Stripe set up on the page
        
        var style = {
            base: {
                color: "#32325d",
                fontFamily: 'Arial, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#32325d"
                }
            },
            invalid: {
                fontFamily: 'Arial, sans-serif',
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };

        var card = elements.create("card", { style: style });
        // Stripe injects an iframe into the DOM
        card.mount("#card-element");

        card.on("change", function (event) {
        // Disable the Pay button if there are no card details in the Element
        document.querySelector("button").disabled = event.empty;
        document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
        });

        var SubmitButton = document.getElementById('submit');

        SubmitButton.addEventListener('click', function(ev) {
            ev.preventDefault();
            Stripe.confirmCardPayement(" $clientSecret ", {
                payment_method: {
                    card: card
                }
            }).then(function(result){
                if(result.error){
                    console.log(result.error.message);
                }else{
                    if(result.paymentIntent.status === 'succeeded'){
                        console.log(result.paymentIntent);
                    }
                }
            }).catch((err) => {
                console.log(result.error.message);
            });
        })

        /* ------- UI helpers ------- */
        // Shows a success message when the payment is complete
        var orderComplete = function(paymentIntentId) {
            loading(false);
            document
            .querySelector(".result-message a")
            .setAttribute(
                "href",
                "https://dashboard.stripe.com/test/payments/" + paymentIntentId
            );
            document.querySelector(".result-message").classList.remove("hidden");
            document.querySelector("button").disabled = true;
        };

        // Show the customer the error from Stripe if their card fails to charge
        var showError = function(errorMsgText) {
            loading(false);
            var errorMsg = document.querySelector("#card-error");
            errorMsg.textContent = errorMsgText;
            setTimeout(function() {
                errorMsg.textContent = "";
            }, 4000);
        };

        // Show a spinner on payment submission
        var loading = function(isLoading) {
            if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("button").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");

            } else {
            document.querySelector("button").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
            }

        };

    </script>
@endsection