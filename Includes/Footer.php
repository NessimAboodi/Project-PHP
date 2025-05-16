
</main>
    
    <footer>
        <div class="container">
            <p>Application d'analyse de log &copy; <?php echo date('Y'); ?> - Équipe 3 - Développé par Nessim ABOODI</p>
        </div>
    </footer>

    <!-- Scripts JavaScript -->
    <script src="/assets/js/script.js"></script>
    
    <?php if (isset($additionalScripts)): ?>
        <?php foreach ($additionalScripts as $script): ?>
            <script src="<?php echo htmlspecialchars($script); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (isset($inlineScript)): ?>
    <script>
        <?php echo $inlineScript; ?>
    </script>
    <?php endif; ?>
</body>
</html>