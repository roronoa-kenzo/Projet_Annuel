<!-- Conteneur pour la notification -->
<div id="notificationContainer" class="notification-container"></div>
    <?php
        if (isset($_SESSION['SuccessPost'])) {
            echo '<p id="successMessage" class="success-message">' . htmlspecialchars($_SESSION['SuccessPost']) . '</p>';
            echo '<script>showNotification("success", "' . htmlspecialchars($_SESSION['SuccessPost']) . '");</script>';
            unset($_SESSION['SuccessPost']);
        }
            
        if (isset($_SESSION['ErrorForum'])) {
            echo '<p id="errorMessage" class="error-message">' . htmlspecialchars($_SESSION['ErrorForum']) . '</p>';
            echo '<script>showNotification("error", "' . htmlspecialchars($_SESSION['ErrorForum']) . '");</script>';
            unset($_SESSION['ErrorForum']);
        }
            
        if (isset($_SESSION['ErrorContent'])) {
            echo '<p id="errorMessage" class="error-message">' . htmlspecialchars($_SESSION['ErrorContent']) . '</p>';
            echo '<script>showNotification("error", "' . htmlspecialchars($_SESSION['ErrorContent']) . '");</script>';
            unset($_SESSION['ErrorContent']);
        }
            
        if (isset($_SESSION['ErrorPost'])) {
            echo '<p id="errorMessage" class="error-message">' . htmlspecialchars($_SESSION['ErrorPost']) . '</p>';
            echo '<script>showNotification("error", "' . htmlspecialchars($_SESSION['ErrorPost']) . '");</script>';
            unset($_SESSION['ErrorPost']);
        }
    ?>
