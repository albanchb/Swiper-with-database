<?php
$host = 'votrehost';
$dbname = 'votredbname';
$username = 'votreusername';
$password = 'votrepassword';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT titre, texte, image_histoire FROM Histoire";
    $stmt = $pdo->query($query);
    $histoires = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider Histoire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .slider-container {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: auto;
            overflow: hidden;
        }
        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }
        .slide {
            min-width: 100%;
            box-sizing: border-box;
            position: relative;
        }
        .slide img {
            width: 100%;
            height: auto;
        }
        .slide-content {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
        }
        .slide-content h2 {
            margin: 0;
            font-size: 24px;
        }
        .slide-content p {
            font-size: 16px;
        }
        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .prev {
            left: 10px;
        }
        .next {
            right: 10px;
        }
    </style>
</head>
<body>

<div class="slider-container">
    <div class="slider">
        <?php foreach ($histoires as $histoire): ?>
            <div class="slide">
                <img src="<?php echo $histoire['image_histoire']; ?>" alt="Image de l'histoire">
                <div class="slide-content">
                    <h2><?php echo $histoire['titre']; ?></h2>
                    <p><?php echo $histoire['texte']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="nav-button prev" onclick="moveSlide(-1)">&#10094;</button>
    <button class="nav-button next" onclick="moveSlide(1)">&#10095;</button>
</div>

<script>
    let currentIndex = 0;

    function moveSlide(direction) {
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;

        currentIndex += direction;
        if (currentIndex < 0) {
            currentIndex = totalSlides - 1;
        } else if (currentIndex >= totalSlides) {
            currentIndex = 0;
        }

        const slider = document.querySelector('.slider');
        slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
</script>

</body>
</html>
