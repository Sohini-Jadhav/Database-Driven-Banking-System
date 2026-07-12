# Database-Driven Banking System

A comprehensive **Database-Driven Banking System** developed using **MySQL, PHP, HTML, CSS, and JavaScript**. This project demonstrates the implementation of relational database concepts through a secure banking application, focusing on efficient data storage, retrieval, and transaction management.

---

## Overview

This project simulates the core operations of a banking system where administrators manage customer accounts while customers can securely access and perform banking activities. The primary objective is to showcase the practical application of **MySQL database design**, relational data management, SQL queries, and CRUD operations within a real-world banking environment.

---

## Key Features

### Administrator Module

- Secure Admin Authentication
- Dashboard Overview
- Create Customer Accounts
- Update Customer Information
- Delete Customer Accounts
- View All Customers
- Deposit Money
- Withdraw Money
- Transfer Funds
- View Transaction History
- Search Customer Records

### Customer Module

- Secure Customer Login
- Personal Dashboard
- Account Details
- Deposit Funds
- Withdraw Funds
- Transfer Money
- Transaction History
- Update Profile
- Change Password

---

## Database Highlights

This project is primarily designed to demonstrate **database-driven application development** using MySQL.

### Database Features

- Relational Database Design
- Primary and Foreign Key Relationships
- Data Integrity Constraints
- SQL CRUD Operations
- Transaction Record Management
- Authentication Data Storage
- Balance Management
- Account Relationship Handling
- Query Optimization
- Structured Banking Records

---

## Technologies Used

### Database

- MySQL

### Backend

- PHP

### Frontend

- HTML5
- CSS3
- JavaScript

---

## Project Structure

```
Database-Driven-Banking-System
│
├── MyBank/
│   ├── admin/
│   ├── customer/
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── index.php
│   ├── db.php
│   └── ...
│
├── database/
│   └── mybank.sql
│
├── README.md
└── .gitignore
```

---

## Database Schema

The application uses a relational MySQL database that manages:

- Administrator Information
- Customer Details
- Account Records
- Banking Transactions
- Account Balances
- Login Credentials

The complete database schema is included in:

```
database/mybank.sql
```

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/Database-Driven-Banking-System.git
```

### 2. Move the Project

Copy the project folder into your XAMPP `htdocs` directory.

### 3. Create Database

Open **phpMyAdmin**.

Create a new database:

```
mybank
```

### 4. Import Database

Import

```
database/mybank.sql
```

### 5. Configure Database Connection

Update the database credentials inside

```
MyBank/db.php
```

Example:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "mybank";
```

### 6. Start Apache & MySQL

Open XAMPP and start:

- Apache
- MySQL

### 7. Run the Application

Open your browser:

```
http://localhost/MyBank/
```

---

## Learning Outcomes

This project demonstrates practical understanding of:

- Database-Driven Web Development
- Relational Database Management
- SQL Query Implementation
- CRUD Operations
- Authentication Systems
- Banking Data Management
- PHP–MySQL Integration
- Data Validation
- Session Management
- Real-world Database Design

---

## Future Enhancements

- Email Notifications
- Interest Calculation
- Loan Management
- Fixed Deposit Module
- Online Bill Payments
- Account Statements (PDF)
- Role-Based Access Control
- Two-Factor Authentication
- REST API Integration

---

## Screenshots

Add screenshots of:

- Home Page
- Admin Dashboard
- Customer Dashboard
- Customer Management
- Transaction Module
- Database Schema

---

## Author

**Sohini Jadhav**

Computer Engineering Student

GitHub: https://github.com/Sohini-Jadhav

---

## License

This project is developed for educational and learning purposes.