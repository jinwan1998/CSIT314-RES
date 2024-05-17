<h1>CSIT314 Real Estate System (RES)</h1>

<h2>Project Overview</h2>
This repository contains the source code for the Real Estate System (RES) project for the CSIT314 Software Development Methodologies course at the University of Wollongong. The system is designed to manage real estate transactions, including functionalities for system admins, real estate agents, sellers, and buyers.
<br><br>
Features <be>
<li>Admin Management: Manage system admins, real estate agents, sellers, and buyers.</li> <br>
<li>Property Listings: Add, view, and manage property listings.</li> <br>
<li>Buyer Features: Search, view, and shortlist properties.</li> <br>
<li>Seller Features: Track property views and shortlists.</li> <br>
<li>Mortgage Calculation: Calculate mortgage options for buyers.</li> <br>
<li>Agent Reviews: Review and rate real estate agents.</li> <br>

<h2>Tech Stack</h2>
Frontend: HTML, CSS <br>
Backend: PHP<br>
Database: MySQL<br>

<h2>Project Structure</h2>
admin/: Contains files related to admin functionalities. <br>
agent/: Contains files related to real estate agent functionalities. <br>
buyer/: Contains files related to buyer functionalities. <br>
seller/: Contains files related to seller functionalities. <br>
class_property.php: Defines the property class. <br>
class_user.php: Defines the user class. <br>
dbconnect.php: Database connection script. <br>
index.php: Main entry point of the application. <br>
LoginController.php: Handles login functionalities. <br>
RegistrationController.php: Handles user registration functionalities. <br>
RES.sql: SQL script to set up the database schema. <br>

<h2>Installation</h2>
1)Clone the repository:
git clone https://github.com/Levaote/CSIT314-RES.git <br><br>

2)Navigate to the project directory:
cd CSIT314-RES

3)Set up the database using the RES.sql script.

4)Configure the database connection in dbconnect.php.

5)Run the application on a local server (e.g., using XAMPP or WAMP).

<h2>Usage</h2>
Access the application via http://localhost/CSIT314-RES/.
Login with admin, agent, buyer, or seller credentials to access respective functionalities.
