<?php
// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the API key and endpoint
$access_key = '2ff337bf331d8947a5493c2d45fd61eb'; // Replace with your actual Mediastack API key
$base_url = 'http://api.mediastack.com/v1/news';

// Initialize response variables
$articles = [];
$error_message = '';

// Set query parameters for the API request
$params = [
    'access_key' => $access_key,
    'countries' => 'za', // South Africa
    'languages' => 'en', // English
    'keywords' => 'electricity', // Search keywords
    'limit' => 27, // Number of articles to return
    'sort' => 'published_desc', // Sort by most recent
];

// Build the query string
$query_string = http_build_query($params);
$url = $base_url . '?' . $query_string;

// Attempt to fetch the news articles
try {
    // Make the API request
    $response_json = file_get_contents($url);

    // Check if the response is valid JSON
    if ($response_json === false) {
        throw new Exception('Failed to fetch data from Mediastack API. Please check your API key and parameters.');
    }

    // Decode the JSON response
    $data = json_decode($response_json, true);

    // Check if the data contains articles
    if (isset($data['data']) && !empty($data['data'])) {
        foreach ($data['data'] as $article) {
            $articles[] = [
                'title' => $article['title'],
                'description' => $article['description'],
                'url' => $article['url'],
                'urlToImage' => $article['image'] ?: 'https://via.placeholder.com/300x200?text=No+Image',
                'publishedAt' => date('F j, Y', strtotime($article['published_at'])),
                'source' => $article['source']
            ];
        }
    } else {
        $error_message = 'No relevant articles found or an error occurred.';
    }
} catch (Exception $e) {
    // Handle exceptions and set error message
    $error_message = 'Error fetching news: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Municipal Billing System">
    <meta name="author" content="Your Name">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>News</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            color: #333;
            padding: 0;
            margin: 0;
        }

        .navbar {
            background: rgba(0, 86, 179, 0.7);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            color: #fff;
            font-weight:bold;
        }

        .navbar .navbar-nav .nav-link {
            color: #fff;
            font-size : 1.1em;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

        .container-fluid {
            padding: 20px;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .profile-container h2 {
            margin-bottom: 50px;
            color: #0056b3;
        }
        .news-card {
    border: none;
    border-radius: 10px;
    background-color: #E6E6FA; /* Lavender */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    overflow: hidden;
    transition: transform 0.3s;
    height: 450px; /* Fixed height for all cards */
}

.news-card:hover {
    transform: translateY(-5px);
}

.news-card img {
    max-height: 200px;
    object-fit: cover;
    width: 100%;
}

.news-card .card-body {
    height: 200px; /* Fixed height for the card body */
    overflow-y: auto; /* Enables scrolling when content is too long */
    padding: 15px;
}

.news-card .card-title {
    color: #0056b3;
    font-weight: bold;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.news-card .card-text {
    color: #555;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.news-card .btn-primary {
    background-color: #0056b3;
    border: none;
    transition: background-color 0.3s;
        /* Resizing */
        padding: 12px 24px;  /* Adjust padding for larger size */
    font-size: 16px;     /* Increase font size */
    border-radius: 5px;  /* Optional: rounded corners */
    width: auto;         /* You can set a fixed width if necessary, e.g., width: 200px; */
    height: auto;        /* Adjust height if needed, or leave it auto to adapt with padding */
}



.news-card .btn-primary:hover {
    background-color: #003f7f;
}

    </style>
</head>

<body>
     <!-- Header -->
     <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Municipal Billing System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
             <li class="nav-item">
                 <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
             </li>
                 <li class="nav-item">
               <a class="nav-link active" href="profile.php"><i class="fas fa-user"></i> Profile</a>
             </li>
            <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-briefcase"></i> Bills
          </a>
           <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="electricity_bills.php">Electricity</a></li>
            <li><a class="dropdown-item" href="water_bills.php">Water</a></li>
          </ul>
          <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           <i class="fas fa-newspaper"></i>News
          </a>
           <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="electricity_news.php">Electricity</a></li>
            <li><a class="dropdown-item" href="water_news.php">Water</a></li>
            <li><a class="dropdown-item" href="loadshedding.php">Loadshedding</a></li>
          </ul>
            </li>
            
            <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
            </ul>

            </div>
             </div>
         </nav>

    <!-- Main Content -->
    <div class="container profile-container"><br>
        <h2 class="text-center mb-4">Latest News on Electricity and Water</h2>
        <br><hr><br>
        <!-- Display Error Message if Exists -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <!-- Display News Articles -->
        <div class="row">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-4">
                        <div class="card news-card">
                            <img src="<?= htmlspecialchars($article['urlToImage']) ?>" alt="Article Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($article['description']) ?></p>
                                <p class="text-muted">Published on <?= htmlspecialchars($article['publishedAt']) ?> by <?= htmlspecialchars($article['source']) ?></p>
                                <a href="<?= htmlspecialchars($article['url']) ?>" target="_blank" class="btn btn-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No news articles found related to electricity or water.</p>
            <?php endif; ?>
        </div>
    </div>
            </div>
         
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
