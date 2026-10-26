# Tax Management

## Overview

Tax management handles tax rate calculation, tax-exempt customers, VAT compliance, invoice requirements, and tax reporting. This document covers all aspects of tax handling in gsmui's billing system.

## Tax Rates

### Tax Rate Configuration

```php
// config/taxes.php
return [
    'rates' => [
        'US' => [
            'CA' => ['rate' => 725, 'name' => 'CA Sales Tax'], // 7.25%
            'NY' => ['rate' => 800, 'name' => 'NY Sales Tax'], // 8.00%
            'TX' => ['rate' => 625, 'name' => 'TX Sales Tax'], // 6.25%
            'FL' => ['rate' => 600, 'name' => 'FL Sales Tax'], // 6.00%
        ],
        'GB' => ['rate' => 2000, 'name' => 'VAT'], // 20%
        'DE' => ['rate' => 1900, 'name' => 'MwSt'], // 19%
        'FR' => ['rate' => 2000, 'name' => 'TVA'], // 20%
        'AU' => ['rate' => 1000, 'name' => 'GST'], // 10%
        'CA' => ['rate' => 500, 'name' => 'GST'], // 5% federal
    ],
    'default' => ['rate' => 0, 'name' => 'No Tax'],
];
```

### Tax Rate Resolution

```php
class TaxResolver
{
    public function resolve(User $user, OrderItem $item): TaxRate
    {
        // Check exemption first
        if ($user->isTaxExempt()) {
            return new TaxRate(rate: 0, name: 'Exempt', exempt: true);
        }

        // Check for product-specific tax class
        if ($item->product->tax_class) {
            return $this->resolveByClass($item->product->tax_class, $user);
        }

        // Resolve by customer location
        return $this->resolveByLocation($user->billingCountry, $user->billingState);
    }

    protected function resolveByLocation(string $country, ?string $state): TaxRate
    {
        $rates = config('taxes.rates');

        if (!isset($rates[$country])) {
            return new TaxRate(rate: 0, name: 'No Tax');
        }

        if (is_array($rates[$country]) && isset($rates[$country][$state])) {
            return new TaxRate(
                rate: $rates[$country][$state]['rate'],
                name: $rates[$country][$state]['name'],
            );
        }

        if (isset($rates[$country]['rate'])) {
            return new TaxRate(
                rate: $rates[$country]['rate'],
                name: $rates[$country]['name'],
            );
        }

        return new TaxRate(rate: 0, name: 'No Tax');
    }
}
```

### Tax Rate Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | Display name |
| `country` | `string` | ISO 3166-1 alpha-2 |
| `state` | `string?` | State/province code |
| `rate` | `int` | Rate in basis points (100 = 1%) |
| `tax_class` | `string?` | Product classification |
| `is_compound` | `bool` | Compound with other taxes |
| `applies_to` | `enum` | goods / services / digital / all |
| `is_active` | `bool` | |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Tax-Exempt Customers

### Exemption Management

```php
class TaxExemptionService
{
    public function setExempt(User $user, array $data): TaxExemption
    {
        return TaxExemption::create([
            'user_id' => $user->id,
            'type' => $data['type'], // 'resale', 'government', 'nonprofit', 'other'
            'certificate_number' => $data['certificate_number'],
            'certificate_url' => $data['certificate_url'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
            'reason' => $data['reason'] ?? null,
        ]);
    }

    public function validate(User $user): bool
    {
        $exemption = TaxExemption::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        if (!$exemption) {
            return false;
        }

        if ($exemption->expires_at && $exemption->expires_at->isPast()) {
            $exemption->update(['is_active' => false]);
            return false;
        }

        return true;
    }
}
```

### Exemption Types

| Type | Description | Documentation Required |
|------|-------------|----------------------|
| `resale` | Resale certificate | Resale certificate number |
| `government` | Government entity | Government ID |
| `nonprofit` | 501(c)(3) organization | EIN / registration |
| `diplomatic` | Diplomatic mission | Embassy letter |
| `other` | Other exemption | Custom documentation |

## VAT Compliance

### VAT Number Validation

```php
class VatValidator
{
    public function validate(string $countryCode, string $vatNumber): VatResult
    {
        $response = Http::post('https://api.vatlayer.com/validate', [
            'access_key' => config('services.vatlayer.key'),
            'vat_number' => $countryCode . $vatNumber,
        ]);

        $data = $response->json();

        return new VatResult(
            valid: $data['valid'] ?? false,
            name: $data['name'] ?? null,
            address: $data['address'] ?? null,
        );
    }
}
```

### EU VAT Rules

| Rule | Description |
|------|-------------|
| B2B reverse charge | No VAT charged, buyer self-assesses |
| B2C domestic | Charge customer's country VAT rate |
| B2C cross-border | Charge destination country VAT (OSS) |
| Digital services | Destination country rate from July 2021 |

### VAT on Invoices

```php
class VatInvoiceFormatter
{
    public function format(Invoice $invoice): array
    {
        $vatDetails = [];

        if ($invoice->user->vat_number) {
            $vatDetails = [
                'vat_number' => $invoice->user->vat_number,
                'vat_country' => $invoice->user->vat_country,
                'reverse_charge' => $this->isReverseCharge($invoice),
            ];
        }

        return [
            'invoice' => $invoice,
            'vat' => $vatDetails,
            'tax_breakdown' => $this->getBreakdown($invoice),
        ];
    }

    protected function isReverseCharge(Invoice $invoice): bool
    {
        return $invoice->user->vat_number
            && $invoice->user->billing_country !== config('app.country')
            && $this->isB2B($invoice);
    }
}
```

## Invoice Compliance

### Required Invoice Fields

| Field | Description | Example |
|-------|-------------|---------|
| Invoice number | Sequential unique ID | INV-2024-001 |
| Date of issue | When invoice was created | 2024-01-15 |
| Due date | Payment deadline | 2024-02-15 |
| Seller details | Company name, address, tax ID | Acme Inc, EIN: 12-3456789 |
| Buyer details | Customer name, address, tax ID | John Doe, VAT: DE123456789 |
| Line items | Description, quantity, unit price | 1x Pro Plan @ $29 |
| Subtotal | Before tax | $29.00 |
| Tax rate | Applicable tax rate | 19% MwSt |
| Tax amount | Calculated tax | $5.51 |
| Total | Final amount | $34.51 |

### Compliance Validation

```php
class InvoiceComplianceValidator
{
    public function validate(Invoice $invoice): array
    {
        $errors = [];

        if (!$invoice->number) {
            $errors[] = 'Invoice number is required';
        }

        if (!$invoice->created_at) {
            $errors[] = 'Invoice date is required';
        }

        if (!$invoice->billing_name) {
            $errors[] = 'Seller/buyer name is required';
        }

        if ($invoice->user->billing_country === 'EU' && !$invoice->user->vat_number) {
            $errors[] = 'VAT number required for EU customers';
        }

        return $errors;
    }
}
```

## Tax Reporting

### Tax Report Generation

```php
class TaxReportGenerator
{
    public function generate(Carbon $startDate, Carbon $endDate): TaxReport
    {
        $invoices = Invoice::where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->get();

        return new TaxReport(
            period: "{$startDate->format('Y-m')} to {$endDate->format('Y-m')}",
            total_sales: $invoices->sum('subtotal'),
            total_tax_collected: $invoices->sum('tax'),
            tax_by_country: $this->groupByCountry($invoices),
            tax_by_state: $this->groupByState($invoices),
            exemptions: $this->getExemptions($invoices),
        );
    }

    protected function groupByCountry(Collection $invoices): array
    {
        return $invoices->groupBy('user.billing_country')
            ->map(fn ($group) => [
                'sales' => $group->sum('subtotal'),
                'tax' => $group->sum('tax'),
                'count' => $group->count(),
            ])
            ->toArray();
    }
}
```

### Export Formats

| Format | Description | Use Case |
|--------|-------------|----------|
| CSV | Spreadsheet compatible | Manual filing |
| JSON | Programmatic access | API integration |
| PDF | Human-readable | Record keeping |
| XML | Government format | e.g., UK MTD |

## Configuration

```php
// config/taxes.php
return [
    'enabled' => true,

    'automatic' => [
        'enabled' => true,
        'resolve_by' => 'billing_address', // billing_address | shipping_address | origin
    ],

    'exemptions' => [
        'enabled' => true,
        'require_certificate' => true,
    ],

    'vat' => [
        'enabled' => env('VAT_ENABLED', false),
        'validation_api' => env('VAT_VALIDATION_API', 'vatlayer'),
    ],

    'reporting' => [
        'enabled' => true,
        'retention_years' => 7,
    ],
];
```

## Best Practices

1. **Always validate tax-exempt certificates** — don't trust user input
2. **Store tax rates per-invoice** — rates change over time
3. **Support reverse charge** — required for EU B2B transactions
4. **Generate compliant invoices** — include all required fields
5. **Keep tax records** for at least 7 years
6. **Use a tax service** (TaxJar, Avalara) for complex multi-jurisdiction needs
7. **Test with Playwright** — verify tax calculation in checkout
