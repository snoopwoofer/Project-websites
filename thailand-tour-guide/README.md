# Thailand Tour Guide WordPress Plugin

A comprehensive WordPress plugin for drivers to create and share tour itineraries with travelers in Thailand.

## Features

- **Custom Post Type**: Tours with full WordPress integration
- **City Filtering**: Bangkok, Pattaya, Hua Hin, Ayutthaya
- **Duration Filtering**: Filter tours by number of days
- **Detailed Itineraries**: Add multiple stops with times, locations, descriptions, and photos
- **Price Display**: Show price per person
- **Customization Options**: Mark tours as customizable with custom notes
- **Responsive Design**: Mobile-friendly interface
- **AJAX Filtering**: Real-time filtering without page reload
- **Easy Management**: User-friendly admin interface

## Installation

### Method 1: Manual Installation

1. Download or clone this plugin folder
2. Upload the `thailand-tour-guide` folder to your WordPress `wp-content/plugins/` directory
3. Go to WordPress Admin → Plugins
4. Find "Thailand Tour Guide" and click "Activate"

### Method 2: ZIP Upload

1. Zip the `thailand-tour-guide` folder
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Activate the plugin

## Usage

### Creating a Tour

1. Go to WordPress Admin → Tours → Add New
2. Enter the tour title and description
3. Set a featured image (this will be the main tour image)
4. Select the **City** from the right sidebar (Bangkok, Pattaya, Hua Hin, or Ayutthaya)
5. Select the **Duration** (1 Day, 2 Days, etc.)

### Adding Tour Details

In the **Tour Details** meta box:
- **Price Per Person**: Enter the price in Thai Baht (THB)
- **Customizable**: Check if the tour can be customized
- **Customization Note**: Add a message about customization options (e.g., "This itinerary can be adjusted based on your interests. Contact me to discuss modifications.")

### Creating the Itinerary

In the **Itinerary** meta box:
1. Click "Add Stop" to add each location
2. For each stop, enter:
   - **Time**: e.g., "09:00 AM" or "Morning"
   - **Location**: Name of the place
   - **Description**: Details about what travelers will see/do
   - **Location Photo**: Upload an image of the location (highly recommended)
3. Add as many stops as needed
4. Drag and drop stops to reorder them
5. Click "Remove" to delete a stop

### Publishing

Click "Publish" to make the tour live on your website.

## Displaying Tours on Your Website

### Method 1: Using Shortcode (Recommended)

Add this shortcode to any page or post:

```
[tour_list]
```

This will display:
- Filter dropdowns for City and Duration
- Grid of all available tours
- Search and Reset buttons

### Method 2: Using the Archive

Tours automatically create these pages:
- `/tours/` - All tours
- `/city/bangkok/` - Tours in Bangkok
- `/duration/2-days/` - 2-day tours

### Method 3: Using WordPress Menus

Add tour links to your WordPress menu:
1. Go to Appearance → Menus
2. Look for "Cities" or "Duration" in the left sidebar
3. Add them to your menu

## Customization

### Changing Colors

Edit `assets/css/frontend.css` and modify the color values:
- Primary color: `#0066cc` (blue) - used for links, buttons
- Success color: `#28a745` (green) - used for contact button
- Background colors: Various grays

### Changing Default Cities

Edit `includes/class-tour-post-type.php`, find the `populate_default_terms()` function, and modify the cities array:

```php
$cities = array('Bangkok', 'Pattaya', 'Hua Hin', 'Ayutthaya');
```

### Adding Contact Form Integration

Currently, the "Contact Driver" button shows an alert. To integrate with a contact form:

1. Install a contact form plugin (Contact Form 7, WPForms, etc.)
2. Edit `templates/single-tour.php`
3. Find the `ttg-contact-button` and replace the onclick alert with a link to your contact form:

```php
<a href="/contact/?tour=<?php echo get_the_ID(); ?>" class="ttg-contact-button">
    <?php _e('Contact Driver', 'thailand-tour-guide'); ?>
</a>
```

## File Structure

```
thailand-tour-guide/
├── thailand-tour-guide.php    # Main plugin file
├── includes/
│   ├── class-tour-post-type.php      # Custom post type registration
│   ├── class-tour-meta-boxes.php     # Admin interface
│   ├── class-tour-frontend.php       # Frontend display
│   └── tour-functions.php            # Helper functions
├── templates/
│   ├── tour-list.php          # Tour grid with filters
│   ├── tour-card.php          # Single tour card
│   ├── single-tour.php        # Single tour page
│   └── archive-tour.php       # Tour archive page
├── assets/
│   ├── css/
│   │   ├── frontend.css       # Frontend styles
│   │   └── admin.css          # Admin styles
│   └── js/
│       ├── frontend.js        # Frontend JavaScript
│       └── admin.js           # Admin JavaScript
└── README.md                  # This file
```

## Common Use Cases

### Homepage Tour Display

Add this to your homepage template or use the shortcode in a page builder:
```
[tour_list posts_per_page="6"]
```

### City-Specific Pages

Create pages for each city and add:
```
[tour_list city="bangkok"]
```

### Featured Tours Widget

Create a custom widget area and add the tour list there.

## Troubleshooting

### Tours not showing up

1. Make sure tours are published (not drafts)
2. Go to Settings → Permalinks and click "Save Changes" to refresh rewrite rules
3. Clear your cache if using a caching plugin

### Images not uploading

1. Check your PHP upload_max_filesize setting
2. Ensure your uploads folder is writable
3. Try smaller image files (recommended: under 2MB)

### Filters not working

1. Make sure JavaScript is enabled in your browser
2. Check browser console for errors
3. Ensure jQuery is loaded on your site

## Support

For issues or questions:
- Check the WordPress.org forums
- Review the code documentation
- Contact the developer

## License

GPL v2 or later

## Credits

Developed for drivers in Thailand to share their local expertise with travelers.
