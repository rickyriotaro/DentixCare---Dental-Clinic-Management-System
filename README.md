# 🦷 DentixCare - Dental Clinic Management System

Modern web-based clinic management system for dental practices with integrated FHIR API support.

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php)
![FHIR](https://img.shields.io/badge/FHIR-R4-0052CC?style=flat)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📋 Overview

**DentixCare** is a comprehensive dental clinic management system built with Laravel, designed to streamline clinic operations, patient management, and medical record keeping. The system features a professional FHIR API implementation for healthcare data interoperability.

### 🌟 Key Features

- **Patient Management** - Complete patient registration and profile management
- **Medical Records** - Digital medical record system with auto-fill from previous visits
- **Appointment Scheduling** - Manage patient appointments with approval workflow
- **FHIR API Explorer** - Postman-style interface for testing FHIR endpoints
- **Visit Reports** - Generate and export patient visit reports
- **Doctor Portal** - Dedicated portal for healthcare providers
- **Notification System** - Broadcast announcements to patients
- **Role-Based Access** - Admin and Doctor roles with specific permissions

## 🚀 Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates, Vanilla JavaScript
- **Database**: MySQL
- **API Standard**: HL7 FHIR R4
- **Styling**: Custom CSS with pink theme

## 📦 Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7+
- Node.js & NPM (optional)

### Setup Steps

1. **Clone the repository**

```bash
git clone https://github.com/yourusername/dentixcare.git
cd dentixcare
```

2. **Install dependencies**

```bash
composer install
```

3. **Environment configuration**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**

```bash
# Configure database in .env file
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate --seed
```

5. **Start development server**

```bash
php artisan serve
```

Access the application at `http://localhost:8000`

### Default Credentials

**Admin:**

- Email: `admin@dentix.com`
- Password: `admin123`

**Doctor:**

- Email: `dokter@dentix.com`
- Password: `dokter123`

## 🏥 Core Features

### 1. Patient Management

- Patient registration with complete demographics
- Profile editing and management
- Search and filter capabilities

### 2. Medical Records System

- Digital medical record keeping
- **Auto-fill feature**: Automatically populates allergy and medical history from previous visits
- Support for diagnosis, treatment plans, and prescriptions
- Comprehensive patient medical history

### 3. FHIR API Integration

- **FHIR Explorer**: Postman-style interface with:
    - HTTP method selector (GET, POST, PUT, PATCH, DELETE)
    - Request parameters builder
    - Headers editor
    - JSON body editor
    - Response viewer with syntax highlighting
- RESTful FHIR R4 compliant endpoints
- Resources supported: Patient, Appointment, Condition, Procedure

### 4. Appointment Management

- Online appointment booking
- Approval/rejection workflow
- Appointment history tracking
- Status management

### 5. Reporting System

- Patient visit reports with customizable filters
- Date range filtering
- Patient name search
- Export functionality

## 🔌 FHIR API Endpoints

### Base URL

```
/api/fhir
```

### Available Resources

| Endpoint                         | Method | Description                 |
| -------------------------------- | ------ | --------------------------- |
| `/fhir/metadata`                 | GET    | Server capability statement |
| `/fhir/Patient`                  | GET    | List all patients           |
| `/fhir/Patient/{id}`             | GET    | Get specific patient        |
| `/fhir/Patient/{id}/$everything` | GET    | Get complete patient data   |
| `/fhir/Appointment`              | GET    | List appointments           |
| `/fhir/Condition`                | GET    | List conditions             |
| `/fhir/Procedure`                | GET    | List procedures             |

### Example Request

```bash
curl -X GET "https://your-domain.com/api/fhir/Patient/1" \
  -H "Accept: application/fhir+json"
```

## 🎨 User Interface

- **Modern Design**: Clean, professional interface with pink accent theme
- **Responsive**: Mobile-friendly layouts
- **Intuitive Navigation**: Role-based menu system
- **Data Tables**: Searchable, sortable patient lists with pagination

## 👥 User Roles

### Admin

- Full system access
- Patient management
- Medical record management
- Doctor management
- Report generation
- System notifications
- FHIR API testing

### Doctor (Dokter)

- View assigned appointments
- Access patient medical records
- Create treatment plans
- Manage follow-up schedules
- View patient history

## 📱 Key Modules

1. **Dashboard** - Overview of clinic statistics
2. **Data Pasien** - Patient database management
3. **Pendaftaran** - New patient registration
4. **Janji Temu** - Appointment scheduling
5. **Data Rekam Medis** - Medical records with auto-fill
6. **Pemberitahuan** - Notification broadcast system
7. **Laporan Kunjungan** - Visit reports with simplified filters
8. **Kelola Dokter** - Doctor management (Admin only)
9. **FHIR Explorer** - API testing interface

## 🔐 Security Features

- Laravel authentication system
- Role-based access control (RBAC)
- CSRF protection
- Password hashing
- Middleware authorization

## 🛠 Development

### File Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   │   └── api/         # FHIR API controllers
│   │   └── Resources/       # FHIR resource transformers
│   └── Models/              # Eloquent models
├── resources/
│   └── views/               # Blade templates
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
└── database/
    └── migrations/          # Database migrations
```

### Custom Features

**Auto-fill Medical History:**

- Located in: `resources/views/rekam_medis/create.blade.php`
- API endpoint: `/api/rekam-medis/latest/{patientId}`
- Automatically fetches and populates allergy and disease history

**FHIR Explorer:**

- Located in: `resources/views/fhir/explorer.blade.php`
- Full-featured API testing tool
- Similar to Postman but integrated in the system

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Author

Developed as part of undergraduate thesis project.

## 🙏 Acknowledgments

- Laravel Framework
- HL7 FHIR Standard
- Bootstrap & Font Awesome

## 📞 Support

For issues and questions, please open an issue on GitHub.

---

**DentixCare** - Simplifying Dental Clinic Management 🦷✨
