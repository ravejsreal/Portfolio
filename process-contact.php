<?php
// Get form data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$subject = trim($_POST['subject']) ?: 'Message from Website Contact Form';
$message = trim($_POST['message']);

// Validate inputs
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

// Set recipient email (your email)
$recipient = "alex@alexandrudev.com";

// Set email subject
$email_subject = "Portfolio Contact: $subject";

// Build the email content
$email_content = "Name: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";

// Build the email headers
$email_headers = "From: $name <$email>";

// Send the email to yourself
$success = mail($recipient, $email_subject, $email_content, $email_headers);

// Create auto-response email
$auto_subject = "Thank you for your message";
$auto_headers  = "MIME-Version: 1.0" . "\r\n";
$auto_headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$auto_headers .= "From: Alexandru <alex@alexandrudev.com>" . "\r\n";

// Auto-response HTML email template
$auto_message = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You</title>
    <style>
        body {
            font-family: "Montserrat", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f6f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #f8f6f2;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(166, 124, 82, 0.2);
            margin-bottom: 30px;
        }
        .logo {
            font-family: "Montserrat", Arial, sans-serif;
            font-size: 24px;
            font-weight: 500;
            letter-spacing: 0.15em;
            color: #333;
        }
        h1 {
            font-family: "Garamond", "Times New Roman", serif;
            font-weight: 400;
            font-size: 28px;
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 20px;
            color: #777;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(166, 124, 82, 0.2);
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .accent {
            color: #a67c52;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">ALEXANDRU</div>
        </div>
        
        <h1>Thank You for Your Message, ' . $name . '</h1>
        
        <p>I appreciate you taking the time to reach out. I have received your message and will get back to you as soon as possible.</p>
        
        <p>If your inquiry is urgent, please don\'t hesitate to contact me directly at <span class="accent">alex@alexandrudev.com</span>.</p>
        
        <p>Best regards,<br>Alexandru</p>
        
        <div class="footer">
            © 2025 Alexandru. All rights reserved.<br>
            Made with passion
        </div>
    </div>
</body>
</html>
';

// Send auto-response
$auto_success = mail($email, $auto_subject, $auto_message, $auto_headers);

// Return response
echo json_encode([
    'success' => $success, 
    'message' => $success ? 'Your message has been sent successfully!' : 'There was a problem sending your message. Please try again.'
]);
?> 