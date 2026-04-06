# Thailand Tour Guide Plugin - Overview

## What This Plugin Does

This WordPress plugin allows drivers in Thailand to create and share tour itineraries with travelers. It's designed specifically for your use case where drivers can showcase multi-day tours in different Thai cities.

## Key Features Implemented

### ✅ Frontend Features (What Travelers See)

1. **City Filters**
   - Bangkok
   - Pattaya
   - Hua Hin
   - Ayutthaya
   - Dropdown at the top of the page

2. **Duration Filters**
   - 1 Day through 7+ Days
   - Dropdown at the top of the page

3. **Itinerary Display**
   - Each tour shows detailed itinerary
   - Photos attached to each location
   - Time stamps for each stop
   - Location names and descriptions

4. **Price Display**
   - Shows price per person at the bottom
   - Clear pricing in Thai Baht (THB)

5. **Customization Notice**
   - Badge showing "Customizable"
   - Custom message from driver
   - Indicates flexibility to modify tours

6. **Responsive Design**
   - Works on desktop, tablet, and mobile
   - Touch-friendly filters
   - Optimized layouts

### ✅ Backend Features (Admin Panel)

1. **Easy Tour Creation**
   - Simple WordPress interface
   - Custom "Tours" menu in admin
   - Drag-and-drop itinerary builder

2. **Itinerary Builder**
   - Add unlimited stops
   - Upload photo for each location
   - Set time, location name, description
   - Reorder stops by dragging
   - Remove stops easily

3. **Tour Details**
   - Set price per person
   - Mark as customizable
   - Add customization notes
   - Select city and duration

## How It Works

### For Admins/Drivers:

```
1. Install Plugin
   ↓
2. Create Tours Page (add [tour_list] shortcode)
   ↓
3. Add Tours
   - Set title, description, featured image
   - Select city and duration
   - Add price
   - Build itinerary with photos
   ↓
4. Publish
   ↓
5. Share page with travelers
```

### For Travelers:

```
1. Visit Tours Page
   ↓
2. Use Filters
   - Select city
   - Select number of days
   - Click "Search Tours"
   ↓
3. Browse Results
   - See tour cards with highlights
   - View prices
   - See customization options
   ↓
4. Click "View Details"
   ↓
5. See Full Itinerary
   - Complete timeline
   - Photos of each location
   - Descriptions
   - Contact button
```

## Plugin Structure

### Core Files

| File | Purpose |
|------|---------|
| `thailand-tour-guide.php` | Main plugin file, initializes everything |
| `includes/class-tour-post-type.php` | Creates "Tours" post type and taxonomies |
| `includes/class-tour-meta-boxes.php` | Admin interface for adding tour details |
| `includes/class-tour-frontend.php` | Frontend display logic |
| `includes/tour-functions.php` | Helper functions and AJAX handlers |

### Template Files

| File | What It Displays |
|------|------------------|
| `templates/tour-list.php` | Main tour listing with filters |
| `templates/tour-card.php` | Individual tour card in grid |
| `templates/single-tour.php` | Full single tour page |
| `templates/archive-tour.php` | Archive pages for cities/durations |

### Asset Files

| File | Purpose |
|------|---------|
| `assets/css/frontend.css` | Styles for public-facing pages |
| `assets/css/admin.css` | Styles for admin interface |
| `assets/js/frontend.js` | Filter functionality, animations |
| `assets/js/admin.js` | Itinerary builder, image uploads |

## Technical Details

### Custom Post Type
- **Name**: `tour`
- **URL**: `/tours/tour-name`
- **Archive**: `/tours/`
- **Supports**: Title, Editor, Thumbnail, Excerpt

### Taxonomies

**1. City** (`tour_city`)
- Hierarchical
- Pre-populated with: Bangkok, Pattaya, Hua Hin, Ayutthaya
- URL format: `/city/bangkok/`

**2. Duration** (`tour_duration`)
- Hierarchical
- Pre-populated with: 1 Day, 2 Days, 3 Days, etc.
- URL format: `/duration/2-days/`

### Custom Fields (Meta Data)

Stored for each tour:
- `_tour_price_per_person` - Price in THB
- `_tour_customizable` - Yes/No flag
- `_tour_custom_note` - Customization message
- `_tour_itinerary` - Array of itinerary items:
  - `time` - Time of stop
  - `location` - Location name
  - `description` - What travelers will see/do
  - `image_id` - Attached photo

### AJAX Functionality

The filtering works without page reloads:
- Action: `ttg_filter_tours`
- Returns: Filtered tour HTML
- Smooth animations during filter
- Loading spinner

## Shortcode Usage

### Basic Usage
```
[tour_list]
```
Shows all tours with filters.

### With Attributes
```
[tour_list posts_per_page="6"]
```
Limits to 6 tours.

```
[tour_list city="bangkok"]
```
Shows only Bangkok tours.

```
[tour_list duration="2-days"]
```
Shows only 2-day tours.

### Multiple Attributes
```
[tour_list city="bangkok" duration="1-day" posts_per_page="3"]
```

## Customization Points

### Easy Customizations (No Code)

1. **Add More Cities**
   - Admin → Tours → Cities → Add New

2. **Add More Durations**
   - Admin → Tours → Duration → Add New

3. **Change Colors**
   - Edit `assets/css/frontend.css`
   - Search for color codes (e.g., `#0066cc`)

### Advanced Customizations (Code)

1. **Custom Contact Form**
   - Edit `templates/single-tour.php`
   - Replace `ttg-contact-button` onclick

2. **Payment Integration**
   - Add payment button in `templates/single-tour.php`
   - Integrate with WooCommerce, Stripe, etc.

3. **Booking System**
   - Use WooCommerce Bookings
   - Or integrate custom booking form

4. **Multi-Language**
   - Install WPML or Polylang
   - Translate tours to multiple languages

## Example Use Cases

### Use Case 1: Driver's Personal Website
- Install on driver's website
- Create 10-15 tours
- Share main tours page with customers
- Update tours seasonally

### Use Case 2: Multi-Driver Platform
- Multiple drivers create accounts
- Each driver adds their tours
- Central directory of all tours
- Filter by driver (would need customization)

### Use Case 3: Tour Agency
- Agency creates tours
- Assigns drivers to tours
- Manages bookings separately
- Uses plugin for display only

## What's NOT Included (Future Enhancements)

These features could be added later:

1. **Booking System** - Travelers can't book directly (requires integration)
2. **Payment Processing** - No built-in payments (integrate Stripe/PayPal)
3. **Calendar/Availability** - No date selection (add booking plugin)
4. **Reviews/Ratings** - No review system (add review plugin)
5. **Multi-Language** - Single language only (add WPML/Polylang)
6. **Email Notifications** - No automated emails (add form plugin)
7. **Driver Profiles** - No driver management (customize post type)
8. **Maps Integration** - No Google Maps (add custom field)

## Browser Compatibility

✅ Tested on:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

## WordPress Requirements

- **WordPress Version**: 5.0 or higher
- **PHP Version**: 7.0 or higher
- **MySQL Version**: 5.6 or higher
- **Plugins Required**: None (standalone)
- **Theme Required**: Any WordPress theme

## Performance

- **Lightweight**: Minimal database queries
- **Optimized**: AJAX filtering for speed
- **Images**: Automatically uses WordPress thumbnails
- **Caching**: Compatible with caching plugins

## Security

- **Nonces**: All forms use WordPress nonces
- **Sanitization**: All inputs sanitized
- **Validation**: Data validated before saving
- **Permissions**: Capability checks for admin features

## SEO Features

- **Custom URLs**: SEO-friendly permalinks
- **Meta Data**: Proper title and description support
- **Schema**: Can add structured data (future)
- **Images**: Alt text and proper sizing
- **Mobile**: Responsive = good for SEO

## Getting Started Checklist

- [ ] Read INSTALLATION.md
- [ ] Upload plugin to WordPress
- [ ] Activate plugin
- [ ] Create tours page with `[tour_list]` shortcode
- [ ] Add first test tour
- [ ] Check filters work
- [ ] View single tour page
- [ ] Test on mobile
- [ ] Add real tours
- [ ] Share with travelers!

## Support & Documentation

📖 **Full Documentation**: README.md
🚀 **Quick Start**: INSTALLATION.md
❓ **This File**: Overview of features and structure

## License

GPL v2 or later - Free to use and modify!

---

**Ready to start?** → Open INSTALLATION.md for step-by-step setup!
