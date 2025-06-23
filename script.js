// Select all product cards
const productCards = document.querySelectorAll('.product-card');

productCards.forEach(card => {
    // Size selection
    const sizeOptions = card.querySelectorAll('.size-option');
    sizeOptions.forEach(option => {
        option.addEventListener('click', () => {
            sizeOptions.forEach(opt => opt.classList.remove('selected'));
            option.classList.add('selected');
        });
    });

    // Quantity control
    const minusBtn = card.querySelector('.quantity-btn.minus');
    const plusBtn = card.querySelector('.quantity-btn.plus');
    const quantityInput = card.querySelector('.quantity-input');

    // Define updatePrice inside the loop to access card and quantityInput
    const updatePrice = () => {
        const quantity = parseInt(quantityInput.value);
        const basePrice = parseFloat(card.querySelector('.price').getAttribute('data-base-price'));
        const newPrice = (basePrice * quantity).toFixed(2);
        card.querySelector('.price').textContent = `$${newPrice}`;
    };

    minusBtn.addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            quantityInput.value = value - 1;
            updatePrice(); // Update price when decreasing
        }
    });

    plusBtn.addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        quantityInput.value = value + 1;
        updatePrice(); // Update price when increasing
    });

    // Handle manual input changes
    quantityInput.addEventListener('change', updatePrice);
});

/*register.php - This part is fine*/
document.querySelector('.toggle-password').addEventListener('click', function() {
    const passwordInput = document.querySelector('#password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});