<link rel="stylesheet" href="css/home.css">

<div class="container">
    <div class="centered-text">
        <h1>Welcome to Pastimes!</h1>
        <h2>You are logged in as 
            <?php
            if(!empty($_SESSION['user']['username']))
                echo $_SESSION['user']['username'];
            elseif(!empty($_SESSION['user']['tempName']))
                echo $_SESSION['user']['tempName'];
            else
                echo 'a Guest';
            ?>
        </h2>
    </div>

    <?php require __DIR__ . '/shared/banner.php'; ?>

    <p class="introductory-paragraph">
        At <strong class="strong">Pastimes</strong>, we believe that fashion should be a force for good, blending environmental sustainability with great style. Our platform makes it easy for you to refresh your wardrobe while reducing waste, giving pre-owned clothing and accessories a second life. As a second-hand clothing store, we’re dedicated to promoting circular fashion, where high-quality, gently used items find new homes instead of ending up in landfills.

        Whether you're hunting for a unique vintage piece, a trendy outfit, or timeless classics, our curated selection of pre-loved fashion offers something for every style and occasion. By choosing second-hand, you not only find incredible bargains but also contribute to the reduction of fashion’s carbon footprint.

        Selling your pre-owned items on Pastimes is just as simple. Clear out your closet, earn extra money, and know that your once-loved items will continue their journey with someone who values them as much as you did.

        Join our growing community of fashion-forward, eco-conscious shoppers who are making a positive impact—one wardrobe at a time. At Pastimes, sustainability, style, and affordability go hand in hand, and together, we can shape a future where fashion is mindful, exciting, and accessible to everyone.
    </p>

</div>

<style>
/* General container styling */
.container {
    padding: 20px;
    font-family: 'Arial', sans-serif;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    border: 1px solid #eaeaea;
}

/* Centered text for headings */
.centered-text {
    text-align: center;
    margin-bottom: 20px;
}

/* Styling for the introductory paragraph */
.introductory-paragraph {
    font-size: 1.2em;
    line-height: 1.75;
    color: #444;
    background-color: #f9f9f9;
    padding: 20px;
    margin: 30px 0;
    border-left: 6px solid #007bff;
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

/* Strong emphasis on the Pastimes brand */
.introductory-paragraph .strong {
    font-size: 1.6em;
    font-weight: bold;
    color: #007bff;
}

/* Hover effect for better interactivity */
.introductory-paragraph:hover {
    background-color: #e8f4ff;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Responsive design for smaller screens */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .introductory-paragraph {
        font-size: 1.1em;
        padding: 15px;
    }

    .centered-text h1 {
        font-size: 1.8em;
    }

    .centered-text h2 {
        font-size: 1.2em;
    }
}
</style>

