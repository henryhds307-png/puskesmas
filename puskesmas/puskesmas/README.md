# Puskesmas Patient Registration System

## Overview
This project is a web-based application for managing patient registrations at UPTD Puskesmas Perumnas Batu 6. It provides a user-friendly interface for patients to register online and allows healthcare administrators to manage patient data efficiently.

## Project Structure
The project is organized into several directories and files:

- **public/**: Contains the front-end files accessible to users.
  - **pendaftaranold.php**: The old registration form for patients.
  - **pendaftaran.php**: The new registration form for patients.
  - **index.php**: The main entry point of the application.
  - **css/**: Contains stylesheets for the application.
    - **style.css**: CSS styles for layout and appearance.
  - **js/**: Contains JavaScript files for client-side functionality.
    - **main.js**: JavaScript code for enhancing user interaction.
  - **template_olah_data/**: Directory for additional templates or resources for data processing.

- **src/**: Contains the back-end logic and database connection.
  - **db/**: Contains database connection files.
    - **koneksi.php**: Establishes a connection to the MySQL database.
  - **controllers/**: Contains controller files for managing application logic.
    - **PendaftaranController.php**: Manages patient registration logic.
  - **views/**: Contains view files for rendering HTML.
    - **pendaftaran.php**: Renders the patient registration form.

- **config/**: Contains configuration files.
  - **config.php**: Configuration settings for the application.

- **composer.json**: Composer configuration file listing project dependencies.

- **.gitignore**: Specifies files and directories to be ignored by Git.

## Setup Instructions
1. **Clone the Repository**: 
   ```
   git clone <repository-url>
   ```

2. **Install Dependencies**: 
   Navigate to the project directory and run:
   ```
   composer install
   ```

3. **Configure Database Connection**: 
   Update the database connection settings in `src/db/koneksi.php` with your database credentials.

4. **Run the Application**: 
   You can use a local server like XAMPP or MAMP to run the application. Place the project folder in the server's root directory and access it via a web browser.

## Usage
- Navigate to the registration page to register as a new patient.
- Fill out the required information and submit the form.
- The application will handle the data and store it in the database.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.