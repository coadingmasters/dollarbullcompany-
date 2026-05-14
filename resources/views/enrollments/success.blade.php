<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Successful</title>
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --black: #0d0d0d;
            --card: #161616;
            --border: rgba(201, 168, 76, 0.18);
            --text: #D8D0C0;
            --muted: #7a7060;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--black);
            color: var(--text);
            font-family: Georgia, serif;
            font-size: 14px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&display=swap');

        .success-container {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 60px 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            animation: slideUp 0.6s ease both;
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

        .icon {
            font-size: 64px;
            margin-bottom: 24px;
            display: block;
            animation: bounce 0.6s ease both 0.3s;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        h1 {
            font-family: Cinzel, serif;
            font-size: 28px;
            color: var(--gold-light);
            margin-bottom: 12px;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .details {
            background: rgba(201, 168, 76, 0.05);
            border: 1px solid var(--border);
            padding: 20px;
            margin-bottom: 32px;
            text-align: left;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            color: var(--muted);
        }

        .detail-value {
            color: var(--gold-light);
            font-weight: 600;
        }

        .next-steps {
            background: rgba(201, 168, 76, 0.08);
            border-left: 3px solid var(--gold);
            padding: 16px;
            margin-bottom: 32px;
            text-align: left;
        }

        .next-steps h3 {
            font-family: Cinzel, serif;
            font-size: 12px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .next-steps p {
            font-size: 13px;
            color: var(--text);
            line-height: 1.6;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        button, a {
            padding: 10px 24px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text);
            cursor: pointer;
            font-family: Georgia, serif;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        a {
            background: var(--gold);
            color: var(--black);
            border-color: var(--gold);
            font-weight: 600;
        }

        a:hover {
            background: var(--gold-light);
            border-color: var(--gold-light);
        }

        button {
            background: transparent;
        }

        button:hover {
            border-color: var(--gold);
            color: var(--gold);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <span class="icon">✓</span>
        <h1>Enrollment Successful!</h1>
        <p class="subtitle">Your enrollment has been submitted successfully. We will review and contact you within 48 hours.</p>

        <div class="details">
            <div class="detail-item">
                <span class="detail-label">Status:</span>
                <span class="detail-value">PENDING REVIEW</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Next Step:</span>
                <span class="detail-value">Admin Review</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Contact:</span>
                <span class="detail-value">WhatsApp / Email</span>
            </div>
        </div>

        <div class="next-steps">
            <h3>What Happens Next?</h3>
            <p>✓ Your enrollment will be verified by our team<br>✓ You'll receive a confirmation via WhatsApp<br>✓ Access to course materials and community<br>✓ Direct support from mentors</p>
        </div>

        <div class="actions">
            <a href="/">← Back to Home</a>
            <a href="/courses">View Courses →</a>
        </div>
    </div>
</body>
</html>
