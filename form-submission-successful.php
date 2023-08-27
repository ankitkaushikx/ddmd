<?php
/**
 * Template Name: Form Submission Successful
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f1f1f1;
        }

        .success-container {
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .success-icon {
            font-size: 48px;
            color: #4caf50;
            animation: scale-up 0.5s ease-in-out;
        }

        .success-message {
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .success-links {
            margin-top: 30px;
        }

        .success-links a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .success-links a:hover {
            background-color: #45a049;
        }

        /* Animation */
        @keyframes scale-up {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-icon">&#10004;</div>
        <div class="success-message">Form Submitted Successfully!</div>
        <div class="success-links">
            <a href="<?php echo home_url(); ?>">Go to Home Page</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('join'))); ?>">Fill the Form Again</a>
        </div>
    </div>
</body>

</html>

<?php
get_footer();
