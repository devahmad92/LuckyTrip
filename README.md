# Airport Management Application

## Overview
This application is a backend service for managing airport data. It allows for creating, retrieving, updating, and deleting airport records, along with managing translations in different languages.

## Technology Stack
- **Backend Framework**: Laravel Lumen v10
- **Database**: MySQL 8.0
- **Web Server**: Nginx (using latest image)
- **Containerization**: Docker and Docker Compose

## Setup and Installation

### Prerequisites
- Docker and Docker Compose installed on your machine.

### Steps to Run
1. **Clone the Repository**: 
   Clone the project repository to your local machine.

2. **Environment File**:
   Run the following command to copy the `.env.example` file to a new `.env` file:
   ```
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials and other environment variables as needed.

3. **Install Dependencies**:
   Run the following command to install PHP dependencies through Composer:
   ```
   docker-compose run --rm app composer install
   ```

4. **Build and Run with Docker**:
   Navigate to the project directory and run the following command to build and start the containers:
   ```
   docker-compose up -d
   ```

5. **Database Migrations**:
   After the containers are up, run the following command to execute the database migrations:
   ```
   docker-compose exec app php artisan migrate
   ```

6. **Database Seeding**:
   Optionally, if you have seed data available, run the following command to populate the database with initial data:
   ```
   docker-compose exec app php artisan db:seed
   ```

7. **Access the Application**:
   The application will be accessible at `http://localhost:8080`.

## API Endpoints
- `GET /`: Returns the application version.
- `GET /docs`: Generates and returns the OpenAPI documentation.
- `GET /airports/{id}`: Retrieves a specific airport by ID.
- `POST /airports`: Creates a new airport.
- `PUT /airports/{id}`: Updates an existing airport by ID.
- `DELETE /airports/{id}`: Deletes an airport by ID.
- `GET /airports`: Lists all airports.

## Swagger API Documentation
Access the Swagger UI for the API documentation at `http://localhost:8080/api/documentation`. This provides an interactive interface to test and explore the API endpoints.

## Database Schema
### Models
1. **Airport**: 
   - Attributes: `iata_code`, `latitude`, `longitude`, `terms_conditions`.
   - Relationships: Has many `AirportTranslations`.

2. **AirportTranslation**: 
   - Attributes: `airport_id`, `language_code`, `name`, `description`.
   - Relationships: Belongs to `Airport`.

## Testing
- Run unit tests using the following command:
  ```
  docker-compose exec app php vendor/bin/phpunit
  ```

Unit tests are available to ensure the functionality of the application components and can be expanded as needed.

