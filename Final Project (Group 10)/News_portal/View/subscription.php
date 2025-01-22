<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Plans</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f9ff;
            text-align: center;
            color: #333;
        }

        h1 {
            margin-top: 20px;
            font-size: 2.5em;
        }

        p {
            font-size: 1.1em;
            margin-bottom: 30px;
            color: #555;
        }

        .pricing-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 0 auto;
            flex-wrap: wrap;
            padding: 20px;
        }

        .plan {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 300px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .plan h2 {
            font-size: 1.5em;
            color: #007BFF;
        }

        .plan .price {
            font-size: 2.5em;
            margin: 10px 0;
            color: #222;
        }

        .plan ul {
            list-style-type: none;
            padding: 0;
            text-align: left;
        }

        .plan ul li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .plan ul li:last-child {
            border-bottom: none;
        }

        .select-button {
            margin-top: auto;
            padding: 10px 20px;
            font-size: 1em;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .select-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Pick Best The Plan</h1>
    <p>Take your desired plan to get access to our content easily.</p>

    <div class="pricing-container">
        <div class="plan">
            <h2>Weekly</h2>
            <p class="price">$7 <span>Per Week</span></p>
            <ul>
                <li>Video news integration</li>
                <li>Offline Reading</li>
                <li>Share</li>
                <li>Ultra HD Quality</li>
            </ul>
            <a href="payment.php?plan=basic" class="select-button">SELECT PLAN</a>
        </div>

        <div class="plan">
            <h2>MONTHLY</h2>
            <p class="price">$25 <span>Per Month</span></p>
            <ul>
                <li>Video news integration</li>
                <li>Offline Reading</li>
                <li>Share</li>
                <li>Ultra HD Quality</li>
            </ul>
            <a href="payment.php?plan=standard" class="select-button">SELECT PLAN</a>
        </div>

        <div class="plan">
            <h2>YEARLY</h2>
            <p class="price">$120 <span>Per Year</span></p>
            <ul>
                <li>Video news integration</li>
                <li>Offline Reading</li>
                <li>Share</li>
                <li>Ultra HD Quality</li>
            </ul>
            <a href="payment.php?plan=premium" class="select-button">SELECT PLAN</a>
        </div>
    </div>
</body>

</html>