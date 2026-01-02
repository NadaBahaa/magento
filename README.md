# Magento 2 Development Environment

This is a Magento 2 development project using Docker. It includes custom modules for managing kitchen galleries, categories, and simple entities with full admin panel and GraphQL API support.

## 🚀 Quick Start

### First Time Setup

If this is your first time setting up the project, you'll need to install Magento:

```bash
# Start Docker containers
bin/start

# Download and install Magento (if not already installed)
bin/download

# Run the setup script
bin/setup
```

The setup script will:
- Install Magento with default settings
- Set up the database
- Configure SSL certificates
- Enable developer mode

**Default Admin Credentials** (check `bin/setup-install` for actual values):
- URL: `https://magento.test/admin/`
- Username: Check `env/magento.env` file
- Password: Check `env/magento.env` file

### Daily Usage

Once the project is set up, here's what you need to know:

#### Starting the Project

```bash
# Start all Docker containers
bin/start

# Check if containers are running
bin/status
```

#### Stopping the Project

```bash
# Stop all containers
bin/stop

# Stop and remove everything (including volumes)
bin/stopall
```

#### Accessing the Site

- **Frontend**: `https://magento.test/`
- **Admin Panel**: `https://magento.test/admin/`
- **Database**: `localhost:3306` (credentials in `env/db.env`)

## 📋 Common Commands

All commands should be run from the project root directory. The `bin/` folder contains helper scripts that run commands inside the Docker container.

### Magento Commands

```bash
# Run any Magento CLI command
bin/magento <command>

# Examples:
bin/magento cache:flush              # Clear cache
bin/magento setup:upgrade            # Upgrade database schema
bin/magento module:enable Vendor_KitchenGallery  # Enable a module
bin/magento indexer:reindex         # Reindex data
```

### Development Commands

```bash
# Access the container's command line
bin/cli <command>

# Examples:
bin/cli composer install            # Install PHP dependencies
bin/cli php bin/magento cache:flush # Run Magento commands
bin/cli bash                        # Open interactive shell

# Access MySQL database
bin/mysql                           # Open MySQL CLI

# View logs
bin/log                             # View container logs
```

### File Permissions

```bash
# Fix file ownership (run after copying files)
bin/fixowns

# Fix file permissions
bin/fixperms
```

### Cache Management

```bash
# Clear all cache
bin/magento cache:flush

# Or use the dedicated script
bin/cache-clean
```

## 📁 Project Structure

```
magento/
├── bin/                          # Helper scripts (use these instead of direct commands)
│   ├── magento                   # Run Magento CLI commands
│   ├── cli                       # Run commands in container
│   ├── start                     # Start Docker containers
│   ├── stop                      # Stop Docker containers
│   └── ...                       # Many more helper scripts
│
├── src/                          # Magento source code (mounted in container)
│   ├── app/
│   │   └── code/
│   │       └── Vendor/           # Custom modules
│   │           ├── KitchenGallery/  # Kitchen gallery management module
│   │
│   ├── pub/                      # Web root (public files)
│   ├── var/                      # Generated files, logs, cache
│   └── vendor/                   # Composer dependencies
│
├── env/                          # Environment configuration files
│   ├── db.env                    # Database credentials
│   ├── magento.env               # Magento admin credentials
│   └── phpfpm.env                # PHP configuration
│
├── compose.yaml                  # Docker Compose configuration
└── README.md                     # This file
```

## 🧩 Custom Modules

This project includes three custom Magento modules:

### 1. KitchenGallery Module

A complete kitchen gallery management system with:
- **Kitchens**: Full CRUD with image upload, WYSIWYG editor, categories
- **Categories**: Category management for organizing kitchens
- **Gallery**: Gallery view (coming soon)

**Admin Access:**
- Menu: **KitchenGallery** → **Kitchens** or **Category**
- URL: `https://magento.test/admin/kitchengallery/kitchen/index`

**Features:**
- Admin grid with filters and search
- Image upload and thumbnails
- Category dropdown selection
- Status management (Enabled/Disabled)

### 2. SimpleEntity Module

A basic CRUD entity module demonstrating Magento 2 module development:
- Admin grid and form
- Status management
- GraphQL API

**Admin Access:**
- Menu: **Content** → **Simple Entity**
- URL: `https://magento.test/admin/simpleentity/entity/index`

### 3. SampleItem Module

A sample module for reference and testing.

## 🔧 Module Development

### Enabling a Module

```bash
bin/magento module:enable Vendor_ModuleName
bin/magento setup:upgrade
bin/magento cache:flush
```

### Disabling a Module

```bash
bin/magento module:disable Vendor_ModuleName
bin/magento setup:upgrade
bin/magento cache:flush
```

### After Making Changes

When you modify module files, you typically need to:

```bash
# Clear generated code (if you changed DI configuration)
bin/cli rm -rf generated/code/Vendor/ModuleName/

# Clear cache
bin/magento cache:flush

# Upgrade database (if you changed db_schema.xml)
bin/magento setup:upgrade
```

## 🐳 Docker Services

The project uses these Docker services:

- **app** (Nginx): Web server on ports 80 and 443
- **phpfpm**: PHP-FPM service running PHP 8.3
- **db** (MariaDB): Database on port 3306
- **redis**: Cache and session storage on port 6379

## 🔍 Troubleshooting

### Containers Won't Start

```bash
# Check Docker is running
docker ps

# View container logs
bin/log

# Restart everything
bin/stopall
bin/start
```

### Cache Issues

```bash
# Clear all cache
bin/magento cache:flush

# Clear generated code
bin/cli rm -rf generated/*
bin/cli rm -rf var/view_preprocessed/*
```

### Database Connection Issues

Check the database credentials in `env/db.env` and ensure the database container is running:

```bash
bin/status
bin/mysql  # Test database connection
```

### Module Not Showing Up

```bash
# Enable the module
bin/magento module:enable Vendor_ModuleName

# Upgrade database
bin/magento setup:upgrade

# Clear cache
bin/magento cache:flush

# Recompile (if in production mode)
bin/magento setup:di:compile
```

## 📚 Additional Resources

- **Magento Documentation**: https://developer.adobe.com/commerce/docs/
- **Docker Setup**: Based on [Mark Shust's Docker Configuration](https://github.com/markshust/docker-magento)
- **Module Development**: See individual module README files in `src/app/code/Vendor/ModuleName/`


---

**Happy Coding! 🎉**
