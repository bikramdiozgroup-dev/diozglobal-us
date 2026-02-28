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
        enable: true,
        position: "bottom-right"
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
        max-width: 520px;
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

    .form-group {
        text-align: left;
        margin-bottom: 15px;
    }

    label {
        display: block;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    input[type="email"],
    input[type="tel"],
    input[type="text"],
    select {
        padding: 12px 15px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        font-size: 14px;
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        transition: all 0.3s;
    }

    input::placeholder,
    select {
        color: rgba(255, 255, 255, 0.7);
    }

    select option {
        background-color: #333;
        color: #fff;
    }

    input:focus,
    select:focus {
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

    .success-message {
        background-color: rgba(100, 255, 100, 0.2);
        border: 1px solid rgba(100, 255, 100, 0.5);
        color: #ccffcc;
    }

    .error-message {
        background-color: rgba(255, 100, 100, 0.2);
        border: 1px solid rgba(255, 100, 100, 0.5);
        color: #ffcccc;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        .unsubscribe-container {
            padding: 30px 25px;
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

<div class="unsubscribe-container">
    <img src="https://dioz.com/wp-content/uploads/2024/07/logo.svg" alt="Dioz Logo">
    <h2>Unsubscribe from Our Emails</h2>
    <p>Enter your details below to unsubscribe from our mailing list:</p>
    
    <div class="message success-message" id="successMessage"></div>
    <div class="message error-message" id="errorMessage"></div>
    
    <form id="unsubscribeForm">
        <!-- Email -->
        <div class="form-group">
            <label for="email">Email Address *</label>
            <input 
                type="email" 
                id="email"
                name="email" 
                placeholder="your@email.com" 
                required
            >
        </div>

        <!-- Phone Number -->
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input 
                type="tel" 
                id="phone"
                name="phone_number" 
                placeholder="+1 (555) 000-0000"
            >
        </div>

        <!-- Country -->
        <div class="form-row">
            <div class="form-group">
                <label for="country">Country</label>
                <select id="country" name="country">
                    <option value="">Select Country</option>
                    <option value="US">United States</option>
                    <option value="AU">Australia</option>
                    <option value="AE">UAE</option>
                    <option value="GB">United Kingdom</option>
                    <option value="CA">Canada</option>
                    <option value="IN">India</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <!-- Language -->
            <div class="form-group">
                <label for="language">Language</label>
                <select id="language" name="language">
                    <option value="">Select Language</option>
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                    <option value="fr">French</option>
                    <option value="de">German</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <!-- Timezone -->
        <div class="form-group">
            <label for="timezone">Timezone</label>
            <select id="timezone" name="timezone_id">
                <option value="">Select Timezone</option>
                <option value="America/New_York">Eastern Time (ET)</option>
                <option value="America/Chicago">Central Time (CT)</option>
                <option value="America/Denver">Mountain Time (MT)</option>
                <option value="America/Los_Angeles">Pacific Time (PT)</option>
                <option value="Europe/London">London (GMT)</option>
                <option value="Europe/Paris">Central European (CET)</option>
                <option value="Asia/Dubai">Dubai (GST)</option>
                <option value="Australia/Sydney">Sydney (AEDT)</option>
                <option value="Asia/Kolkata">India Standard (IST)</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <!-- Source -->
        <div class="form-group">
            <label for="source">How did you hear about us?</label>
            <select id="source" name="source">
                <option value="">Select Source</option>
                <option value="social_media">Social Media</option>
                <option value="search_engine">Search Engine</option>
                <option value="referral">Referral</option>
                <option value="direct">Direct</option>
                <option value="email">Email</option>
                <option value="other">Other</option>
            </select>
        </div>

        <button type="submit" id="submitBtn">Unsubscribe from Emails</button>
    </form>
</div>

<script>
// Get user's timezone automatically
function getUserTimezone() {
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    document.getElementById('timezone').value = tz || '';
}

window.addEventListener('DOMContentLoaded', function() {
    getUserTimezone();
});

document.getElementById('unsubscribeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        email: document.getElementById('email').value.trim(),
        phone_number: document.getElementById('phone').value.trim(),
        country: document.getElementById('country').value,
        language: document.getElementById('language').value,
        timezone_id: document.getElementById('timezone').value,
        source: document.getElementById('source').value,
        subscribed: 'yes',
        external_id: 'user_' + Date.now(),
    };

    const errorEl = document.getElementById('errorMessage');
    const successEl = document.getElementById('successMessage');
    const submitBtn = document.getElementById('submitBtn');

    errorEl.classList.remove('show');
    successEl.classList.remove('show');
    submitBtn.disabled = true;

    try {
        const response = await fetch('unsubscribe-handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
            timeout: 5000
        });

        const data = await response.json();

        if (!data.success) {
            errorEl.textContent = '❌ ' + (data.message || 'Error processing request.');
            errorEl.classList.add('show');
            submitBtn.disabled = false;
        } else {
            successEl.textContent = '✓ Your information has been recorded. You will be removed from our email list.';
            successEl.classList.add('show');
            
            console.log('User data collected:', formData);
            
            setTimeout(() => {
                window.location.href = '/unsubscribe-success.html';
            }, 2000);
        }
    } catch (err) {
        console.error('Error:', err);
        errorEl.textContent = '❌ Network error. Please try again.';
        errorEl.classList.add('show');
        submitBtn.disabled = false;
    }
});
</script>

</body>
</html>
