<?php
$pageTitle = $pageTitle ?? 'TaskFlow - Task Management System';
$breadcrumbs = $breadcrumbs ?? [];
$showContainer = $showContainer ?? true;
?>

<?php include COMPONENTS_PATH . '/header.component.php'; ?>
<?php include COMPONENTS_PATH . '/navbar.component.php'; ?>

<?php if (!empty($breadcrumbs)): ?>
<div style="background: rgba(255, 255, 255, 0.8); padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.1);">
    <div class="container">
        <nav style="font-size: 14px; color: #666;">
            <?php foreach ($breadcrumbs as $index => $crumb): ?>
                <?php if ($index > 0): ?>
                    <span style="margin: 0 8px;">→</span>
                <?php endif; ?>
                
                <?php if (isset($crumb['url']) && $index < count($breadcrumbs) - 1): ?>
                    <a href="<?= htmlspecialchars($crumb['url']) ?>" style="color: #667eea; text-decoration: none;">
                        <?= htmlspecialchars($crumb['title']) ?>
                    </a>
                <?php else: ?>
                    <span style="color: #333; font-weight: 500;">
                        <?= htmlspecialchars($crumb['title']) ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    </div>
</div>
<?php endif; ?>

<main style="min-height: calc(100vh - 200px);">
    <?php if ($showContainer): ?>
        <div class="container">
            <?= $content ?? '' ?>
        </div>
    <?php else: ?>
        <?= $content ?? '' ?>
    <?php endif; ?>
</main>

<?php include COMPONENTS_PATH . '/footer.component.php'; ?>
