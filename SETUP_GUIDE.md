# VETech System - Quick Setup Guide

## System Overview

VETech is a complete veterinary management system with the following modules:

1. **Dashboard** - Statistics and overview
2. **Customers** - Customer/pet owner management
3. **Pets** - Pet registration and profiles
4. **Collaborators** - Private clinic partnerships (Admin only)
5. **Bookings** - Appointment scheduling with queue system
6. **Tags** - QR code generation for pet identification

## Current Status

✅ Database configured (MySQL - database: vetech)
✅ All migrations completed successfully
✅ Authentication system installed
✅ Admin user created
✅ Development server running at http://127.0.0.1:8000

## Login Information

**Admin Account:**
- Email: admin@vetech.com
- Password: password

## Quick Start Guide

### Step 1: Login
1. Open http://127.0.0.1:8000
2. Login with admin credentials above

### Step 2: Add Your First Customer
1. Click **Customers** in the sidebar
2. Click **Add New Customer**
3. Fill in the form:
   - Name (required)
   - IC Number (required)
   - Phone (required)
   - Email (optional)
   - Address (optional)
4. Click **Save Customer**

### Step 3: Register a Pet
1. Click **Pets** in the sidebar
2. Click **Add New Pet**
3. Fill in the form:
   - Select the customer/owner
   - Pet name (required)
   - Species (e.g., Dog, Cat) (required)
   - Breed (optional)
   - Gender (required)
   - Date of birth (optional)
   - Weight (optional)
   - Other details
4. Click **Save Pet**

### Step 4: Add Treatment Record
1. Go to the pet's profile page
2. Click **Add Treatment** button
3. Fill in treatment details:
   - Treatment date
   - Disease (if any)
   - Diagnosis (required)
   - Treatment given (required)
   - Medication (optional)
   - Cost (optional)
4. Click **Save Treatment**

### Step 5: Generate QR Tag
1. Click **Tags & QR Codes** in the sidebar
2. Click **Generate New Tag**
3. Select a pet (only pets without tags)
4. Set issue date
5. Click **Generate Tag**
6. Click **Download QR Code** to get the PNG file
7. Print and attach to pet collar

### Step 6: Scan QR Code
1. Scan the QR code with any phone camera
2. View pet information and treatment history
3. **No login required** - public access for emergencies

### Step 7: Create Booking
1. Click **Bookings** in the sidebar
2. Click **New Booking**
3. Fill in booking details:
   - Select customer and pet
   - Booking date and time
   - Service type (e.g., Vaccination, Checkup)
   - Reason (optional)
4. Queue number is auto-generated
5. Click **Save Booking**

### Step 8: Add Collaborator (Admin Only)
1. Click **Collaborators** in the sidebar
2. Click **Add Collaborator**
3. Fill in clinic information:
   - Contact person name
   - Clinic name
   - Email
   - Phone
   - Address
   - Registration number
   - Status
4. Optionally create a login account for them
5. Click **Save Collaborator**

## Key Features

### Customer & Pet Management
- One customer can have multiple pets
- Complete pet profiles with medical history
- Easy access to all pets from customer profile

### Treatment Records
- Track all treatments with detailed information
- Distinguish between government and collaborator treatments
- View chronological treatment history

### QR Code System
- Unique code for each pet
- Downloadable for printing
- Public scan page for emergency access
- Shows full pet info and treatment history

### Booking System
- Automatic queue numbering per day
- Status tracking (pending, confirmed, completed, cancelled)
- Filter by date and status
- Service type categorization

### Collaborator System
- Register partner clinics
- Create login accounts for collaborators
- Collaborators can add treatment records
- Track which clinic performed treatments

## User Roles

**Admin:**
- Full system access
- Can manage all modules including collaborators
- Can view all treatments from both government and collaborators

**Collaborator:**
- Can login to add treatment records
- Limited to treatment-related features
- Cannot manage other collaborators

## Important Notes

1. **QR Codes**: Stored in `storage/app/public/qrcodes/`
2. **Tag Codes**: Format is `VET-XXXXXXXX` (unique)
3. **Bookings**: Queue numbers reset daily
4. **Scanning**: QR scan page works without login for emergency access

## Troubleshooting

### If the server stops:
```bash
php artisan serve
```

### If you need to reset the database:
```bash
php artisan migrate:fresh --seed
```

### If QR codes don't display:
Check that storage link exists:
```bash
php artisan storage:link
```

## Next Steps

1. Add more customers and their pets
2. Record some treatments
3. Generate QR tags for active pets
4. Create bookings for upcoming appointments
5. Add collaborating clinics if needed

---

**System developed for Sandakan Veterinar Department**
