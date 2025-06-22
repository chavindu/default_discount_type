# Default Discount Type Module for Perfex CRM

**Developed by [BitLab (Pvt) Ltd](https://bitlab.lk)**

This module allows administrators to set a default discount type for invoices, estimates, and proposals in Perfex CRM.

## Features

- Set default discount type (Before Tax, After Tax, or No Discount) for new sales documents
- Automatically applies the selected discount type when creating new invoices, estimates, and proposals
- Integrates seamlessly with the existing sales general settings page
- Supports all Perfex CRM languages

## Installation

1. Upload the `default_discount_type` folder to your Perfex CRM `modules` directory
2. Go to **Setup > Modules** in your Perfex CRM admin panel
3. Find "Default Discount Type" in the modules list
4. Click **Activate** to install the module
5. The module will automatically add the default discount type setting to your sales general settings

## Configuration

1. Go to **Setup > Settings > Finance > General**
2. Scroll down to find the "Default Discount Type" setting
3. Select your preferred default discount type:
   - **No Discount**: No discount type will be pre-selected
   - **Before Tax**: Discount will be applied before tax calculation
   - **After Tax**: Discount will be applied after tax calculation
4. Click **Save Settings**

## How It Works

Once configured, when you create a new invoice, estimate, or proposal:

1. The discount type dropdown will automatically be set to your chosen default
2. You can still change the discount type manually if needed
3. The setting only affects new documents, not existing ones

## Files Structure

```
modules/default_discount_type/
├── default_discount_type.php      # Main module file
├── install.php                    # Installation script
├── uninstall.php                  # Uninstall script
├── index.html                     # Security file
├── README.md                      # This file
└── language/
    └── english/
        └── default_discount_type_lang.php  # Language file
```

## Compatibility

- **Perfex CRM Version**: 2.3.* and above
- **PHP Version**: 7.4 and above
- **Database**: MySQL/MariaDB

## Support

For support or feature requests, please contact:
- **BitLab (Pvt) Ltd**
- **Website**: [https://bitlab.lk](https://bitlab.lk)
- **Email**: Contact us through our website

## Changelog

### Version 1.0.1
- Enhanced JavaScript with multiple retry attempts
- Better detection of new vs existing documents
- Improved console logging for debugging

### Version 1.0.0
- Initial release
- Default discount type setting for invoices, estimates, and proposals
- Integration with sales general settings page
- Multi-language support

---

**© 2025 BitLab (Pvt) Ltd. All rights reserved.** 