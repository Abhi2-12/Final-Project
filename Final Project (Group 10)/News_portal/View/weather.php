<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = 'c7c9dc1c8966479659684c0ccc23a872'; 
    $city = isset($_POST['city']) ? urlencode(trim($_POST['city'])) : '';
    $lat = isset($_POST['lat']) ? htmlspecialchars($_POST['lat']) : '';
    $lon = isset($_POST['lon']) ? htmlspecialchars($_POST['lon']) : '';

    $response = [];
    if ($city) {
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
    } elseif ($lat && $lon) {
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$apiKey&units=metric";
    } else {
        $response = ['message' => 'Invalid input. Please provide a city name or location coordinates.'];
        echo json_encode($response);
        exit;
    }

    $weatherResponse = @file_get_contents($apiUrl);
    if ($weatherResponse) {
        echo $weatherResponse; // Return the weather data as JSON
    } else {
        $response = ['message' => 'Failed to fetch weather data. Please check your API key or network connection.'];
        echo json_encode($response);
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #2a5298;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            color: #333333;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            text-align: center;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #2a5298;
        }
        form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        input[type="text"] {
            padding: 10px;
            width: calc(100% - 30px);
            max-width: 300px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"], input[type="button"] {
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #2a5298;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #1e3c72;
        }
        .back-btn {
            padding: 10px 15px;
            font-size: 16px;
            color: #fff;
            background-color: #ff5722;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-btn:hover {
            background-color: #e64a19;
        }
        .weather {
            font-size: 18px;
            margin-top: 20px;
            text-align: left;
        }
        .weather p {
            background: #f9f9f9;
            margin: 10px auto;
            padding: 10px;
            border-radius: 5px;
            color: #333333;
            width: calc(100% - 30px);
            max-width: 500px;
            text-align: left;
        }
        .weather strong {
            color: #2a5298;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Weather Forecast</h1>
        <form id="cityForm">
        <a href="home.php" class="back-btn">Back</a>
            <input type="text" id="city" name="city" placeholder="Enter city name" />
            <input type="button" value="Search" onclick="getWeatherByCity()" />
        </form>
        <form id="locationForm">
            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="lon" name="lon">
            <input type="button" value="Get Current Location Weather" onclick="getWeatherByLocation()" />
        </form>
        <div id="weatherResult"></div>
    </div>

    <script>
        function getWeatherByCity() {
            const city = document.getElementById('city').value.trim();
            if (!city || !/^[a-zA-Z\s]+$/.test(city)) {
                alert('Please enter a valid city name.');
                return;
            }

            fetch('weather.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ city })
            })
            .then(response => response.json())
            .then(data => displayWeather(data))
            .catch(error => alert('Error: ' + error.message));
        }

        function getWeatherByLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    fetch('weather.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({ lat, lon })
                    })
                    .then(response => response.json())
                    .then(data => displayWeather(data))
                    .catch(error => alert('Error: ' + error.message));
                }, () => {
                    alert('Unable to retrieve your location.');
                });
            } else {
                alert('Geolocation is not supported by your browser.');
            }
        }

        function displayWeather(data) {
            const weatherResult = document.getElementById('weatherResult');
            weatherResult.innerHTML = '';

            if (data.message) {
                weatherResult.innerHTML = `<p><strong>Error:</strong> ${data.message}</p>`;
            } else {
                weatherResult.innerHTML = `
                    <p><strong>City:</strong> ${data.name}</p>
                    <p><strong>Temperature:</strong> ${data.main.temp} &deg;C</p>
                    <p><strong>Weather:</strong> ${data.weather[0].description}</p>
                    <p><strong>Humidity:</strong> ${data.main.humidity}%</p>
                `;
            }
        }
    </script>
</body>
</html>
