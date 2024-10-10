<section class="category_list">
    <h1>Categories</h1>
    <ul>
        <?php if(!empty($categories)): ?>
            <?php foreach($categories as $category): ?>
                <li>
                    <a href="/pastimes/categories/<?php echo htmlspecialchars($category['category_id']); ?>">
                        <?php echo htmlspecialchars($category['category_name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No categories found.</li>
        <?php endif; ?>
    </ul>
</section>

<style>
/* Categories Section Styles */
.category_list h1 {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    text-transform: uppercase;
}

.category_list ul {
    list-style: none; /* Remove default list styling */
    padding: 0;
    margin: 0 auto;
    max-width: 600px; /* Limit width for a better look */
}

.category_list ul li {
    background-color: #ffffff; /* White background for each category */
    border-radius: 5px;
    margin: 10px 0; /* Space between items */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s; /* Smooth transitions */
}

.category_list ul li:hover {
    transform: translateY(-3px); /* Lift effect on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
}

.category_list ul li a {
    display: block; /* Make link cover the entire list item */
    padding: 15px 20px; /* Padding for links */
    color: #007BFF; /* Link color */
    text-decoration: none; /* Remove underline */
    font-size: 1.1rem; /* Font size for category names */
    text-align: center; /* Center text */
}

.category_list ul li a:hover {
    background-color: #f0f0f0; /* Light gray background on hover */
    color: #0056b3; /* Darker blue on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    .category_list h1 {
        font-size: 1.5rem; /* Adjust heading size for mobile */
    }

    .category_list ul {
        max-width: 100%; /* Full width on mobile */
    }
}

</style>
