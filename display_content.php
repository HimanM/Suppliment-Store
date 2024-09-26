<?php
include 'PHP/db_config.php'; // Database connection
session_start();
// Fetch content by type
$sql = "SELECT c.*, u.username FROM content c JOIN users u ON c.author_id = u.id ORDER BY c.created_at DESC";
$result = $conn->query($sql);

// Organize content by type
$articles = [];
$guides = [];
$blog_posts = [];

while ($row = $result->fetch_assoc()) {
    switch ($row['type']) {
        case 'article':
            $articles[] = $row;
            break;
        case 'guide':
            $guides[] = $row;
            break;
        case 'blog_post':
            $blog_posts[] = $row;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/display_content.css">
</head>
<body>
    <?php include 'top_nav.php'; ?>
    <div class="container mt-5">
        <div class="container glass-card mt-2 p-2 mb-5">
		<h2 class="mb-3 m-2">Articles</h2>
            <div id="carouselExampleControls" class="carousel">
                <div class="carousel-inner">
                    <?php
                    $counter = 0; // Initialize a counter
                    foreach ($articles as $article):
                        if ($counter == 0):?>
                            <div class="carousel-item active">
                                <div class="card">
                                    <?php if (!empty($article['image_url'])): ?>
                                        <div class="img-wrapper"><img src="images/content/<?php echo htmlspecialchars($article['image_url']); ?>" class="d-block w-100" alt="Image"> </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                                        <p class="card-text">By: <?php echo htmlspecialchars($article['username']); ?></p>
                                        <a href="show_content.php?id=<?php echo $article['id']; ?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php else:?>
                            <div class="carousel-item">
                                <div class="card">
                                    <?php if (!empty($article['image_url'])): ?>
                                        <div class="img-wrapper"><img src="images/content/<?php echo htmlspecialchars($article['image_url']); ?>" class="d-block w-100" alt="Image"> </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                                        <p class="card-text">By: <?php echo htmlspecialchars($article['username']); ?></p>
                                        <a href="show_content.php?id=<?php echo $article['id']; ?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    $counter++; // Increment the counter after each iteration
                    endforeach;?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>




		<!-- 2nd -->
        <div class="container glass-card mt-2 p-2 mb-5">
		<h2 class="mb-3 m-2">Guides</h2>
            <div id="carouselExampleControls2" class="carousel">
                <div class="carousel-inner">
                    <?php
                    $counter = 0; // Initialize a counter
                    foreach ($guides as $guide):
                        if ($counter == 0):?>
                            <div class="carousel-item active">
                                <div class="card">
                                    <?php if (!empty($guide['image_url'])): ?>
                                        <div class="img-wrapper"><img src="images/content/<?php echo htmlspecialchars($guide['image_url']); ?>" class="d-block w-100" alt="Image"> </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($guide['title']); ?></h5>
                                        <p class="card-text">By: <?php echo htmlspecialchars($guide['username']); ?></p>
                                        <a href="show_content.php?id=<?php echo $guide['id']; ?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php else:?>
                            <div class="carousel-item">
                                <div class="card">
                                    <?php if (!empty($guide['image_url'])): ?>
                                        <div class="img-wrapper"><img src="images/content/<?php echo htmlspecialchars($guide['image_url']); ?>" class="d-block w-100" alt="Image"> </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($guide['title']); ?></h5>
                                        <p class="card-text">By: <?php echo htmlspecialchars($guide['username']); ?></p>
                                        <a href="show_content.php?id=<?php echo $guide['id']; ?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    $counter++; // Increment the counter after each iteration
                    endforeach;?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>


		<!-- 3rd -->
		<div class="container glass-card mt-2 p-2 mb-5">
		<h2 class="mb-3 m-2">Blog Posts</h2>
            <div id="carouselExampleControls3" class="carousel">
                <div class="carousel-inner">
                    <?php
                    $counter = 0; // Initialize a counter
                    foreach ($blog_posts as $post):
                        if ($counter == 0):?>
                            <div class="carousel-item active">
                                <div class="card">
                                    <?php if (!empty($post['image_url'])): ?>
                                        <div class="img-wrapper"><img src="images/content/<?php echo htmlspecialchars($post['image_url']); ?>" class="d-block w-100" alt="Image"> </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                                        <p class="card-text">By: <?php echo htmlspecialchars($post['username']); ?></p>
                                        <a href="show_content.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php else:?>
                            <div class="carousel-item">
                                <div class="card">
                                    <?php if (!empty($post['image_url'])): ?>
                                        <div class="img-wrapper"><img src="images/content/<?php echo htmlspecialchars($post['image_url']); ?>" class="d-block w-100" alt="Image"> </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                                        <p class="card-text">By: <?php echo htmlspecialchars($post['username']); ?></p>
                                        <a href="show_content.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    $counter++; // Increment the counter after each iteration
                    endforeach;?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls3" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls3" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
    <script src="JS/content.js"></script>
    <script src="JS/chat_script.js"></script>
</body>
</html>
