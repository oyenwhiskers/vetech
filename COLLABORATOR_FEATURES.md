# Collaborator Treatment Management System

## Overview
Collaborators can scan pet QR tags issued by Sandakan Veterinar and manage treatment records with full audit trail capabilities.

## Features Implemented

### 1. QR Tag Scanning
- **Route**: `/collaborator/scanner`
- Collaborators can scan pet tags or enter tag codes manually
- Only active tags from Sandakan Veterinar can be scanned
- Displays pet information, owner details, and full treatment history

### 2. Treatment Record Management

#### View All Treatments
- **Route**: `/collaborator/treatments`
- Lists all treatments created by the logged-in collaborator
- Shows both active and deleted records
- Paginated list with pet and owner information

#### Add New Treatment
- **Route**: `/collaborator/pets/{pet}/treatments/create`
- Form to add new treatment records after scanning a pet tag
- Required fields: Treatment Date, Diagnosis, Treatment Given
- Optional fields: Disease, Medication, Cost, Notes
- All records are immutable (cannot be edited after creation)

#### View Treatment Details
- **Route**: `/collaborator/treatments/{treatment}`
- Full treatment record with pet and owner information
- Shows delete status if record has been removed
- View-only mode for treatments created by other collaborators

### 3. Soft Delete System

#### Delete Own Records Only
- Collaborators can only delete treatments they created
- Records from other collaborators are **view-only**
- Deletion is **soft delete** - records remain in database with audit trail

#### Deleted Records Log
- **Route**: `/collaborator/treatments/deleted-log`
- Audit log of all deleted treatment records
- Shows who deleted each record and when
- Maintains full accountability and traceability

### 4. Authorization & Permissions

#### What Collaborators CAN Do:
- ✅ Scan any active Sandakan Veterinar pet tag
- ✅ View all treatment records for any pet
- ✅ Add new treatment records to any scanned pet
- ✅ Delete **only their own** treatment records
- ✅ View deleted records log for audit

#### What Collaborators CANNOT Do:
- ❌ Edit any treatment record (immutable after creation)
- ❌ Delete treatments created by other collaborators
- ❌ Permanently delete records (soft delete only)
- ❌ Access admin functions (customers, collaborators, tags management)

## Database Changes

### Migration: `add_soft_deletes_to_treatments_table`
- Added `deleted_at` timestamp column (soft delete)
- Added `deleted_by` foreign key to track who deleted the record
- Maintains referential integrity with users table

### Treatment Model Updates
- Added `SoftDeletes` trait
- New relationship: `deleter()` - user who deleted the record
- Helper methods:
  - `canBeDeletedBy($user)` - checks if user can delete
  - `canBeViewedBy($user)` - checks if user can view (always true)

## Navigation Updates

### Collaborator Sidebar Menu
- Dashboard
- **Scan Pet Tag** - QR scanner page
- **My Treatments** - List of all treatments
- **Deleted Log** - Audit trail of deleted records

### Admin Sidebar Menu (unchanged)
- Dashboard
- Customers & Pets
- Collaborators (admin only)
- Bookings
- Tags & QR Codes

## User Flow

### For Collaborators:
1. **Scan Tag**: Go to Scanner → Scan QR code or enter tag code
2. **View Pet**: See pet details, owner info, and treatment history
3. **Add Treatment**: Click "Add Treatment" → Fill form → Submit
4. **Manage Records**: View all treatments → Delete own records if needed
5. **Audit Trail**: Check deleted log to see all removed records

### Audit & Compliance:
- Every treatment entry is timestamped with creator information
- Deleted records show deletion timestamp and deleting user
- All records remain in system for audit purposes
- Full traceability of who did what and when

## Security Features
- Collaborators cannot access admin routes
- Treatment deletion restricted to record creator
- Soft deletes prevent data loss
- Full audit trail for compliance
- View-only access to other collaborators' records

## Testing Checklist
- [ ] Collaborator can log in and access scanner
- [ ] Scanner accepts valid tag codes
- [ ] Pet information displays correctly after scan
- [ ] Treatment form saves correctly
- [ ] Only own treatments show delete button
- [ ] Soft delete moves record to deleted log
- [ ] Deleted records display deletion information
- [ ] Other collaborators' records are view-only
- [ ] Navigation menu shows correct items for collaborator role
