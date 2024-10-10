<section class="single_category">
	<h1>Category</h1>
	<ul>
		<?php if(!empty($category)): ?>
			<li>
				<strong>
					<?php echo htmlspecialchars($category['category_name']); ?> - 
				</strong>
				<?php echo htmlspecialchars($category['description']); ?>
			</li>
		<?php else: ?>
			<li>Category not found.</li>
		<?php endif; ?>
	</ul>
</section>

<style>
/* Category Styles */
.single_category h1 {
    font-size: 28px; /* Slightly larger for emphasis */
    color: #007BFF;  /* Blue color for the header */
    margin-bottom: 20px; /* Space below the header */
    text-align: center; /* Centered header */
}

.single_category ul {
    list-style-type: none; /* Remove default bullet points */
    padding: 0; /* Remove default padding */
    margin: 0; /* Remove default margin */
}

.single_category li {
    background-color: #ffffff; /* White background for list items */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
    padding: 15px; /* Inner spacing */
    margin: 10px 0; /* Space between list items */
    transition: transform 0.2s; /* Animation on hover */
}

.single_category li:hover {
    transform: scale(1.02); /* Slightly enlarge on hover */
}

.single_category li:nth-child(odd) {
    background-color: #f2f2f2; /* Light grey for alternate items */
}

.single_category li:nth-child(even) {
    background-color: #ffffff; /* White for even items */
}

.single_category li:not(:last-child) {
    border-bottom: 1px solid #ddd; /* Divider line between items */
}

</style>
