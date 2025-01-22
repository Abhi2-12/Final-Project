<?php
session_start();
if (!isset($_COOKIE['status'])) {
    header('location: login.html');  
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header('Content-Type: application/json');

    $searchedWord = trim($_POST['query'] ?? '');
    if ($searchedWord === '') {
        echo json_encode(["status" => "error", "message" => "Search term cannot be empty."]);
        exit;
    }

    $conn = new mysqli('localhost', 'root', '', 'member');
    if ($conn->connect_error) {
        echo json_encode(["status" => "error", "message" => "Database connection failed."]);
        exit;
    }

    $searchTerm = "%$searchedWord%";
    $sql = "SELECT title, description, post_date, post_img 
            FROM post 
            WHERE title LIKE '$searchTerm' OR description LIKE '$searchTerm'";

    $result = $conn->query($sql);

    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["status" => "success", "data" => $data]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error executing query."]);
    }

    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .result-item {
            border: 1px solid #007bff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .result-item h3 {
            margin: 0 0 5px;
            font-size: 1.2rem;
            color: #007bff;
        }
        .result-item img {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
        }
        .result-item p {
            margin: 0;
            font-size: 0.9rem;
        }
        .error, .no-results {
            text-align: center;
            color: red;
            font-weight: bold;
        }
        .home-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color:rgb(255, 102, 0);
            color: white;
            font-size: 1rem;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            width: fit-content;
        }
        .home-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="searchForm">
            <h1>Search</h1>
            <input type="text" id="query" placeholder="Enter search term..." style="width: 100%; padding: 10px; margin-bottom: 10px;" required>
            <button type="submit" style="padding: 10px; width: 100%; background: #007bff; color: #fff; border: none; border-radius: 5px;">Search</button>
        </form>
        <div id="results"></div>
        <a href="home.php" class="home-button" style="display: none;">Go to Home</a>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = document.getElementById('query').value.trim();
            if (!query) {
                alert('Search term cannot be empty.');
                return;
            }

            const resultsContainer = document.getElementById('results');
            const homeButton = document.querySelector('.home-button');
            resultsContainer.innerHTML = '<p>Searching...</p>';
            homeButton.style.display = 'none';

            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ query })
            })
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = '';
                if (data.status === 'success' && data.data.length > 0) {
                    data.data.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'result-item';
                        div.innerHTML = `
                            <h3>${item.title}</h3>
                            ${item.post_img ? `<img src="${item.post_img}" alt="Image">` : ''}
                            <p>${item.description}</p>
                            <small>Posted on: ${item.post_date}</small>
                        `;
                        resultsContainer.appendChild(div);
                    });
                    homeButton.style.display = 'block';
                } else {
                    resultsContainer.innerHTML = '<p class="no-results">No results found.</p>';
                    homeButton.style.display = 'block';
                }
            })
            .catch(() => {
                resultsContainer.innerHTML = '<p class="error">An error occurred while fetching data.</p>';
                homeButton.style.display = 'block';
            });
        });
    </script>
</body>
</html>
