<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Default Discount Type
Description: Module to set default discount type for invoices, estimates, and proposals. Developed by BitLab (Pvt) Ltd.
Version: 1.0.1
Requires at least: 2.3.*
Author: BitLab (Pvt) Ltd
Author URI: https://bitlab.lk
*/

define('DEFAULT_DISCOUNT_TYPE_MODULE_NAME', 'default_discount_type');

// Register activation hook
register_activation_hook(DEFAULT_DISCOUNT_TYPE_MODULE_NAME, 'default_discount_type_module_activation_hook');

// Register deactivation hook
register_deactivation_hook(DEFAULT_DISCOUNT_TYPE_MODULE_NAME, 'default_discount_type_module_deactivation_hook');

function default_discount_type_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

function default_discount_type_module_deactivation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/uninstall.php');
}

// Register language files
register_language_files(DEFAULT_DISCOUNT_TYPE_MODULE_NAME, [DEFAULT_DISCOUNT_TYPE_MODULE_NAME]);

// Add hook to inject setting into sales general page
hooks()->add_action('after_sales_general_settings', 'default_discount_type_add_setting');

// Add hook to set default discount type for new documents
hooks()->add_action('admin_init', 'default_discount_type_admin_init');

/**
 * Admin init hook to add JavaScript for setting default discount type
 */
function default_discount_type_admin_init()
{
    $CI = &get_instance();
    
    // Only add JavaScript on invoice, estimate, and proposal pages
    $current_page = $CI->uri->segment(2);
    $valid_pages = ['invoices', 'estimates', 'proposals'];
    
    if (in_array($current_page, $valid_pages)) {
        $action = $CI->uri->segment(3);
        
        // Check if we're on the add/edit page for invoices, estimates, or proposals
        if (($current_page == 'invoices' && $action == 'invoice') || 
            ($current_page == 'estimates' && $action == 'estimate') ||
            ($current_page == 'proposals' && $action == 'proposal')) {
            
            $default_discount_type = get_option('default_discount_type');
            
            if ($default_discount_type && $default_discount_type !== '') {
                hooks()->add_action('app_admin_footer', 'default_discount_type_admin_footer_js');
            }
        }
    }
}

/**
 * Add JavaScript to set default discount type
 */
function default_discount_type_admin_footer_js()
{
    $default_discount_type = get_option('default_discount_type');
    
    if ($default_discount_type && $default_discount_type !== '') {
        ?>
        <script>
        // Default Discount Type Module - Enhanced Version
        // Developed by BitLab (Pvt) Ltd - https://bitlab.lk
        (function() {
            console.log('Default Discount Type Module by BitLab: Loading...');
            
            var defaultDiscountType = '<?= $default_discount_type ?>';
            var attempts = 0;
            var maxAttempts = 10;
            
            function setDefaultDiscountType() {
                attempts++;
                console.log('Default Discount Type Module by BitLab: Attempt ' + attempts + ' to set discount type');
                
                var $discountTypeSelect = $('select[name="discount_type"]');
                
                if ($discountTypeSelect.length > 0) {
                    console.log('Default Discount Type Module by BitLab: Found discount type select');
                    
                    // Check if this is a new document
                    var isNewDocument = false;
                    
                    // Method 1: Check URL
                    var currentUrl = window.location.href;
                    if (currentUrl.match(/\/(invoice|estimate|proposal)$/)) {
                        isNewDocument = true;
                        console.log('Default Discount Type Module by BitLab: URL indicates new document');
                    }
                    
                    // Method 2: Check number field
                    var $numberInput = $('input[name="number"]');
                    var currentNumber = $numberInput.val();
                    if (!currentNumber || currentNumber === 'DRAFT' || currentNumber === '') {
                        isNewDocument = true;
                        console.log('Default Discount Type Module by BitLab: Number field indicates new document');
                    }
                    
                    // Method 3: Check if there's an ID in the URL (existing document)
                    if (currentUrl.match(/\/(invoice|estimate|proposal)\/\d+/)) {
                        isNewDocument = false;
                        console.log('Default Discount Type Module by BitLab: URL indicates existing document');
                    }
                    
                    if (isNewDocument) {
                        console.log('Default Discount Type Module by BitLab: Setting discount type to: ' + defaultDiscountType);
                        
                        // Set the value
                        $discountTypeSelect.val(defaultDiscountType);
                        
                        // Trigger change event
                        $discountTypeSelect.trigger('change');
                        
                        // Refresh selectpicker if it exists
                        if ($discountTypeSelect.hasClass('selectpicker')) {
                            $discountTypeSelect.selectpicker('refresh');
                        }
                        
                        // Also trigger any existing change handlers
                        setTimeout(function() {
                            $discountTypeSelect.trigger('change');
                        }, 100);
                        
                        console.log('Default Discount Type Module by BitLab: Successfully set default discount type');
                        return true;
                    } else {
                        console.log('Default Discount Type Module by BitLab: This is an existing document, not setting default');
                        return true;
                    }
                } else {
                    console.log('Default Discount Type Module by BitLab: Discount type select not found');
                    return false;
                }
            }
            
            // Try to set immediately when DOM is ready
            $(document).ready(function() {
                console.log('Default Discount Type Module by BitLab: DOM ready');
                
                // Initial attempt
                if (!setDefaultDiscountType()) {
                    // If not successful, try with intervals
                    var interval = setInterval(function() {
                        if (setDefaultDiscountType() || attempts >= maxAttempts) {
                            clearInterval(interval);
                            if (attempts >= maxAttempts) {
                                console.log('Default Discount Type Module by BitLab: Max attempts reached, giving up');
                            }
                        }
                    }, 500);
                }
            });
            
            // Also try when window loads
            $(window).on('load', function() {
                console.log('Default Discount Type Module by BitLab: Window loaded');
                setTimeout(function() {
                    setDefaultDiscountType();
                }, 1000);
            });
            
        })();
        </script>
        <?php
    }
}

/**
 * Add default discount type setting to sales general page
 */
function default_discount_type_add_setting()
{
    $default_discount_type = get_option('default_discount_type');
    ?>
    <hr />
    <div class="form-group">
        <label for="default_discount_type"><?= _l('default_discount_type'); ?></label>
        <select id="default_discount_type" class="selectpicker" name="settings[default_discount_type]" data-width="100%">
            <option value="" <?= $default_discount_type == '' ? ' selected' : ''; ?>><?= _l('default_discount_type_no_discount'); ?></option>
            <option value="before_tax" <?= $default_discount_type == 'before_tax' ? ' selected' : ''; ?>><?= _l('default_discount_type_before_tax'); ?></option>
            <option value="after_tax" <?= $default_discount_type == 'after_tax' ? ' selected' : ''; ?>><?= _l('default_discount_type_after_tax'); ?></option>
        </select>
        <small class="form-text text-muted"><?= _l('default_discount_type_help'); ?></small>
        <div class="text-muted" style="margin-top: 5px; font-size: 11px;">
            <i class="fa fa-code"></i> <?= _l('default_discount_type_developed_by'); ?> 
            <a href="https://bitlab.lk" target="_blank" style="color: #666;">BitLab (Pvt) Ltd</a>
        </div>
    </div>
    <?php
}

/**
 * Add action links for the module
 * @param array $actions Current actions
 * @return array
 */
function module_default_discount_type_action_links($actions)
{
    $actions[] = '<a href="' . admin_url('settings?group=sales_general') . '">' . _l('settings') . '</a>';
    $actions[] = '<a href="https://bitlab.lk" target="_blank">' . _l('default_discount_type_developed_by') . '</a>';
    
    return $actions;
}

// Add filter for module action links
hooks()->add_filter('module_default_discount_type_action_links', 'module_default_discount_type_action_links'); 