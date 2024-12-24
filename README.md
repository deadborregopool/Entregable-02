# Web Application: User and Savings Account Management

## Overview
This web application provides functionality for user registration, login, and savings account management. Built using **PHP**, **MySQL**, and **AJAX**, the application demonstrates secure backend operations, efficient database interactions, and an intuitive user interface.

## Features
### User Management
- **Registration**: Users can register by providing their name, email, and password.
- **Login**: Secure authentication using hashed passwords.
- **Profile Management**: Update user details, including optional password changes.
- **Account Deletion**: Users can delete their account, which removes all associated data.

### Savings Account Management
- **Create Account**: Users can create savings accounts with an initial balance.
- **Deposit/Withdraw**: AJAX-powered operations for updating account balances without reloading the page.
- **Delete Account**: Remove individual savings accounts.

### Security Features
- **Password Hashing**: User passwords are securely stored using `password_hash()` and validated with `password_verify()`.
- **AJAX Integration**: Ensures smooth user experience by handling operations asynchronously.
- **Session Management**: Protects user data and ensures authenticated access.


## Technologies Used
- **Backend**: PHP (PDO for database interactions)
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript, AJAX
- **Architecture**: MVC (Model-View-Controller)

## System Flow
1. **User Registration/Login**:
   - Register with unique email and secure password.
   - Login to access the dashboard.
2. **Dashboard Features**:
   - View and manage savings accounts.
   - Perform operations like deposits, withdrawals, and account deletion.
   - Update user profile details.
3. **Logout**: Securely ends the session.

## Future Enhancements
- Refactor the controller for better separation of concerns.
- Add CSRF protection and input sanitization for enhanced security.
- Integrate Angular or React for a dynamic frontend experience.
- Expand the testing suite for improved reliability.

## License
This project is licensed under the MIT License. Feel free to use and modify it.

