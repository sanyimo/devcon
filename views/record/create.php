<main class="record">
    <h2 class="record__heading"><?php echo $title ?? t('Registro'); ?></h2>
    <p class="record__description"><?php echo t('Elige tu plan'); ?></p>

    <div class="packs__grid">
        <div class="pack">
            <h3 class="pack__name"><?php echo t('Entrada gratuita'); ?></h3>
            <ul class="pack__list">
                <li class="pack__element"><?php echo t('Acceso virtual a DevCon'); ?></li>
            </ul>

            <p class="pack__price">0€</p>

            <form method="POST" action="/purchase/free">
                <input class="packs__submit" type="submit" value="<?php echo t('Inscripción gratuita'); ?>">
            </form>
        </div>

        <div class="pack">
            <h3 class="pack__name"><?php echo t('Entrada presencial'); ?></h3>
            <ul class="pack__list">
                <li class="pack__element"><?php echo t('Acceso presencial a DevCon'); ?></li>
                <li class="pack__element"><?php echo t('Entrada para 2 días'); ?></li>
                <li class="pack__element"><?php echo t('Acceso a talleres y conferencias'); ?></li>
                <li class="pack__element"><?php echo t('Acceso a las grabaciones'); ?></li>
                <li class="pack__element"><?php echo t('Camisa del evento'); ?></li>
                <li class="pack__element"><?php echo t('Comida y bebida'); ?></li>
            </ul>

            <p class="pack__price">199€</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>

        <div class="pack">
            <h3 class="pack__name"><?php echo t('Entrada virtual'); ?></h3>
            <ul class="pack__list">
                <li class="pack__element"><?php echo t('Acceso virtual a DevCon'); ?></li>
                <li class="pack__element"><?php echo t('Entrada para 2 días'); ?></li>
                <li class="pack__element"><?php echo t('Acceso a talleres y conferencias'); ?></li>
                <li class="pack__element"><?php echo t('Acceso a las grabaciones'); ?></li>
            </ul>

            <p class="pack__price">49€</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container-virtual"></div>
                </div>
            </div>
        </div>
    </div>
</main>


<script src="https://www.paypal.com/sdk/js?client-id=AeRaVZmheOr2GRQnfJKrOvcYOzNOHxEHnHSHP-NRGeZvwbAcGN-q9Z_ZBCDqJ7oZWam8liIfLMCcsJvD&enable-funding=venmo&currency=EUR" data-sdk-integration-source="button-factory"></script>

<script>
    function initPayPalButton() {
        // In-person pass
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "1",
                        "amount": {
                            "currency_code": "EUR",
                            "value": 199
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    // // Full available details
                    // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                    // // Show a success message within this page, e.g.
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Gracias por tu compra!</h3>';

                    // // Or go to another URL:  actions.redirect('thank_you.html');
                    const data = new window.FormData();
                    data.append('pack_id', orderData.purchase_units[0].description);
                    data.append('payment_id', orderData.purchase_units[0].payments.captures[0].id);

                    fetch('/purchase', {
                            method: 'POST',
                            body: data
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.result) {
                                actions.redirect('http://localhost:3000/purchase/conferences');
                            }
                        })
                });
            },
            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');

        // Virtual pass
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "2",
                        "amount": {
                            "currency_code": "EUR",
                            "value": 49
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    // // Full available details
                    //console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                    // // Show a success message within this page, e.g.
                    //const element = document.getElementById('paypal-button-container');
                    //element.innerHTML = '';
                    //element.innerHTML = '<h3>Thank you for your payment!</h3>';

                    // // Or go to another URL:  actions.redirect('thank_you.html');
                    const data = new window.FormData();
                    data.append('pack_id', orderData.purchase_units[0].description);
                    data.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

                    fetch('/purchase', {
                            method: 'POST',
                            body: data
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.result) {
                                actions.redirect('http://localhost:3000/purchase/conferences');
                            }
                        })
                });
            },
            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container-virtual');
    }
    initPayPalButton();
</script>