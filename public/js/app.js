var addToCartButtons, cartInHeader;

cartInHeader = $('#cart-in-header');
addToCartButtons = $('.js-add-to-cart');

addToCartButtons.on('click', function(event) {
    event.preventDefault();
    mask();
    console.log('Button pressed.');

    $.get(event.target.href, function (data) {
        cartInHeader.html(data);
        unmask();
    });
});

function mask() {
    $('body').append('<div class="lmask"><div>')
}

function unmask() {
    $('.lmask').remove();
}
