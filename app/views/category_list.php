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
