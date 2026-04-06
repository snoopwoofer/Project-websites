# Quick Installation Guide

## Step-by-Step Installation

### 1. Upload to WordPress

**Option A: Via FTP/File Manager**
- Upload the entire `thailand-tour-guide` folder to `/wp-content/plugins/`
- Your final path should be: `/wp-content/plugins/thailand-tour-guide/thailand-tour-guide.php`

**Option B: Via WordPress Admin**
- Zip the `thailand-tour-guide` folder
- Go to: WordPress Admin → Plugins → Add New → Upload Plugin
- Choose the ZIP file and click "Install Now"

### 2. Activate the Plugin

- Go to: WordPress Admin → Plugins
- Find "Thailand Tour Guide"
- Click "Activate"

### 3. Set Up a Page for Tours

**Option 1: Create a Tours Page**
1. Go to: Pages → Add New
2. Title: "Tours" or "Available Tours"
3. In the content editor, add the shortcode:
   ```
   [tour_list]
   ```
4. Publish the page

**Option 2: Add to Homepage**
- Edit your homepage
- Add the shortcode where you want tours to appear:
   ```
   [tour_list]
   ```

### 4. Create Your First Tour

1. Go to: Tours → Add New
2. Fill in:
   - **Title**: e.g., "Bangkok Grand Palace & Temples Tour"
   - **Content**: Overview of the tour
   - **Featured Image**: Main tour image (click "Set featured image")
   
3. **Select Categories** (right sidebar):
   - City: Bangkok
   - Duration: 1 Day

4. **Tour Details** (scroll down):
   - Price Per Person: 1500
   - Check "Customizable" if applicable
   - Add customization note: "Feel free to discuss any changes to this itinerary!"

5. **Add Itinerary** (scroll down):
   - Click "Add Stop"
   - Fill in each stop:
     * Time: 09:00 AM
     * Location: Grand Palace
     * Description: Visit the stunning Grand Palace complex...
     * Upload a photo of the location
   - Click "Add Stop" again for each additional location
   - You can drag stops to reorder them

6. Click "Publish"

### 5. View Your Tour

- Go to the page where you added the `[tour_list]` shortcode
- You should see:
  - Filter dropdowns at the top
  - Your tour displayed as a card
  - Click "View Details" to see the full tour page

## Post-Installation Checklist

- [ ] Plugin activated successfully
- [ ] Tours page created with shortcode
- [ ] At least one tour created and published
- [ ] Featured image added to tour
- [ ] City and Duration selected
- [ ] Price added
- [ ] Itinerary items added with photos
- [ ] Tour displays correctly on frontend
- [ ] Filters work properly
- [ ] Single tour page displays correctly

## Refresh Permalinks

If you see 404 errors on tour pages:

1. Go to: Settings → Permalinks
2. Click "Save Changes" (no need to change anything)
3. This refreshes WordPress rewrite rules

## Theme Integration

The plugin works with any WordPress theme. For best results:

1. **Full-Width Page Template**: Use a full-width page template for the tours page
2. **Remove Sidebar**: Tours display better without sidebars
3. **Custom CSS**: Add custom CSS via Appearance → Customize → Additional CSS if needed

## Default Cities

The plugin comes pre-configured with these Thai cities:
- Bangkok
- Pattaya
- Hua Hin
- Ayutthaya

To add more cities:
- Go to: Tours → Cities
- Click "Add New City"

## Default Durations

Pre-configured durations:
- 1 Day
- 2 Days
- 3 Days
- 4 Days
- 5 Days
- 6 Days
- 7+ Days

To add custom durations:
- Go to: Tours → Duration
- Click "Add New Duration"

## Next Steps

1. **Create Multiple Tours**: Add tours for different cities
2. **Add Detailed Descriptions**: Write engaging tour descriptions
3. **Upload Quality Photos**: High-quality images attract more travelers
4. **Test Filters**: Make sure city and duration filters work
5. **Mobile Check**: View tours on mobile devices
6. **Share Links**: Share tour links with potential travelers

## Need Help?

- Check the main README.md file
- Review the troubleshooting section
- Check WordPress.org support forums

## Quick Tips

✅ **DO:**
- Use high-quality photos (1920x1080px or similar)
- Write detailed itinerary descriptions
- Set realistic prices
- Keep tour titles clear and descriptive
- Test on mobile devices

❌ **DON'T:**
- Don't forget to set featured images
- Don't leave price fields empty
- Don't upload extremely large images (over 5MB)
- Don't forget to select city and duration

## Example Tour Structure

**Title**: Bangkok Historical & Cultural Day Tour

**City**: Bangkok
**Duration**: 1 Day
**Price**: 2,500 THB per person

**Itinerary**:
1. 08:00 AM - Hotel Pickup
2. 09:00 AM - Grand Palace
3. 11:00 AM - Wat Pho (Reclining Buddha)
4. 12:30 PM - Lunch Break
5. 02:00 PM - Wat Arun
6. 04:00 PM - Chao Phraya River Cruise
7. 06:00 PM - Return to Hotel

Each stop should have a photo and description!
