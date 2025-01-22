<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f9ff;
            color: #333;
            text-align: center;
        }

        .payment-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .payment-container h3 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }

        .payment-option input {
            margin-right: 10px;
        }

        .payment-option:hover {
            background-color: #f0f0f0;
        }

        .order-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
        }

        .order-button:hover {
            background-color: #0056b3;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .checkbox-container input {
            margin-right: 10px;
        }

    </style>
</head>
<body>
    <div class="payment-container">
        <h3>Payment methods</h3>
        
        <label class="payment-option">
            <input type="radio" name="payment-method" value="bkash">
            <span>Bkash</span>
        </label>

        <label class="payment-option">
            <input type="radio" name="payment-method" value="nagad">
            <span>Nagad</span>
        </label>

        <label class="payment-option">
            <input type="radio" name="payment-method" value="credit-card">
            <span>Credit card / debit card</span>
        </label>

        <label class="payment-option">
            <input type="radio" name="payment-method" value="bank-transfer">
            <span>Bank transfer</span>
        </label>

        <div class="checkbox-container">
            <input type="checkbox" id="offers" name="offers">
            <label for="offers">Keep me informed on offers or promotions</label>
        </div>

        <button class="order-button">Order now</button>
    </div>
</body>
</html>
