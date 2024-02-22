# PHP Contact Form

This repository contains a PHP-based contact form solution. It provides a simple yet dynamic contact form with validation features for name and email fields.

## Features

- Validates the name to ensure it is submitted and less than 100 characters.
- Validates the email to ensure it is submitted and in a valid format.
- Displays error messages if any of the validation processes fail.
- Displays a thank you message and lists all submitted data if all validations pass correctly.
- Bonus: Retains user entries if one field validation fails, allowing the user to correct mistakes without re-entering all information.

## Getting Started

1. Clone this repository to your local machine:

    ```bash
    git clone https://github.com/Mohamed-Algharabawy17/PHP-Labs/Lab_1_PHP.git
    ```

2. Navigate to the directory of the project:

    ```bash
    cd php-contact-form
    ```

3. Configure the project by editing the `config.php` file to set parameters such as max length and thank you message.

4. Run a local PHP server:

    ```bash
    php -S localhost:8000
    ```

5. Open your web browser and visit `http://localhost:8000` to access the contact form.

## Files

- `index.php`: Contains the HTML and PHP code for the contact form.
- `config.php`: Configuration file containing parameters for the contact form.
- `style.css`: CSS stylesheet for styling the contact form.

## Contributing

Contributions are welcome! If you have suggestions for improvements or new features, please feel free to submit a pull request.
