<div>
    <form action="{{ route('setup-intent.store') }}" method="POST" id="setup-form">
        @csrf
        <input type="hidden" name="payment_method" id="payment_method">
        <!-- Stripe Elements Placeholder -->
        <div id="card-element" class="mb-4 p-4 border rounded-lg"></div>
        <div id="card-errors" class="text-red-500 text-sm mb-4" role="alert"></div>

        <button id="card-button" type="button" data-secret="{{ $setupIntent->client_secret }}"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 disabled:cursor-not-allowed disabled:opacity-60">
            Process setup
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
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
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
                document.getElementById('payment_method').value = setupIntent.id;
                document.getElementById('setup-form').submit();
            }
        });
    </script>
</div>
