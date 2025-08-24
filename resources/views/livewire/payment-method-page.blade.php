<div>

    <form action="{{ route('payment-method-checkout.store') }}" method="POST" id="payment-form">
        @csrf

        <input type="hidden" name="payment_method" id="payment_method">

        <!-- Stripe Elements Placeholder -->
        <div id="card-element"></div>

        <button id="card-button" type="button"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 disabled:cursor-not-allowed disabled:opacity-60">
            Process Payment
        </button>
    </form>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardButton = document.getElementById('card-button');
        cardButton.addEventListener('click', async () => {
            const {
                error,
                paymentMethod
            } = await stripe.createPaymentMethod(
                'card', cardElement
            );

            if (error) {
                alert('error');
                console.error(error);
            } else {
                document.getElementById('payment_method').value = paymentMethod.id;
                alert('success');
                console.log(paymentMethod);
                document.getElementById('payment-form').submit();
            }
        });
    </script>
</div>
