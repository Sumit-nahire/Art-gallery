<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylish Checkout Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .payment-methods {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .pay-btn {
            flex: 1;
            padding: 12px;
            margin: 5px;
            background: #ddd;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pay-btn i {
            margin-right: 8px;
        }

        .pay-btn:hover,
        .pay-btn.active {
            background: #007BFF;
            color: white;
        }

        .hidden {
            display: none;
        }

        .checkout-btn {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            margin-top: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .checkout-btn:hover {
            background: #218838;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Checkout</h2>

        <label>Select an Artwork</label>
        <select id="artwork-select">
            <option value="">-- Select Artwork --</option>
        </select>

        <div id="artwork-details" class="hidden">
            <p><strong>Dimension:</strong> <span id="artwork-dimension"></span></p>
            <p><strong>Size:</strong> <span id="artwork-size"></span></p>
            <p><strong>Price:</strong> Rs. <span id="artwork-price"></span></p>
            <label>Quantity:
                <input type="number" id="quantity" value="1" min="1">
            </label>
            <p><strong>Total:</strong> Rs. <span id="total"></span></p>
        </div>

        <h3>Select Payment Method</h3>
        <div class="payment-methods">
            <button class="pay-btn" onclick="selectPayment('credit-card', this)">
                <i class="fas fa-credit-card"></i> Card
            </button>
            <button class="pay-btn" onclick="selectPayment('paypal', this)">
                <i class="fab fa-paypal"></i> PayPal
            </button>
            <button class="pay-btn" onclick="selectPayment('upi', this)">
                <i class="fas fa-mobile-alt"></i> UPI
            </button>
            <button class="pay-btn" onclick="selectPayment('cod', this)">
                <i class="fas fa-truck"></i> COD
            </button>
        </div>

        <div id="payment-form">
            <input type="text" id="credit-card-form" class="hidden" placeholder="Card Number">
            <input type="email" id="paypal-form" class="hidden" placeholder="PayPal Email">
            <input type="text" id="upi-form" class="hidden" placeholder="UPI ID">
            <input type="text" id="cod-form" class="hidden" placeholder="Delivery Address">
        </div>

        <button class="checkout-btn" onclick="processPayment()">Pay Now</button>
    </div>

    <script>
        function fetchArtworks() {
            fetch('fetch_artists.php')
                .then(response => response.json())
                .then(data => {
                    let select = document.getElementById("artwork-select");
                    data.forEach(art => {
                        let option = document.createElement("option");
                        option.value = JSON.stringify(art);
                        option.textContent = art.title;
                        select.appendChild(option);
                    });

                    select.addEventListener("change", function () {
                        let art = JSON.parse(this.value);
                        document.getElementById("artwork-details").classList.remove("hidden");
                        document.getElementById("artwork-dimension").textContent = art.dimension;
                        document.getElementById("artwork-size").textContent = art.size;
                        document.getElementById("artwork-price").textContent = art.sellingpricing;
                        document.getElementById("total").textContent = art.sellingpricing;
                    });
                })
                .catch(error => console.error("Error fetching artworks:", error));
        }

        function selectPayment(method, button) {
            document.querySelectorAll('.pay-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('#payment-form input').forEach(input => {
                input.classList.add('hidden');
                input.value = '';  // Clear input fields when switching
            });

            button.classList.add('active');

            if (method === 'cod') {
                document.getElementById('cod-form').classList.remove('hidden');

                // Create a new input field for mobile number or email
                let codContactForm = document.createElement("input");
                codContactForm.type = "text";
                codContactForm.id = "cod-contact-form";
                codContactForm.placeholder = "Email";
                codContactForm.classList.remove("hidden");

                // Append it only if it doesn't already exist
                if (!document.getElementById("cod-contact-form")) {
                    document.getElementById('payment-form').appendChild(codContactForm);
                }
            } else {
                document.getElementById(`${method}-form`).classList.remove('hidden');
            }
        }


        document.getElementById("quantity").addEventListener("input", function () {
            let price = parseFloat(document.getElementById("artwork-price").textContent);
            let quantity = this.value;
            document.getElementById("total").textContent = (quantity * price).toFixed(2);
        });

        function processPayment() {
            let selectedArtwork = document.getElementById("artwork-select").value;
            if (!selectedArtwork) {
                alert("Please select an artwork.");
                return;
            }

            let artwork = JSON.parse(selectedArtwork);
            let quantity = document.getElementById("quantity").value;
            let total = document.getElementById("total").textContent;
            let paymentMethod = document.querySelector(".pay-btn.active");
            if (!paymentMethod) {
                alert("Please select a payment method.");
                return;
            }
            paymentMethod = paymentMethod.textContent.trim();

            let address = document.getElementById("cod-form").value;
            let emailOrMobile = document.getElementById("cod-contact-form") ? document.getElementById("cod-contact-form").value : "";

            if (paymentMethod === "COD" && (!address || !emailOrMobile)) {
                alert("Please enter delivery address and contact details.");
                return;
            }

            let orderData = {
                payment_method: paymentMethod,
                price: total,
                order_date: new Date().toISOString().split("T")[0], // Current Date
                quantity: quantity,
                size: artwork.size,
                dimension: artwork.dimension,
                address: address,
                email: emailOrMobile
            };

            fetch('order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Order placed successfully!");
                        window.location.reload();
                    } else {
                        alert("Error placing order: " + data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        window.onload = fetchArtworks;
    </script>

</body>
<!-- </html> user select a COD option to give a email or mobile no option add  -->