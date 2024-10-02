
# 🛒 **Supplement Store Website** 🌱

Welcome to the **Supplement Store** web application repository! This project aims to create an intuitive, fully-functional e-commerce platform where customers can browse, purchase, and learn about health supplements. The website also includes specialized features such as personalized product recommendations, expert nutritional advice, and educational content.

## 📋 **Table of Contents**
- [Features](#features)
- [Technologies](#technologies)
- [Installation](#installation)
- [Usage](#usage)
- [Folder Structure](#folder-structure)
- [Screenshots](#screenshots)
- [Contributing](#contributing)

## ✨ **Features**

- **Customer Roles:**
  - **Unregistered Users** can browse products, view product details, and explore educational content.
  - **Registered Users** can add products to the cart, checkout, and leave reviews.
  - **Admin Panel** for managing users, products, orders, and content.
  - **Nutritional Experts** can provide personalized advice and create educational material.

- **Key Functionality:**
  - Product recommendations based on user preferences and purchase history.
  - Secure checkout process with payment gateways.
  - Customer reviews and ratings.
  - Promotions and discount management.
  - Integration with live chat support and customer dispute management.

- **Dynamic Content:**
  - Personalized emails to all registered customers.
  - Educational content (articles, guides) by experts.
  - User profiles, including subscription management.

## 🛠 **Technologies**

- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend:** PHP, MySQL, Python
- **Database:** MySQL
- **Version Control:** Git, GitHub
- **Others:** AJAX, JSON, REST APIs

## 🚀 **Installation**

1. **Clone the repository:**
   ```bash
   git clone https://github.com/HimanM/Suppliment-Store.git
   ```
2. **Navigate to the project directory:**
   ```bash
   cd supplement-store
   ```
3. **Set up the MySQL Database:**
   - Import the SQL schema located in `/SQL_Query/supplement_store_sql.sql` into your MySQL server.
   - Edit the `/PHP/db_config.php` file with your database credentials.

4. **Install necessary dependencies and run the python email script:**
   ```bash
   python backend_api.py   # This will install the necessary dependencies and libraries
                            and continue running 
   ```

5. **Configure your environment:**
   - Update `.env` or `config.php` for your environment variables (such as payment gateways, email services, etc.).

6. **Run the server:**
   ```bash
   php -S localhost:8000
   ```

## 🎯 **Usage**

Once the installation is complete:

- Access the website at `http://localhost:8000`.
- Sign up as a registered customer to experience full functionality.
- Admin users can access the admin panel at using credentials`admin` password `12345678`.

### **For Developers:**
1. Create new branches for features:
   ```bash
   git checkout -b feature/new-feature
   ```
2. Commit changes:
   ```bash
   git commit -m "Added new feature"
   ```
3. Push changes and create a pull request.

## 📂 **Folder Structure**

```bash
├── API/                   # Python Script to handle Emails
├── CSS/                   # Custom CSS stylesheets
├── JS/                    # JavaScript and AJAX scripts
├── PHP/                   # Backend PHP scripts and APIs
│   ├── db_config.php      # Database configuration
│   └── other_php_files.php# Various backend functionality
├── images/                # Website images and assets
├── SQL_Query/             # SQL scripts for database
├── index.php              # Website landing page
├── admin_panel.php        # Admin panel for managing the site
├── ...                    # Other PHP files
└── README.md              # Project documentation
```

## 🖼️ **Screenshots**

Here are a few screenshots of the website:

- **Landing Page:**
  ![Landing Page](https://i.ibb.co/FDRMWhG/image.png)

- **Product Page:**
  ![Product Page](https://i.ibb.co/KwDM6nc/image.png)

- **Checkout:**
  ![Checkout](https://i.ibb.co/CJ8c0qX/image.png)

## 📝 **Contributing**

We welcome contributions to make the platform even better! To contribute:

1. Fork the repository.
2. Create a new feature branch:
   ```bash
   git checkout -b feature/new-feature
   ```
3. Commit your changes:
   ```bash
   git commit -m "Added a new feature"
   ```
4. Push to the branch:
   ```bash
   git push origin feature/new-feature
   ```
5. Create a new pull request.

For major changes, please open an issue first to discuss what you would like to change.

## ⚠️ **Disclaimer**
Some features, functionality, and screenshots in this project might change over time due to ongoing UI/UX improvements and new feature implementations.


---
