<?php
$pageTitle = $pageTitle ?? 'TaskFlow - Task Management System';
$breadcrumbs = $breadcrumbs ?? [];
$showContainer = $showContainer ?? true;
?>


<?php include COMPONENTS_PATH . '/header.component.php'; ?>
<?php include COMPONENTS_PATH . '/navbar.component.php'; ?>

<?php if (!empty($breadcrumbs)): ?>
<div class="breadcrumb-container">
    <div class="container">
        <nav class="breadcrumb-nav">
            <?php foreach ($breadcrumbs as $index => $crumb): ?>
                <?php if ($index > 0): ?>
                    <span class="breadcrumb-separator">→</span>
                <?php endif; ?>
                
                <?php if (isset($crumb['url']) && $index < count($breadcrumbs) - 1): ?>
                    <a href="<?= htmlspecialchars($crumb['url']) ?>" class="breadcrumb-link">
                        <?= htmlspecialchars($crumb['title']) ?>
                    </a>
                <?php else: ?>
                    <span class="breadcrumb-current">
                        <?= htmlspecialchars($crumb['title']) ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    </div>
</div>
<?php endif; ?>


<main class="main-content">
    <?php if ($showContainer): ?>
        <div class="container">
            <?= $content ?? '' ?>
        </div>
    <?php else: ?>
        <?= $content ?? '' ?>
    <?php endif; ?>
</main>

<?php include COMPONENTS_PATH . '/footer.component.php'; ?>
