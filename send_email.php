<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs to prevent injection attacks
    $name = htmlspecialchars($_POST['name']);
    $company_name = htmlspecialchars($_POST['company_name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // Email recipient (site owner's email)
    $to = 'parihar.sandy2010@gmail.com';  // Replace with your email address

    // Email subject
    $subject = 'Contact Form Submission';

    // Email content
    $message_content = "
    <html>
    <head><title>Contact Form Submission</title></head>
    <body>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Company Name:</strong> $company_name</p>
    <p><strong>Phone:</strong> $phone</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Message:</strong><br>$message</p>
    </body>
    </html>
    ";

    // Headers for the email
    $headers = "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-Type: text/html; charset=UTF-8" . PHP_EOL;
    $headers .= "From: $name <$email>" . PHP_EOL;

    // Send email to recipient
    if (mail($to, $subject, $message_content, $headers)) {
        // Email sent successfully, prepare confirmation email if needed

        // Confirmation email to the sender (optional)
        $confirmation_subject = 'Confirmation: Your Message has been Received';
        $confirmation_message = "
        <html>
        <head><title>Confirmation: Your Message has been Received</title></head>
        <body>
        <p>Dear $name,</p>
        <p>Thank you for contacting us. We have received your message and will get back to you as soon as possible.</p>
        <p>Here are the details you submitted:</p>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Company Name:</strong> $company_name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Message:</strong><br>$message</p>
        </body>
        </html>
        ";

        // Send confirmation email
        mail($email, $confirmation_subject, $confirmation_message, $headers);

        // Redirect to a thank you page or show a success message
        echo "<p>Thank you for your message. We will contact you shortly.</p>";
    } else {
        // Failed to send email
        echo "<p>Sorry, there was an error sending your message. Please try again later.</p>";
    }
} else {
    // Redirect to the form if accessed directly
    header("Location: index.html");
    exit;
}
?>
