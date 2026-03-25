# MageMe WebForms 3 — HubSpot Integration

Free add-on for [MageMe WebForms for Magento 2](https://mageme.com/magento-2-form-builder.html) that integrates form submissions with HubSpot CRM.

## Features

- Create and update contacts, companies, and tickets in HubSpot from form submissions
- Map form fields to HubSpot properties including lifecycle stages and lead status
- Send submissions to HubSpot manually from the admin panel

## Requirements

- Magento 2.4.x
- [MageMe WebForms 3](https://mageme.com/magento-2-form-builder.html) version 3.5.0 or higher
- PHP `curl` and `json` extensions

## Installation

### Via Composer

```
composer require mageme/module-webforms-3-hubspot
bin/magento setup:upgrade
bin/magento cache:flush
```

### Manual Installation

1. Download and extract to `app/code/MageMe/WebFormsHubspot/`
2. Run `bin/magento setup:upgrade`
3. Run `bin/magento cache:flush`

## Configuration

1. Navigate to **Stores > Configuration > MageMe > WebForms > HubSpot** and enter your HubSpot API key.
2. Open a form in the admin panel and configure the HubSpot integration tab to map form fields to contact, company, or ticket properties.

## About MageMe WebForms

[MageMe WebForms](https://mageme.com/magento-2-form-builder.html) is a powerful form builder for Magento 2 that allows you to create any type of form — contact forms, surveys, registration forms, order forms, and more — with a drag-and-drop interface, conditional logic, file uploads, and CRM integrations.

[Get MageMe WebForms](https://mageme.com/magento-2-form-builder.html)

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Issue Tracker: [GitHub Issues](https://github.com/mageme/module-webforms-3-hubspot/issues)

## License

Proprietary. See [License](https://mageme.com/license/) for details.
