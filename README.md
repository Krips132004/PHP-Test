# 🛒 PHP Checkout Test Project

This project is a **multi-page checkout process** built with plain PHP, MySQL, and CSS (no frameworks).  
It was created as part of a timed PHP test.

---

## 📌 Features
- Multi-step checkout form:
  - **Page 1:** Collect customer details (First Name, Last Name, Address, City, State, Phone, Email)
  - **Page 2:** Collect payment details (Card Type, Card Number, Expiration Date, CVV)
  - **Page 3:** Review & confirm all entered details
- Saves customer and payment data into **MySQL database**
- Styled to match the look & feel of [Mass Garage Doors Expert](https://www.massgaragedoorsexpert.com/)
- Responsive layout with basic CSS for a clean and simple UI

---

## 🗄️ Database Schema
```sql
CREATE TABLE IF NOT EXISTS `payment_details` (
  `id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `card_type` tinyint(1) NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `card_exp_date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `customer_details` (
  `id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `first_name` char(25) NOT NULL,
  `last_name` char(25) NOT NULL,
  `address` char(100) NOT NULL,
  `city` char(50) NOT NULL,
  `state` char(2) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);


🚀 Installation

Clone the repository:

git clone https://github.com/your-username/php-checkout.git
cd php-checkout


Import the database:

mysql -u root -p < dump.sql


Update database credentials in db.php:

$dbHost = '127.0.0.1';
$dbName = 'php_checkout';
$dbUser = 'root';
$dbPass = 'your_password';


Start a local PHP server:

php -S 127.0.0.1:8000 -t public


Open in browser:
👉 http://127.0.0.1:8000/page1.php

📷 Screenshots

(Add screenshots of each checkout step here if available)
Example:

1.png→ Customer Info

2.png → Payment Info

3.png → Review & Confirm

4.png → Submit

Data-Base-1.png → Database Show Name

Data-Base-2.png → Database Show Card Info.

📝 Notes

CVV is collected but not stored in the database (for security/PCI compliance).

Phone number column updated to VARCHAR(15) to avoid integer overflow.

Basic error reporting enabled for debugging.

📧 Submission Notes

Approach: Simple plain PHP multi-page form + PDO insertions into MySQL.

Why this approach: Direct, lightweight, no frameworks, matches test requirements.

Improvements if more time: Add validation, sanitization, and error handling; encrypt card details; improve styling further.

👨‍💻 Author



