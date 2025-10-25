# QR Scanner Implementation Guide

## Overview
The VETech system now includes an integrated QR code scanner that allows collaborators to quickly access pet medical records using either camera scanning or manual tag number entry.

## Features Implemented

### 1. **Camera-Based QR Scanning**
- Real-time QR code scanning using device camera
- Works on mobile devices, tablets, and laptops with webcam
- Visual scanning guide with corner markers
- Automatic redirection to pet medical records
- Status messages for user feedback

### 2. **Plain Number Tag Support**
- Tag codes are now simple numbers (e.g., `1010`, `2023`, etc.)
- No prefix required (removed `VET-` prefix)
- Easy to type on mobile devices
- Compatible with QR code scanning

### 3. **Manual Entry Fallback**
- Text input for manual tag number entry
- Upper case conversion for consistency
- Mobile-optimized keyboard input

### 4. **Mobile Responsive**
- Full-width buttons on mobile
- Touch-friendly interface
- Proper camera viewport sizing
- Works in portrait and landscape modes

## Technical Implementation

### Library Used
- **html5-qrcode** v2.3.8
- Lightweight, no dependencies
- Cross-browser compatible
- Mobile-optimized

### Tag Code Format
```
Old Format: VET-00001234
New Format: 1010
```

Simple numeric codes that are:
- Easy to remember
- Quick to type
- Compatible with QR encoding

### Camera Configuration
```javascript
{
    fps: 10,                          // Scan 10 times per second
    qrbox: { width: 250, height: 250 }, // Scanning area
    aspectRatio: 1.333334              // 4:3 ratio for camera
}
```

## How It Works

### For Staff (Collaborators)

#### Option 1: Camera Scanning
1. Navigate to **Scan Pet Tag** from sidebar
2. Click **"Open Camera Scanner"** button
3. Allow camera permissions when prompted
4. Point camera at QR code on pet tag
5. System automatically reads and redirects to pet record

#### Option 2: Manual Entry
1. Navigate to **Scan Pet Tag**
2. Type tag number in the input field (e.g., `1010`)
3. Click **Search** button
4. View pet medical record

### For Administrators

#### Creating Tags
When creating a new tag in the system:
1. Use simple numeric codes (1010, 1011, 1012, etc.)
2. Generate QR code with the URL: `https://yoursite.com/collaborator/scan/1010`
3. Print QR code on pet tags
4. Issue to pet owners

## Database Schema

### Tags Table
```sql
tags
├── id (bigint, primary key)
├── pet_id (foreign key -> pets.id)
├── tag_code (varchar, unique) -- "1010", "1011", etc.
├── qr_code_path (text, nullable)
├── status (enum: active, inactive, lost)
├── issued_date (date)
├── notes (text, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)
```

## Routes

```php
Route::middleware('auth')->prefix('collaborator')->name('collaborator.')->group(function () {
    Route::get('/scanner', [CollaboratorTreatmentController::class, 'scanner'])
        ->name('scanner');
    
    Route::get('/scan/{tagCode}', [CollaboratorTreatmentController::class, 'scan'])
        ->name('scan');
});
```

## Browser Compatibility

### Camera Scanner Support
✅ Chrome (Android/Windows/Mac)
✅ Safari (iOS/Mac)
✅ Edge (Windows)
✅ Firefox (Desktop/Mobile)
✅ Samsung Internet
✅ Opera

### Requirements
- HTTPS connection (required for camera access in production)
- Camera permissions granted by user
- Modern browser (released within last 2 years)

## Security Considerations

### Camera Permissions
- Browser requests permission before accessing camera
- Permission is per-domain and remembered
- Users can revoke permissions at any time

### Tag Code Validation
- Tag codes are validated against database
- Only `active` status tags can be scanned
- 404 error if tag doesn't exist
- Access control via authentication middleware

## Troubleshooting

### Camera Won't Start
**Issue**: "Error starting camera" message
**Solutions**:
1. Check camera permissions in browser settings
2. Ensure no other app is using the camera
3. Try refreshing the page
4. Use manual entry as fallback

### QR Code Not Detected
**Issue**: Scanner running but not detecting code
**Solutions**:
1. Ensure good lighting
2. Hold steady and closer/farther from camera
3. Make sure QR code is within the scanning box
4. Verify QR code encodes correct URL format

### Mobile Performance
**Issue**: Slow or laggy on mobile
**Solutions**:
1. Close other browser tabs
2. Update browser to latest version
3. Reduce FPS in configuration (currently 10)

## Future Enhancements

### Potential Improvements
1. **Flashlight Toggle**: For scanning in low light
2. **Camera Selection**: Switch between front/rear cameras
3. **Scan History**: Cache recently scanned tags
4. **Offline Mode**: Store tag data for offline access
5. **Barcode Support**: Add 1D barcode scanning
6. **Sound Feedback**: Audio cue on successful scan
7. **Vibration**: Haptic feedback on mobile devices

### Performance Optimizations
1. Lazy load camera library
2. Implement scanning cooldown
3. Add scan confidence threshold
4. Optimize camera resolution

## Testing Checklist

### Functional Testing
- [ ] Camera opens on button click
- [ ] QR code is detected and decoded
- [ ] Redirects to correct pet record
- [ ] Manual entry works with plain numbers
- [ ] Stop camera button works
- [ ] Error messages display correctly
- [ ] Works on mobile devices
- [ ] Works on desktop with webcam

### Security Testing
- [ ] Authentication required for scanner access
- [ ] Invalid tag codes return 404
- [ ] Inactive tags are rejected
- [ ] No SQL injection vulnerabilities
- [ ] CSRF protection active

### Browser Testing
- [ ] Chrome (latest)
- [ ] Safari (latest)
- [ ] Firefox (latest)
- [ ] Edge (latest)
- [ ] Mobile Chrome (Android)
- [ ] Mobile Safari (iOS)

## Support

For issues or questions:
1. Check browser console for errors
2. Verify HTTPS connection (required for camera)
3. Test with manual entry first
4. Review error logs in Laravel

---

**Last Updated**: October 26, 2025
**Version**: 1.0
**Author**: VETech Development Team
