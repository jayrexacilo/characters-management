# CodeIgniter 4 Project

This is a web application built using the CodeIgniter 4 PHP framework.

## Quick Start

1. **Copy env file**  
   Set up the env file:
   ```bash
   cp env .env
   
2. **Update the .env file**  
   Please update the database.default variables based on your local machine mysql database setup:
   (please see email smpt credential for testing)
   
3. **Composer Install**  
   ```bash
   composer install
   
4. **Run Migrations**  
   Set up the database tables by running:
   ```bash
   php spark migrate
   
5. **Start the Development Server**  
   Launch the app locally:
   ```bash
   php spark serve
   
6. **Open your browser and visit**  
   ```bash
   http://localhost:8080
