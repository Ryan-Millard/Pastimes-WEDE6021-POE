<h1>Category</h1>
<ul>
	<?php if(!empty($category)): ?>
		<li>
			<?php echo htmlspecialchars($category['category_name']); ?> - 
			<?php echo htmlspecialchars($category['description']); ?>
		</li>
	<?php else: ?>
		<li>Category not found.</li>
	<?php endif; ?>
</ul>
