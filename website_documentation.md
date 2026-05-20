# Saksham Bharti Foundation - Website Documentation

This document provides a comprehensive overview of the modules, features, and technical architecture implemented for the Saksham Bharti Foundation website.

---

## 🌐 1. Frontend Modules (User-Facing)

The frontend is designed to be highly interactive, responsive, and visually aligned with the 2024-25 Annual Report.

### 🏠 Home & About
*   **Dynamic Impact Counter**: Displays real-time metrics (25,000+ youth trained, 5,000+ placements).
*   **Vision & Mission**: Detailed sections on the 25-year legacy of the organization.
*   **Center Locator**: Information on the 4 key Delhi centers, including the newly added Nangloi center.

### 📚 Programs & Skill Development
*   **Categorized Training**: Dedicated sections for IT Training, Beauty & Lifestyle, Fashion Designing, and Soft Skills.
*   **Success Stories (Transforming Lives)**: Real-life testimonials from trainees like Archita, Gudiya, and Manisha.

### 📰 Activities & Blog
*   **Interactive Blog Archive**: High-quality cards with hover-zoom effects.
*   **Rich Content**: 5 unique professional blog posts detailing the Silver Jubilee, Job Fairs, and Sustainability.

### 🤝 Engagement Forms (Strict Validation)
*   **Volunteer Sign-up**: 
    *   Enforces **exactly 10-digit** phone numbers.
    *   Short, crisp "Area of Interest" selection based on report categories.
*   **Donation Portal**: 
    *   Secure amount entry (Digits only).
    *   Name validation (Alphabets only).
*   **Contact Form**: Modern layout with integrated FAQ section.

### 🤖 Smart Chatbot (Saksham Assistant)
*   **Lead Capture**: Automatically asks for contact details if it can't answer a query and saves it to the admin portal.
*   **Conversational Intelligence**: Handles greetings, gratitudes, and specific organizational keywords (e.g., "Nangloi", "Refund").

---

## 🛠️ 2. Admin Portal (Backend Management)

A professional "Command Center" for administrators to manage organization data securely.

### 📊 Dashboard Overview
*   **Key KPI Cards**: Real-time counts of Total Donations, Registered Volunteers, and Contact Messages.
*   **Quick Links**: Interactive cards with hover-lift effects for rapid navigation.

### ✍️ Activities/Blog Management (CRUD)
*   **Full CRUD**: Create, Read, Update, and Delete activities.
*   **Image Handling**: Secure upload and standardized path management for blog covers.

### 💰 Donations Management
*   **Centralized Ledger**: View every donation with donor names, amounts, and messages.

### 👥 Volunteer Network
*   **Database Access**: View all signed-up volunteers, their contact info, and specific interests for targeted outreach.

### 📩 Inquiry Management
*   **Resolution Tracking**: Ability to mark messages as **"Pending"** or **"Resolved"** to ensure no query is missed.
*   **Delete/Cleanup**: Management of spam or old inquiries.

### ⚙️ Account Settings
*   **Security Portal**: Admins can securely update their passwords using industry-standard hashing.

---

## 🔒 3. Sec    `urity & Technical Stack

### Technical Stack
*   **Core**: PHP 8.x with PDO (MySQL) for secure database interactions.
*   **Styling**: Bootstrap 5.3, Custom CSS3 with modern glassmorphism and animations.
*   **Icons**: FontAwesome 6.4.
*   **Scripting**: Vanilla JavaScript for the Chatbot and UI interactions.

### Security Implementations
*   **XSS Protection**: All user inputs are sanitized using custom PHP functions.
*   **CSRF Protection**: Token-based security on all forms to prevent cross-site request forgery.
*   **Input Validation**: Strict Regex patterns (HTML5 & PHP) for Names (Alphabets) and Phone Numbers (10 Digits).
*   **Session Management**: Secure admin sessions with automated timeouts.

---

## 📈 4. Database Architecture
The system operates on the `saksham_db` with the following key tables:
*   `activities`: Blog content and metadata.
*   `donations`: Financial records and donor info.
*   `volunteers`: Member network data.
*   `contacts`: Public inquiries and chatbot leads.
*   `admins`: Encrypted administrative credentials.

---
**Status**: Feature Complete & Production Ready.
**Last Updated**: May 14, 2026
