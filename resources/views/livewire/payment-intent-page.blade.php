<div>
    <form action="{{ route('payment-intent.store') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="payment_intent_id" id="payment_intent_id">
        <input type="hidden" name="payment_intent_client_secret" id="payment_intent_client_secret">
        <!-- Stripe Elements Placeholder -->
        <div id="card-element" class="mb-4 p-4 border rounded-lg"></div>
        <div id="card-errors" class="text-red-500 text-sm mb-4" role="alert"></div>

        <button id="card-button" type="button" data-secret="{{ $payment->client_secret }}"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 disabled:cursor-not-allowed disabled:opacity-60">
            Process Payment
        </button>

    </form>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardElement.mount('#card-element');

        cardButton.addEventListener('click', async (e) => {
            const {
                paymentIntent,
                error
            } = await stripe.confirmCardPayment(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                    }
                }
            );

            if (error) {
                alert('error');
                console.error(error);
            } else {
                document.getElementById('payment_intent_id').value = paymentIntent.id;
                document.getElementById('payment_intent_client_secret').value = paymentIntent.client_secret;
                document.getElementById('payment-form').submit();
            }
        });
    </script>
</div>
