<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = strip_tags(trim($_POST["name"]));
    $phone = strip_tags(trim($_POST["phone"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $comment = trim($_POST["comment"]);  // Changed from $message to $comment to match HTML form

    // Check for any missing fields or invalid email
    if (empty($name) || empty($phone) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($comment)) {
        http_response_code(400);
        echo "Please fill in all the fields of the form correctly.";
        exit;
    }

    // Recipient email address
    $recipient = "o.yukhymyk@gmail.com";  // Change to your actual email address
    $subject = "New message from $name";
    
    // Construct the email content
    $email_content = "Name: $name\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Comment:\n$comment\n";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Attempt to send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Thank you for your message!<br>We have received your inquiry and will try to respond as soon as possible.<br>Sincerely, MDB.";
    } else {
        // Notify user of sending failure
        http_response_code(500);
        echo "Unfortunately, your message cannot be sent.";
    }
} else {
    // Handle non-POST request
    http_response_code(403);
    echo "There was a problem with your request, please try again.";
}
?>
