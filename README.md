# Magento 2 HubSpot Integration — MageMe WebForms

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mageme/module-webforms-3-hubspot.svg)](https://packagist.org/packages/mageme/module-webforms-3-hubspot)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mageme/module-webforms-3-hubspot.svg)](https://packagist.org/packages/mageme/module-webforms-3-hubspot)
[![License](https://img.shields.io/packagist/l/mageme/module-webforms-3-hubspot.svg)](https://mageme.com/license/)

Send Magento 2 form submissions straight to HubSpot CRM. This free add-on for [MageMe WebForms](https://mageme.com/magento-2-form-builder.html) creates and updates HubSpot contacts, companies, and tickets — keeping your CRM in sync with every customer interaction on your store.

## Features

- Create and update HubSpot contacts with automatic duplicate detection by email
- Create HubSpot tickets and associate them with contacts and companies
- Set contact lifecycle stages and lead status for pipeline management
- Assign owners to contacts and tickets for team workflows
- Upload form files as HubSpot notes with timestamp-based organization
- Map any form field to HubSpot contact, company, or ticket properties
- Resend submissions to HubSpot manually from the Magento admin panel

## Requirements

- Magento 2.4.x
- [MageMe WebForms 3](https://mageme.com/magento-2-form-builder.html) version 3.5.0 or higher
- PHP `curl` and `json` extensions
- HubSpot account with API access

## Installation

```
composer require mageme/module-webforms-3-hubspot
bin/magento setup:upgrade
bin/magento cache:flush
```

## Configuration

1. Go to **Stores > Configuration > MageMe > WebForms > HubSpot** and enter your HubSpot API key.
2. Open any form in the admin panel and configure the HubSpot integration tab to map form fields to contact, company, or ticket properties.

## Other MageMe WebForms Integrations

Connect your Magento 2 forms to the tools your team already uses:

- [Salesforce](https://github.com/mageme/module-webforms-3-salesforce) — create leads from form submissions
- [Zoho CRM & Desk](https://github.com/mageme/module-webforms-3-zoho) — create leads and support tickets
- [Freshdesk](https://github.com/mageme/module-webforms-3-freshdesk) — create support tickets automatically
- [Zendesk](https://github.com/mageme/module-webforms-3-zendesk) — create tickets with custom field types
- [Klaviyo](https://github.com/mageme/module-webforms-3-klaviyo) — build profiles and grow your email lists
- [Mailchimp](https://github.com/mageme/module-webforms-3-mailchimp) — subscribe customers to audiences
- [Zapier](https://github.com/mageme/module-webforms-3-zapier) — connect forms to 7000+ apps

## About MageMe WebForms

[MageMe WebForms](https://mageme.com/magento-2-form-builder.html) lets Magento 2 merchants build any web form without writing code. From simple contact forms to complex multi-step order forms — with conditional logic, file uploads, email notifications, and CRM integrations built in.

[Get MageMe WebForms for Magento 2](https://mageme.com/magento-2-form-builder.html)

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Issue Tracker: [GitHub Issues](https://github.com/mageme/module-webforms-3-hubspot/issues)

## License

Proprietary. See [License](https://mageme.com/license/) for details.
