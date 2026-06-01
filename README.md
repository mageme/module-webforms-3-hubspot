# MageMe WebForms HubSpot for Magento 2

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mageme/module-webforms-3-hubspot.svg?style=flat-square)](https://packagist.org/packages/mageme/module-webforms-3-hubspot)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mageme/module-webforms-3-hubspot.svg?style=flat-square)](https://packagist.org/packages/mageme/module-webforms-3-hubspot)
[![Magento](https://img.shields.io/badge/Magento-2.4.x-EE672F.svg?style=flat-square)](https://magento.com)
[![PHP](https://img.shields.io/badge/PHP-7.4%20–%208.5-777BB4.svg?style=flat-square)](https://php.net)
[![License](https://img.shields.io/badge/license-MageMe%20EULA-blue.svg?style=flat-square)](https://mageme.com/license/)

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

## Custom Magento development

Need a feature an extension doesn't cover, or a bespoke Magento build? MageMe takes on custom extension development and integration work.

→ **[Custom Magento development](https://mageme.com/magento-services/custom-development)**

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Bug reports and feature requests: [GitHub Issues](https://github.com/mageme/module-webforms-3-hubspot/issues)

## License

Governed by the **MageMe End User License Agreement** ([mageme.com/license](https://mageme.com/license/)). This add-on is distributed free of charge.

---

**MageMe WebForms** is a no-code form builder for Magento 2 — conditional logic, multi-step forms, file uploads, and CRM integrations. → [Get WebForms](https://mageme.com/magento-2-form-builder.html) · [Browse all extensions](https://mageme.com/extensions)
