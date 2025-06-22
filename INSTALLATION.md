# Installation Guide - Default Discount Type Module

**Developed by [BitLab (Pvt) Ltd](https://bitlab.lk)**

## Quick Installation

1. **Upload the module files:**
   - Copy the entire `default_discount_type` folder to your Perfex CRM `modules` directory
   - Ensure the folder structure is: `modules/default_discount_type/`

2. **Activate the module:**
   - Log in to your Perfex CRM admin panel
   - Navigate to **Setup > Modules**
   - Find "Default Discount Type" in the modules list
   - Click the **Activate** button

3. **Configure the setting:**
   - Go to **Setup > Settings > Finance > General**
   - Scroll down to find the new "Default Discount Type" setting
   - Select your preferred default discount type
   - Click **Save Settings**

## Verification

To verify the module is working correctly:

1. **Check the setting appears:**
   - Go to **Setup > Settings > Finance > General**
   - You should see the "Default Discount Type" dropdown at the bottom

2. **Test the functionality:**
   - Create a new invoice, estimate, or proposal
   - The discount type dropdown should be pre-selected with your chosen default
   - You can still change it manually if needed

## Troubleshooting

### Module not appearing in modules list
- Ensure the folder is named exactly `default_discount_type`
- Check file permissions (should be readable by web server)
- Verify the main module file `default_discount_type.php` exists

### Setting not appearing in sales general settings
- Make sure the module is activated
- Check if there are any JavaScript errors in browser console
- Verify the hook `after_sales_general_settings` is working

### Default not being applied to new documents
- Check that you've saved the setting in **Setup > Settings > Finance > General**
- Verify the setting value in the database (table: `options`, name: `default_discount_type`)
- Check browser console for any JavaScript errors

## File Permissions

Ensure the following files have proper permissions:
- All PHP files: 644
- All directories: 755
- index.html files: 644

## Database

The module adds one option to the database:
- **Table:** `options`
- **Name:** `default_discount_type`
- **Value:** `before_tax`, `after_tax`, or empty string

## Uninstallation

To uninstall the module:
1. Go to **Setup > Modules**
2. Find "Default Discount Type"
3. Click **Deactivate**
4. The module will automatically remove the database option

## Support

For technical support or custom development:
- **BitLab (Pvt) Ltd**
- **Website**: [https://bitlab.lk](https://bitlab.lk)
- **Email**: Contact us through our website

---

**© 2025 BitLab (Pvt) Ltd. All rights reserved.** 