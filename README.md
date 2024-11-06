# Prerequisites

- Docker must be installed on your system.
- Composer should be installed to manage dependencies.

## Installation Steps

### 1. Clone the Repository

Clone the repository to your local machine:

### 2. Start Docker

```bash
git clone <repository_url>
cd <repository_folder>

docker-compose up -d
cd wordpress
docker-compose exec wordpress composer install

### 3. Open WordPress in Your Browser
Now that Docker is running, open your browser and go to the WordPress installation URL (e.g., http://localhost:8000).

Complete the registration and setup process for WordPress.
Log in to the WordPress dashboard.

### 4. Activate the Plugins
After logging into the WordPress dashboard:

Navigate to Plugins > Installed Plugins.
Activate the Page View Tracker plugin.
Activate the Video Playback Tracker plugin.