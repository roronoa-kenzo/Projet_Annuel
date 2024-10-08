<?php
session_start();
if (isset($_POST['darkMode'])) {
    $_SESSION['darkMode'] = $_POST['darkMode'];
}

$darkMode = isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on';

?>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const darkMode = <?php echo isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on' ? 'true' : 'false'; ?>;

        if (darkMode) {
            document.documentElement.classList.add('dark-mode');
        }
    });
</script>