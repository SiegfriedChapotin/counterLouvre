
var handler = StripeCheckout.configure({
    key: 'pk_test_5UkDgSkXlZsD9VAxJl3wORQZ00Q0g4VboZ',
    image: 'https://www.shareicon.net/data/256x256/2016/01/28/710373_france_512x512.png',
    locale: 'auto',
    token: function(token) {
        // You can access the token ID with `token.id`.
        // Get the token ID to your server-side code for use.
    }
});


document.getElementById('customButton').addEventListener('click', function(e) {
    var priceAmount = document . querySelector ( '.js-price-amount' );
    var price = Number(priceAmount . dataset . price );

    // Open Checkout with further options:
    handler.open({
        name: 'Musée le Louvre',
        description: 'La billeterie',
        zipCode: true,
        amount: price,
        currency:'eur',


    });
    e.preventDefault();
});

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
    handler.close();
});
