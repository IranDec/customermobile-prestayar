# customermobile-prestayar
CustomerMobile Module for PrestaShop
A PrestaShop module that automatically adds a customer's ID and mobile number to the psylogin_customers_mobile table when a new address is added. This module ensures no duplicate entries are created by checking for existing customer records.
Overview
The CustomerMobile module is designed for PrestaShop 1.7.8.11. It leverages the actionObjectAddressAddAfter hook to capture customer data (ID and mobile number) during address creation and stores it in a custom table (psylogin_customers_mobile). The module includes security measures to prevent SQL injection and ensures data integrity by avoiding duplicate entries.
Designer: Mohammad BabaeiWebsite: AdsChi.com
Prerequisites
Before installing the module, ensure the following requirements are met:

PrestaShop version 1.7.8.11 (compatible with 1.7.x versions).
The psylogin_customers_mobile table must exist in your PrestaShop database with the following structure:

CREATE TABLE IF NOT EXISTS `ps_psylogin_customers_mobile` (
    `mobile_id` INT AUTO_INCREMENT PRIMARY KEY,
    `mobile_id_customer` INT NOT NULL UNIQUE,
    `mobile_number` VARCHAR(20) NOT NULL,
    `mobile_valid` TINYINT(1) DEFAULT 1,
    `mobile_email` VARCHAR(255) DEFAULT '',
    `mobile_created` DATETIME NOT NULL,
    `mobile_updated` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


The customer must provide a mobile number (phone_mobile) when adding a new address.

Installation
Follow these steps to install the CustomerMobile module:

Download the Module:

Clone or download this repository to your local machine.


Copy to PrestaShop Modules Directory:

Copy the customermobile folder to the modules/ directory of your PrestaShop installation.


Install the Module:

Log in to your PrestaShop Back Office.
Navigate to Modules > Module Manager.
Search for "Customer Mobile Module" and click Install.


Verify Installation:

Ensure the module is listed under installed modules and is enabled.



Usage
Once installed, the module works automatically:

When a customer (or admin) adds a new address, the module checks if the phone_mobile field is filled.
It retrieves the customer's id_customer and phone_mobile from the address.
The module then checks if the customer already exists in the psylogin_customers_mobile table using mobile_id_customer.
If the customer does not exist, a new record is added with the following fields:
mobile_id_customer: Customer ID.
mobile_number: Mobile number from the address.
mobile_valid: Set to 1 (default).
mobile_email: Empty (default).
mobile_created: Current timestamp.
mobile_updated: Current timestamp.



Testing

Add a new address via the Front Office (as a customer) or Back Office (as an admin).
Check the psylogin_customers_mobile table in your database to confirm the new record.

Considerations

Table Requirement: The module assumes the psylogin_customers_mobile table exists. If it doesn’t, create it using the SQL script provided in the Prerequisites section.
Duplicate Prevention: The module only adds a record if the customer does not already exist in the table.
Mobile Number Source: The mobile number is taken from the phone_mobile field of the address. If this field is empty, no record will be added.
Security: The module uses pSQL() and type casting to prevent SQL injection.
Updates: If you need to update mobile numbers when addresses are edited, consider adding support for the actionObjectAddressUpdateAfter hook.

Support
For issues, questions, or contributions:

Designer: Mohammad Babaei
Website: AdsChi.com
Email: Please contact via the website.

License
This project is licensed under the MIT License - see the LICENSE file for details.
