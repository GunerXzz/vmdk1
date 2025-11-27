document.addEventListener('DOMContentLoaded', function () {

    // The function that sends the update request to the server
    function updateCart(productId, quantity, action = 'update') {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        formData.append('action', action);

        fetch('admin/update-cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the totals on the page
                document.getElementById('cart-total-price').textContent = '$' + data.total_price;
                document.getElementById('cart-grand-total').textContent = '$' + data.total_price;

                // Update the specific product's subtotal
                if (data.subtotals && data.subtotals[productId]) {
                    const productRow = document.querySelector(`tr[data-id="${productId}"]`);
                    if (productRow) {
                        productRow.querySelector('.product-subtotal').textContent = '$' + data.subtotals[productId];
                    }
                }
                
                // If the item was removed (quantity <= 0), remove the row from the table
                if (quantity <= 0 || action === 'remove') {
                    const productRow = document.querySelector(`tr[data-id="${productId}"]`);
                    if (productRow) {
                        productRow.remove();
                    }
                }
                
                // Check if the cart is now empty
                if (data.total_items === 0) {
                     location.reload(); // Reload the page to show the "empty cart" message
                }

            } else {
                console.error('Error updating cart:', data.message);
            }
        })
        .catch(error => console.error('Fetch error:', error));
    }

    // --- Event Listeners for Quantity Buttons ---
    document.querySelectorAll('.quantity-container').forEach(container => {
        const input = container.querySelector('.quantity-input');
        const productId = input.dataset.id;

        // Decrease button
        container.querySelector('.decrease-btn').addEventListener('click', function () {
            let qty = parseInt(input.value);
            if (qty > 1) {
                input.value = qty - 1;
                updateCart(productId, input.value);
            }
        });

        // Increase button
        container.querySelector('.increase-btn').addEventListener('click', function () {
            let qty = parseInt(input.value);
            input.value = qty + 1;
            updateCart(productId, input.value);
        });
        
        // Listen for manual changes in the input box
        input.addEventListener('change', function() {
            let qty = parseInt(input.value);
            if (qty < 0) qty = 0; // Prevent negative numbers
            input.value = qty;
            updateCart(productId, qty);
        });
    });

    // --- Event Listener for Remove Buttons ---
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.dataset.id;
            // Set quantity to 0 to trigger removal logic in PHP
            updateCart(productId, 0, 'remove');
        });
    });

});