<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Unsubscribe | Dioz Group</title>

<!-- OneSignal Script -->
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
<script>
  window.OneSignalDeferred = window.OneSignalDeferred || [];
  OneSignalDeferred.push(async function(OneSignal) {
    await OneSignal.init({
      appId: "27f09b56-1929-4a42-b5e8-66d37c058b0f",
      serviceWorkerPath: "/OneSignalSDKWorker.js",
      notifyButton: {
        enable: false // Hide default button
      }
    });
  });
</script>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    video {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
    }

    .unsubscribe-container {
        position: relative;
        z-index: 2;
        background-color: rgba(255, 255, 255, 0.15);
        padding: 40px 45px;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        text-align: center;
        max-width: 420px;
        width: 90%;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .unsubscribe-container img {
        max-width: 140px;
        margin-bottom: 20px;
        opacity: 0.95;
    }

    h2 {
        color: #ffffff;
        margin-bottom: 12px;
        font-size: 24px;
        font-weight: 700;
    }

    p {
        color: #f0f0f0;
        font-size: 15px;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    input[type="email"] {
        padding: 12px 15px;
        width: 100%;
        margin-bottom: 15px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        font-size: 14px;
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        transition: all 0.3s;
    }

    input[type="email"]::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    input[type="email"]:focus {
        outline: none;
        border-color: #ff6600;
        box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.2);
        background-color: rgba(255, 255, 255, 0.25);
    }

    button {
        padding: 12px 30px;
        background-color: #ff6600;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 102, 0, 0.3);
        width: 100%;
    }

    button:hover:not(:disabled) {
        background-color: #e65c00;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 102, 0, 0.4);
    }

    button:active:not(:disabled) {
        transform: translateY(0);
    }

    button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .message {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-size: 13px;
        display: none;
    }

    .message.show {
        display: block;
    }

    .error-message {
        background-color: rgba(255, 100, 100, 0.2);
        border: 1px solid rgba(255, 100, 100, 0.5);
        color: #ffcccc;
    }

    .success-message {
        background-color: rgba(100, 255, 100, 0.2);
        border: 1px solid rgba(100, 255, 100, 0.5);
        color: #ccffcc;
    }

    .info-message {
        background-color: rgba(100, 200, 255, 0.2);
        border: 1px solid rgba(100, 200, 255, 0.5);
        color: #ccecff;
    }

    .validation-checks {
        display: none;
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 6px;
        padding: 12px;
        margin-top: 15px;
        text-align: left;
        font-size: 12px;
    }

    .validation-checks.show {
        display: block;
    }

    .check-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        color: #f0f0f0;
    }

    .check-item:last-child {
        margin-bottom: 0;
    }

    .check-icon {
        margin-right: 8px;
        font-weight: bold;
    }

    .check-icon.passed {
        color: #90EE90;
    }

    .check-icon.failed {
        color: #FF6B6B;
    }

    /* Custom Unsubscribe Notification Prompt */
    .onesignal-unsubscribe-prompt {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #ffffff;
        color: #333333;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        padding: 16px;
        max-width: 360px;
        width: 90%;
        max-height: 200px;
        z-index: 9999;
        animation: slideIn 0.4s ease-out;
        border: 1px solid #e0e0e0;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .onesignal-unsubscribe-prompt.hide {
        display: none;
    }

    .prompt-title {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
        color: #333333;
    }

    .prompt-message {
        font-size: 13px;
        color: #666666;
        margin-bottom: 12px;
    }

    .prompt-buttons {
        display: flex;
        gap: 8px;
    }

    .prompt-btn {
        flex: 1;
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .prompt-btn-allow {
        background-color: #1f73e6;
        color: #ffffff;
    }

    .prompt-btn-allow:hover {
        background-color: #1560cc;
    }

    .prompt-btn-block {
        background-color: #f0f0f0;
        color: #333333;
        border: 1px solid #d0d0d0;
    }

    .prompt-btn-block:hover {
        background-color: #e8e8e8;
    }

    @media (max-width: 480px) {
        .onesignal-unsubscribe-prompt {
            bottom: 10px;
            right: 10px;
            left: 10px;
            width: auto;
            max-width: none;
        }
    }
</style>
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop playsinline>
    <source src="https://dioz.com/wp-content/uploads/2024/06/Banner-Video-Final.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<!-- Custom Unsubscribe Notification Prompt -->
<div class="onesignal-unsubscribe-prompt" id="unsubscribePrompt">
    <div class="prompt-title">diozglobal.us wants to</div>
    <div class="prompt-message">🔔 Allow to unsubscribe from notifications</div>
    <div class="prompt-buttons">
        <button class="prompt-btn prompt-btn-allow" onclick="handleAllow()">Allow</button>
        <button class="prompt-btn prompt-btn-block" onclick="handleBlock()">Block</button>
    </div>
</div>

<div class="unsubscribe-container">
    <img src="https://dioz.com/wp-content/uploads/2024/07/logo.svg" alt="Dioz Logo">
    <h2>Unsubscribe from Our Emails</h2>
    <p>Enter your email below to unsubscribe from our mailing list:</p>
    
    <div class="message error-message" id="errorMessage"></div>
    <div class="message success-message" id="successMessage"></div>
    <div class="message info-message" id="infoMessage">Validating email...</div>
    
    <form id="unsubscribeForm">
        <input 
            type="email" 
            id="emailInput"
            name="email" 
            placeholder="Your email address" 
            required
        >
        <br>
        <button type="submit" id="submitBtn">Unsubscribe</button>
    </form>

    <div class="validation-checks" id="validationChecks"></div>
</div>

<script>
// Handle Allow button
function handleAllow() {
    document.getElementById('unsubscribePrompt').classList.add('hide');
    alert('✓ You have opted in to receive notifications. You will now be notified when we have updates.');
}

// Handle Block button
function handleBlock() {
    document.getElementById('unsubscribePrompt').classList.add('hide');
}

// Original unsubscribe form handler
document.getElementById('unsubscribeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('emailInput').value.trim();
    const errorEl = document.getElementById('errorMessage');
    const successEl = document.getElementById('successMessage');
    const infoEl = document.getElementById('infoMessage');
    const checksEl = document.getElementById('validationChecks');
    const submitBtn = document.getElementById('submitBtn');
    
    // Reset messages
    errorEl.classList.remove('show');
    successEl.classList.remove('show');
    infoEl.classList.add('show');
    checksEl.classList.remove('show');
    errorEl.textContent = '';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('unsubscribe-handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'email=' + encodeURIComponent(email),
            timeout: 5000
        });
        
        if (response.redirected) {
            infoEl.classList.remove('show');
            window.location.href = response.url;
            return;
        }
        
        const data = await response.json();
        infoEl.classList.remove('show');
        
        if (!data.success) {
            errorEl.textContent = '❌ ' + (data.message || 'Validation failed.');
            errorEl.classList.add('show');
            
            // Show validation checks
            if (data.checks && Array.isArray(data.checks)) {
                let checksHTML = '<div style="color: #f0f0f0; font-weight: bold; margin-bottom: 8px;">Validation Results:</div>';
                data.checks.forEach(check => {
                    const icon = check.valid ? '✓' : '✗';
                    const iconClass = check.valid ? 'passed' : 'failed';
                    checksHTML += `
                        <div class="check-item">
                            <span class="check-icon ${iconClass}">${icon}</span>
                            <span><strong>${check.check}:</strong> ${check.message}</span>
                        </div>
                    `;
                });
                checksEl.innerHTML = checksHTML;
                checksEl.classList.add('show');
            }
            
            submitBtn.disabled = false;
        } else {
            successEl.textContent = '✓ Email successfully unsubscribed!';
            successEl.classList.add('show');
            setTimeout(() => {
                window.location.href = '/unsubscribe-success.html';
            }, 1500);
        }
    } catch (err) {
        console.error('Error:', err);
        infoEl.classList.remove('show');
        errorEl.textContent = '❌ Network error. Please try again.';
        errorEl.classList.add('show');
        submitBtn.disabled = false;
    }
});
</script>

</body>
</html>
