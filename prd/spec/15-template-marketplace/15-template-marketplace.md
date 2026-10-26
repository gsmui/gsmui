# 15 - Template Marketplace

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The Template Marketplace is the commercial backbone of GsmUi's template ecosystem. It enables creators to sell production-ready Laravel templates and developers to purchase, preview, and install complete application scaffolds.

---

# Vision

Become the largest and most trusted marketplace for Laravel application templates, providing developers with instant access to production-ready starting points.

---

# Core Features

## For Buyers

* Browse templates by category
* Live preview
* Detailed descriptions
* Version history
* Reviews and ratings
* One-click purchase
* Instant download
* License management
* Update notifications

## For Creators

* Template submission portal
* Revenue dashboard
* Analytics
* Payout management
* Version management
* Support tools

## For Admin

* Content moderation
* Revenue management
* Creator management
* Quality standards
* Dispute resolution

---

# Template Categories

```text
Template Marketplace

├── SaaS Applications
│   ├── CRM
│   ├── ERP
│   ├── Project Management
│   ├── Help Desk
│   └── Analytics Dashboard
├── E-commerce
│   ├── Full Store
│   ├── Digital Products
│   ├── Subscription Box
│   └── Marketplace
├── Landing Pages
│   ├── Startup
│   ├── Product
│   ├── App
│   ├── Portfolio
│   └── Coming Soon
├── Admin Panels
│   ├── Classic
│   ├── Modern
│   ├── Minimal
│   └── Dark
├── Dashboards
│   ├── Analytics
│   ├── Finance
│   ├── Marketing
│   ├── HR
│   └── Custom
├── Blogs
│   ├── Personal
│   ├── Magazine
│   ├── Tech
│   └── Minimal
├── Portfolios
│   ├── Developer
│   ├── Designer
│   ├── Agency
│   └── Creative
└── Starter Kits
    ├── Basic
    ├── Pro
    └── Enterprise
```

---

# Template Structure

Every template should include:

```text
template-slug/

├── README.md
├── composer.json
├── .env.example
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
├── config/
├── docs/
│   ├── installation.md
│   ├── customization.md
│   └── deployment.md
└── preview/
    ├── screenshots/
    └── demo-url.txt
```

---

# Template Metadata

```yaml
name: SaaS Starter Kit
slug: saas-starter
version: 1.2.0
author: gsmui
category: saas
price: 49.00
currency: USD
license: single-project
description: "Complete SaaS starter with authentication, billing, and dashboard"
features:
  - Authentication
  - Billing (Stripe)
  - User Dashboard
  - Admin Panel
  - API Ready
  - Dark Mode
  - Responsive
requirements:
  php: ">=8.2"
  laravel: ">=11.0"
tags:
  - saas
  - starter
  - billing
  - dashboard
preview_url: https://demo.gsmui.com/saas-starter
support_url: https://support.gsmui.com
changelog:
  - version: 1.2.0
    date: 2024-01-15
    changes:
      - Updated to Laravel 11
      - Added team management
      - Improved performance
```

---

# Pricing Models

| Model | Description | Use Case |
|-------|-------------|----------|
| Free | $0 | Community templates |
| One-time | Single purchase | Premium templates |
| Bundle | Multiple templates | Template packs |
| Subscription | Monthly/Annual | All-access pass |

---

# Revenue Model

## Commission Structure

| Tier | Commission | Requirements |
|------|------------|--------------|
| Standard | 30% | Default |
| Pro Creator | 20% | 10+ sales |
| Elite | 15% | 50+ sales |
| Partner | 10% | Invitation only |

## Payout Schedule

* Monthly payouts (1st of month)
* $50 minimum threshold
* PayPal, Stripe Connect, Bank Transfer

---

# Template Submission Process

```text
Creator submits template
    ↓
Automated checks
    ├── Code quality
    ├── Security scan
    ├── Performance test
    └── Documentation check
    ↓
Manual review
    ├── Code review
    ├── Design review
    ├── Documentation review
    └── Compatibility test
    ↓
Approval / Rejection with feedback
    ↓
Published to marketplace
    ↓
Promoted in featured section
```

---

# Quality Standards

## Code Requirements

* PSR-12 coding standards
* Laravel best practices
* No security vulnerabilities
* Optimized database queries
* Proper error handling
* Comprehensive documentation

## Design Requirements

* Responsive design
* Dark mode support
* Accessibility (WCAG 2.2 AA)
* Cross-browser compatibility
* Performance optimized

## Documentation Requirements

* Installation guide
* Customization guide
* Deployment guide
* Changelog
* License information

---

# Search & Discovery

## Search Features

* Full-text search
* Category filtering
* Price range filter
* Rating filter
* Feature tags
* Sort by relevance/popularity/newest/price

## Recommendation Engine

* Related templates
* Frequently bought together
* Trending templates
* Editor's picks
* New releases

---

# Purchase Flow

```text
Browse templates
    ↓
View template details
    ├── Screenshots
    ├── Live preview
    ├── Description
    ├── Features
    ├── Requirements
    ├── Reviews
    └── Changelog
    ↓
Add to cart / Buy now
    ↓
Checkout
    ├── Payment method
    ├── License selection
    └── Apply coupon
    ↓
Payment processing
    ↓
License generation
    ↓
Download access
    ↓
Installation instructions
```

---

# License Types

| License | Projects | Support | Updates |
|---------|----------|---------|---------|
| Personal | 1 | 6 months | 6 months |
| Professional | 5 | 12 months | 12 months |
| Agency | Unlimited | Lifetime | Lifetime |

---

# Creator Tools

## Dashboard

* Sales analytics
* Revenue tracking
* Customer insights
* Review management
* Version management
* Payout history

## Submission Tools

* Template validator
* Preview generator
* Documentation builder
* Version manager
* Pricing tools

---

# Review System

## Review Structure

```text
Review

├── Rating (1-5 stars)
├── Title
├── Content
├── Pros
├── Cons
├── Use Case
├── Verified Purchase
├── Helpful Votes
└── Response from Creator
```

## Review Moderation

* Automated spam detection
* Manual moderation queue
* Creator response system
* Dispute resolution

---

# Technical Architecture

```text
Frontend (Livewire)
    ↓
API Layer (Sanctum)
    ↓
Marketplace Service
    ├── Catalog Service
    ├── Search Service
    ├── Payment Service
    ├── License Service
    └── Download Service
    ↓
Database (MySQL)
Storage (S3)
Cache (Redis)
Search (Meilisearch)
```

---

# Database Schema

Key tables:

* `marketplace_products` — Template listings
* `marketplace_categories` — Product categories
* `marketplace_orders` — Purchase orders
* `marketplace_licenses` — Generated licenses
* `marketplace_reviews` — User reviews
* `marketplace_downloads` — Download tracking
* `marketplace_payouts` — Creator payouts

---

# Admin Features

* Product management
* Category management
* Order management
* Revenue analytics
* Creator management
* Quality control
* Dispute resolution
* Featured content

---

# Marketing Features

* Featured templates
* Category spotlights
* Creator interviews
* Seasonal promotions
* Bundle deals
* Email campaigns
* Social sharing

---

# Success Metrics

* 1,000+ templates
* 500+ creators
* 10,000+ sales/month
* 4.5+ average rating
* <2% refund rate

---

# Detailed Submission Process

## Submission Workflow

```text
Creator initiates submission
    ↓
Fills template information
    ├── Basic info (name, description, category)
    ├── Features list
    ├── Requirements
    ├── Pricing
    └── Preview images
    ↓
Uploads template package
    ├── ZIP file upload
    ├── File validation
    ├── Size check (max 100MB)
    └── Virus scan
    ↓
Automated validation
    ├── Code quality analysis
    ├── Security vulnerability scan
    ├── Performance benchmarking
    ├── Documentation completeness
    ├── License verification
    └── Compatibility testing
    ↓
Preview generation
    ├── Screenshot capture
    ├── Demo page creation
    └── Feature extraction
    ↓
Manual review queue
    ├── Code review (1-2 days)
    ├── Design review (1 day)
    ├── Documentation review (1 day)
    └── Final approval
    ↓
Published to marketplace
    ↓
Featured consideration
```

## Submission Form Structure

```php
class TemplateSubmission
{
    public function getFormFields(): array
    {
        return [
            'basic' => [
                'name' => 'required|string|max:100',
                'slug' => 'required|string|max:100|unique:marketplace_products',
                'tagline' => 'required|string|max:200',
                'description' => 'required|string|max:5000',
                'category' => 'required|exists:marketplace_categories,id',
                'subcategory' => 'sometimes|exists:marketplace_categories,id',
            ],
            'pricing' => [
                'price' => 'required|numeric|min:0|max:9999.99',
                'currency' => 'required|in:USD,EUR,GBP',
                'license_type' => 'required|in:personal,professional,agency',
                'bundle_id' => 'sometimes|exists:marketplace_bundles,id',
            ],
            'features' => [
                'features' => 'required|array|min:3',
                'features.*' => 'string|max:100',
                'requirements' => 'required|array',
                'php_version' => 'required|string',
                'laravel_version' => 'required|string',
                'database' => 'sometimes|string',
            ],
            'preview' => [
                'screenshots' => 'required|array|min:3|max:10',
                'screenshots.*' => 'image|max:5120',
                'demo_url' => 'sometimes|url',
                'video_url' => 'sometimes|url',
            ],
            'package' => [
                'zip_file' => 'required|file|max:102400',
                'documentation' => 'required|string',
                'changelog' => 'required|string',
                'installation_guide' => 'required|string',
            ],
            'support' => [
                'support_url' => 'required|url',
                'support_email' => 'required|email',
                'documentation_url' => 'sometimes|url',
                'repository_url' => 'sometimes|url',
            ],
        ];
    }
}
```

## Automated Validation Pipeline

```php
class SubmissionValidator
{
    public function validate(TemplateSubmission $submission): ValidationResult
    {
        $results = [];
        
        $results[] = $this->validateCodeQuality($submission);
        $results[] = $this->validateSecurity($submission);
        $results[] = $this->validatePerformance($submission);
        $results[] = $this->validateDocumentation($submission);
        $results[] = $this->validateCompatibility($submission);
        $results[] = $this->validateLicense($submission);
        
        return new ValidationResult($results);
    }
    
    private function validateCodeQuality(TemplateSubmission $submission): CheckResult
    {
        $zipPath = $submission->getZipPath();
        $extractPath = $this->extractTemp($zipPath);
        
        $phpcs = new PHP_CodeSniffer();
        $phpcs->initStandard('PSR12');
        
        $report = $phpcs->processFiles($this->getPhpFiles($extractPath));
        
        $issues = [];
        foreach ($report->errors as $file => $errors) {
            foreach ($errors as $line => $lineErrors) {
                foreach ($lineErrors as $error) {
                    $issues[] = [
                        'file' => $file,
                        'line' => $line,
                        'message' => $error['message'],
                        'severity' => $error['severity'],
                    ];
                }
            }
        }
        
        $this->cleanup($extractPath);
        
        return new CheckResult(
            'code_quality',
            empty($issues),
            $issues,
            $this->calculateCodeScore($issues)
        );
    }
    
    private function validateSecurity(TemplateSubmission $submission): CheckResult
    {
        $zipPath = $submission->getZipPath();
        $extractPath = $this->extractTemp($zipPath);
        
        $vulnerabilities = [];
        
        // Check for SQL injection vulnerabilities
        $sqlInjection = $this->scanSqlInjection($extractPath);
        $vulnerabilities = array_merge($vulnerabilities, $sqlInjection);
        
        // Check for XSS vulnerabilities
        $xss = $this->scanXss($extractPath);
        $vulnerabilities = array_merge($vulnerabilities, $xss);
        
        // Check for CSRF vulnerabilities
        $csrf = $this->scanCsrf($extractPath);
        $vulnerabilities = array_merge($vulnerabilities, $csrf);
        
        // Check for hardcoded secrets
        $secrets = $this->scanSecrets($extractPath);
        $vulnerabilities = array_merge($vulnerabilities, $secrets);
        
        // Check for insecure file permissions
        $permissions = $this->scanPermissions($extractPath);
        $vulnerabilities = array_merge($vulnerabilities, $permissions);
        
        $this->cleanup($extractPath);
        
        return new CheckResult(
            'security',
            empty($vulnerabilities),
            $vulnerabilities,
            $this->calculateSecurityScore($vulnerabilities)
        );
    }
    
    private function validatePerformance(TemplateSubmission $submission): CheckResult
    {
        $zipPath = $submission->getZipPath();
        $extractPath = $this->extractTemp($zipPath);
        
        $metrics = [];
        
        // Check bundle size
        $bundleSize = $this->calculateBundleSize($extractPath);
        $metrics['bundle_size'] = $bundleSize;
        
        // Check for optimized assets
        $optimized = $this->checkAssetOptimization($extractPath);
        $metrics['asset_optimization'] = $optimized;
        
        // Check database queries
        $queryCount = $this->estimateQueryCount($extractPath);
        $metrics['estimated_queries'] = $queryCount;
        
        // Check for N+1 queries
        $nPlusOne = $this->scanNPlusOne($extractPath);
        $metrics['n_plus_one_issues'] = $nPlusOne;
        
        $this->cleanup($extractPath);
        
        return new CheckResult(
            'performance',
            $this->meetsPerformanceThresholds($metrics),
            $metrics,
            $this->calculatePerformanceScore($metrics)
        );
    }
    
    private function validateDocumentation(TemplateSubmission $submission): CheckResult
    {
        $zipPath = $submission->getZipPath();
        $extractPath = $this->extractTemp($zipPath);
        
        $docs = [];
        
        // Check for README.md
        $readme = $this->checkReadme($extractPath);
        $docs['readme'] = $readme;
        
        // Check for installation guide
        $installation = $this->checkInstallationGuide($extractPath);
        $docs['installation'] = $installation;
        
        // Check for customization guide
        $customization = $this->checkCustomizationGuide($extractPath);
        $docs['customization'] = $customization;
        
        // Check for deployment guide
        $deployment = $this->checkDeploymentGuide($extractPath);
        $docs['deployment'] = $deployment;
        
        // Check for changelog
        $changelog = $this->checkChangelog($extractPath);
        $docs['changelog'] = $changelog;
        
        $this->cleanup($extractPath);
        
        return new CheckResult(
            'documentation',
            $this->meetsDocumentationRequirements($docs),
            $docs,
            $this->calculateDocumentationScore($docs)
        );
    }
    
    private function validateCompatibility(TemplateSubmission $submission): CheckResult
    {
        $requirements = $submission->getRequirements();
        
        $compatibility = [];
        
        // Check PHP version compatibility
        $phpCompat = $this->checkPhpCompatibility($requirements['php_version']);
        $compatibility['php'] = $phpCompat;
        
        // Check Laravel version compatibility
        $laravelCompat = $this->checkLaravelCompatibility($requirements['laravel_version']);
        $compatibility['laravel'] = $laravelCompat;
        
        // Check database compatibility
        if (isset($requirements['database'])) {
            $dbCompat = $this->checkDatabaseCompatibility($requirements['database']);
            $compatibility['database'] = $dbCompat;
        }
        
        return new CheckResult(
            'compatibility',
            $this->allCompatible($compatibility),
            $compatibility,
            $this->calculateCompatibilityScore($compatibility)
        );
    }
}
```

## Preview Generation

```php
class PreviewGenerator
{
    public function generatePreviews(TemplateSubmission $submission): array
    {
        $screenshots = [];
        
        // Extract template
        $extractPath = $this->extractTemplate($submission->getZipPath());
        
        // Set up temporary Laravel app
        $app = $this->setupTempApp($extractPath);
        
        // Install dependencies
        $this->installDependencies($app);
        
        // Run migrations and seeders
        $this->setupDatabase($app);
        
        // Start development server
        $server = $this->startServer($app);
        
        // Capture screenshots
        $screenshots[] = $this->captureScreenshot($server, 'homepage', [
            'viewport' => ['width' => 1920, 'height' => 1080],
        ]);
        
        $screenshots[] = $this->captureScreenshot($server, 'dashboard', [
            'viewport' => ['width' => 1920, 'height' => 1080],
        ]);
        
        $screenshots[] = $this->captureScreenshot($server, 'login', [
            'viewport' => ['width' => 1920, 'height' => 1080],
        ]);
        
        // Mobile screenshots
        $screenshots[] = $this->captureScreenshot($server, 'homepage', [
            'viewport' => ['width' => 375, 'height' => 812],
        ]);
        
        // Stop server
        $this->stopServer($server);
        
        // Cleanup
        $this->cleanup($extractPath);
        
        return $screenshots;
    }
    
    private function captureScreenshot(string $serverUrl, string $page, array $options): array
    {
        $browser = (new BrowserFactory)->createBrowser([
            'headless' => true,
            'windowSize' => $options['viewport'],
        ]);
        
        $page = $browser->openPage($serverUrl . '/' . $page);
        
        $page->waitForLoad();
        
        $screenshot = $page->screenshot([
            'quality' => 80,
            'type' => 'png',
        ]);
        
        $path = 'previews/' . Str::uuid() . '.png';
        Storage::disk('s3')->put($path, $screenshot);
        
        return [
            'url' => Storage::disk('s3')->url($path),
            'page' => $page,
            'viewport' => $options['viewport'],
            'width' => $options['viewport']['width'],
            'height' => $options['viewport']['height'],
        ];
    }
}
```

---

# Payment Processing

## Payment Flow

```text
Buyer clicks "Buy Now"
    ↓
Checkout page loaded
    ├── License selection
    ├── Coupon code input
    └── Payment method selection
    ↓
Payment details entered
    ↓
Payment processed
    ├── Stripe charge created
    ├── Payment confirmation
    └── Receipt generated
    ↓
Order created
    ├── License generated
    ├── Download access granted
    └── Email confirmation sent
    ↓
Creator notified
    ├── Sale notification
    ├── Revenue updated
    └── Payout scheduled
```

## Payment Service

```php
class PaymentService
{
    public function __construct(
        private StripeClient $stripe,
        private LicenseService $licenseService,
        private EmailService $emailService
    ) {}
    
    public function processPayment(Order $order, PaymentMethod $paymentMethod): PaymentResult
    {
        try {
            // Create Stripe charge
            $charge = $this->stripe->charges->create([
                'amount' => $order->getAmountInCents(),
                'currency' => $order->currency,
                'customer' => $order->user->stripe_customer_id,
                'payment_method' => $paymentMethod->stripe_id,
                'description' => "GsmUi Template: {$order->product->name}",
                'metadata' => [
                    'order_id' => $order->id,
                    'product_id' => $order->product_id,
                    'user_id' => $order->user_id,
                ],
            ]);
            
            // Update order status
            $order->update([
                'status' => 'completed',
                'stripe_charge_id' => $charge->id,
                'paid_at' => now(),
            ]);
            
            // Generate license
            $license = $this->licenseService->generate($order);
            
            // Send confirmation email
            $this->emailService->sendOrderConfirmation($order, $license);
            
            // Notify creator
            $this->notifyCreator($order);
            
            return new PaymentResult(true, $charge->id, $license);
            
        } catch (CardException $e) {
            $order->update(['status' => 'failed']);
            return new PaymentResult(false, null, null, $e->getMessage());
        }
    }
    
    public function processRefund(Order $order, string $reason): RefundResult
    {
        try {
            $refund = $this->stripe->refunds->create([
                'charge' => $order->stripe_charge_id,
                'reason' => $reason,
            ]);
            
            $order->update([
                'status' => 'refunded',
                'refund_id' => $refund->id,
                'refunded_at' => now(),
            ]);
            
            $this->licenseService->revoke($order->license);
            
            $this->emailService->sendRefundConfirmation($order);
            
            return new RefundResult(true, $refund->id);
            
        } catch (\Exception $e) {
            return new RefundResult(false, null, $e->getMessage());
        }
    }
    
    public function processPayout(Creator $creator, PayoutBatch $batch): PayoutResult
    {
        $earnings = $creator->getUnpaidEarnings();
        
        if ($earnings < 50) {
            return new PayoutResult(false, null, 'Minimum payout threshold not met');
        }
        
        try {
            $transfer = $this->stripe->transfers->create([
                'amount' => $earnings->getAmountInCents(),
                'currency' => 'usd',
                'destination' => $creator->stripe_account_id,
                'description' => "GsmUi Payout - {$batch->period}",
            ]);
            
            // Record payout
            Payout::create([
                'creator_id' => $creator->id,
                'amount' => $earnings,
                'stripe_transfer_id' => $transfer->id,
                'status' => 'completed',
                'paid_at' => now(),
            ]);
            
            // Update creator earnings
            $creator->markEarningsPaid($earnings);
            
            return new PayoutResult(true, $transfer->id);
            
        } catch (\Exception $e) {
            return new PayoutResult(false, null, $e->getMessage());
        }
    }
}
```

## Stripe Integration

```php
class StripeService
{
    public function createCustomer(User $user): string
    {
        $customer = $this->stripe->customers->create([
            'email' => $user->email,
            'name' => $user->name,
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);
        
        $user->update(['stripe_customer_id' => $customer->id]);
        
        return $customer->id;
    }
    
    public function createPaymentIntent(Order $order): array
    {
        $intent = $this->stripe->paymentIntents->create([
            'amount' => $order->getAmountInCents(),
            'currency' => $order->currency,
            'customer' => $order->user->stripe_customer_id,
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);
        
        return [
            'client_secret' => $intent->client_secret,
            'intent_id' => $intent->id,
        ];
    }
    
    public function createConnectAccount(Creator $creator): string
    {
        $account = $this->stripe->accounts->create([
            'type' => 'express',
            'email' => $creator->email,
            'metadata' => [
                'creator_id' => $creator->id,
            ],
        ]);
        
        $creator->update(['stripe_account_id' => $account->id]);
        
        return $account->id;
    }
    
    public function createAccountLink(Creator $creator): string
    {
        $accountLink = $this->stripe->accountLinks->create([
            'account' => $creator->stripe_account_id,
            'refresh_url' => route('creator.stripe.refresh'),
            'return_url' => route('creator.stripe.return'),
            'type' => 'account_onboarding',
        ]);
        
        return $accountLink->url;
    }
}
```

---

# License Management

## License Generation

```php
class LicenseService
{
    public function generate(Order $order): License
    {
        $licenseKey = $this->generateKey();
        
        $license = License::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'product_id' => $order->product_id,
            'license_key' => $licenseKey,
            'type' => $order->license_type,
            'status' => 'active',
            'expires_at' => $this->calculateExpiryDate($order->license_type),
            'activations' => 0,
            'max_activations' => $this->getMaxActivations($order->license_type),
        ]);
        
        return $license;
    }
    
    private function generateKey(): string
    {
        $prefix = 'GSMUI';
        $segments = [];
        
        for ($i = 0; $i < 4; $i++) {
            $segments[] = strtoupper(bin2hex(random_bytes(4)));
        }
        
        return $prefix . '-' . implode('-', $segments);
    }
    
    private function getMaxActivations(string $type): int
    {
        return match ($type) {
            'personal' => 1,
            'professional' => 5,
            'agency' => PHP_INT_MAX,
        };
    }
    
    private function calculateExpiryDate(string $type): Carbon
    {
        return match ($type) {
            'personal' => now()->addMonths(6),
            'professional' => now()->addYear(),
            'agency' => now()->addYears(10),
        };
    }
    
    public function activate(string $licenseKey, string $domain): ActivationResult
    {
        $license = License::where('license_key', $licenseKey)->first();
        
        if (!$license) {
            return new ActivationResult(false, 'Invalid license key');
        }
        
        if (!$license->isActive()) {
            return new ActivationResult(false, 'License is not active');
        }
        
        if ($license->activations >= $license->max_activations) {
            return new ActivationResult(false, 'Maximum activations reached');
        }
        
        $activation = Activation::create([
            'license_id' => $license->id,
            'domain' => $domain,
            'activated_at' => now(),
        ]);
        
        $license->increment('activations');
        
        return new ActivationResult(true, null, $activation);
    }
    
    public function deactivate(string $licenseKey, string $domain): DeactivationResult
    {
        $license = License::where('license_key', $licenseKey)->first();
        
        if (!$license) {
            return new DeactivationResult(false, 'Invalid license key');
        }
        
        $activation = Activation::where('license_id', $license->id)
            ->where('domain', $domain)
            ->first();
        
        if (!$activation) {
            return new DeactivationResult(false, 'Domain not activated');
        }
        
        $activation->delete();
        
        $license->decrement('activations');
        
        return new DeactivationResult(true);
    }
    
    public function revoke(License $license): void
    {
        $license->update(['status' => 'revoked']);
        
        Activation::where('license_id', $license->id)->delete();
    }
}
```

## License Verification

```php
class LicenseVerifier
{
    public function verify(string $licenseKey, string $domain): VerificationResult
    {
        $license = License::where('license_key', $licenseKey)->first();
        
        if (!$license) {
            return new VerificationResult(false, 'License not found');
        }
        
        if ($license->status !== 'active') {
            return new VerificationResult(false, 'License is not active');
        }
        
        if ($license->expires_at && $license->expires_at->isPast()) {
            return new VerificationResult(false, 'License has expired');
        }
        
        $activation = Activation::where('license_id', $license->id)
            ->where('domain', $domain)
            ->first();
        
        if (!$activation) {
            return new VerificationResult(false, 'Domain not activated');
        }
        
        return new VerificationResult(true, null, [
            'license_key' => $license->license_key,
            'type' => $license->type,
            'expires_at' => $license->expires_at,
            'activations' => $license->activations,
            'max_activations' => $license->max_activations,
        ]);
    }
}
```

---

# Creator Tools

## Creator Dashboard

```php
class CreatorDashboard
{
    public function getMetrics(Creator $creator): array
    {
        return [
            'total_sales' => $this->getTotalSales($creator),
            'total_revenue' => $this->getTotalRevenue($creator),
            'pending_payout' => $this->getPendingPayout($creator),
            'active_products' => $this->getActiveProducts($creator),
            'average_rating' => $this->getAverageRating($creator),
            'total_reviews' => $this->getTotalReviews($creator),
        ];
    }
    
    public function getSalesChart(Creator $creator, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $sales = DB::table('marketplace_orders')
            ->join('marketplace_products', 'marketplace_products.id', '=', 'marketplace_orders.product_id')
            ->where('marketplace_products.creator_id', $creator->id)
            ->where('marketplace_orders.created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(marketplace_orders.created_at) as date'),
                DB::raw('COUNT(*) as sales'),
                DB::raw('SUM(marketplace_orders.amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return [
            'labels' => $sales->pluck('date'),
            'sales' => $sales->pluck('sales'),
            'revenue' => $sales->pluck('revenue'),
        ];
    }
    
    public function getProductAnalytics(Creator $creator): array
    {
        $products = Product::where('creator_id', $creator->id)->get();
        
        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sales' => $product->orders()->count(),
                'revenue' => $product->orders()->sum('amount'),
                'views' => $product->views,
                'conversion_rate' => $this->calculateConversionRate($product),
                'rating' => $product->averageRating(),
            ];
        })->toArray();
    }
    
    private function calculateConversionRate(Product $product): float
    {
        $views = $product->views;
        $sales = $product->orders()->count();
        
        return $views > 0 ? ($sales / $views) * 100 : 0;
    }
}
```

## Template Validator

```php
class TemplateValidator
{
    public function validateForSubmission(string $zipPath): ValidationResult
    {
        $extractPath = $this->extractTemp($zipPath);
        
        $errors = [];
        
        // Check required files
        $requiredFiles = [
            'README.md',
            'composer.json',
            '.env.example',
            'database/migrations',
            'resources/views',
            'routes',
        ];
        
        foreach ($requiredFiles as $file) {
            if (!file_exists($extractPath . '/' . $file)) {
                $errors[] = "Missing required file: {$file}";
            }
        }
        
        // Validate composer.json
        $composerJson = json_decode(file_get_contents($extractPath . '/composer.json'), true);
        if (!$composerJson) {
            $errors[] = 'Invalid composer.json';
        } else {
            if (!isset($composerJson['require']['php'])) {
                $errors[] = 'PHP version requirement missing in composer.json';
            }
            if (!isset($composerJson['require']['laravel/framework'])) {
                $errors[] = 'Laravel requirement missing in composer.json';
            }
        }
        
        // Check for .env.example
        if (file_exists($extractPath . '/.env.example')) {
            $envExample = file_get_contents($extractPath . '/.env.example');
            if (!str_contains($envExample, 'DB_')) {
                $errors[] = '.env.example missing database configuration';
            }
        }
        
        $this->cleanup($extractPath);
        
        return new ValidationResult(empty($errors), $errors);
    }
}
```

---

# Search & Discovery Details

## Search Implementation

```php
class MarketplaceSearch
{
    public function search(string $query, array $filters = []): SearchResult
    {
        $search = new SearchQuery();
        
        $search->setQuery($query)
            ->setAttributesToHighlight(['name', 'description', 'features'])
            ->setFilter($this->buildFilters($filters))
            ->setSort($this->buildSort($filters));
        
        $results = $this->meilisearch->index('marketplace_products')->search($search);
        
        return new SearchResult(
            $results['hits'],
            $results['nbHits'],
            $results['processingTimeMs']
        );
    }
    
    private function buildFilters(array $filters): array
    {
        $filterBuilder = FilterBuilder::and();
        
        if (isset($filters['category'])) {
            $filterBuilder->addFilter(
                Filter::attribute('category')->isEqualTo($filters['category'])
            );
        }
        
        if (isset($filters['min_price'], $filters['max_price'])) {
            $filterBuilder->addFilter(
                Filter::attribute('price')->between($filters['min_price'], $filters['max_price'])
            );
        }
        
        if (isset($filters['min_rating'])) {
            $filterBuilder->addFilter(
                Filter::attribute('rating')->gte($filters['min_rating'])
            );
        }
        
        if (isset($filters['features'])) {
            foreach ($filters['features'] as $feature) {
                $filterBuilder->addFilter(
                    Filter::attribute('features')->contains($feature)
                );
            }
        }
        
        return $filterBuilder->getFilters();
    }
    
    private function buildSort(array $filters): array
    {
        return match ($filters['sort'] ?? 'relevance') {
            'newest' => ['created_at:desc'],
            'oldest' => ['created_at:asc'],
            'price_low' => ['price:asc'],
            'price_high' => ['price:desc'],
            'rating' => ['rating:desc'],
            'popular' => ['sales:desc'],
            default => [],
        };
    }
}
```

## Recommendation Engine

```php
class RecommendationEngine
{
    public function getRelatedProducts(Product $product, int $limit = 6): array
    {
        $similarProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->withAvg('reviews', 'rating')
            ->withCount('orders')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('orders_count')
            ->limit($limit)
            ->get();
        
        return $similarProducts->toArray();
    }
    
    public function getFrequentlyBoughtTogether(Product $product, int $limit = 4): array
    {
        $orders = Order::where('product_id', $product->id)
            ->pluck('id');
        
        $relatedProducts = Order::whereIn('id', $orders)
            ->where('product_id', '!=', $product->id)
            ->select('product_id', DB::raw('COUNT(*) as count'))
            ->groupBy('product_id')
            ->orderByDesc('count')
            ->limit($limit)
            ->pluck('product_id');
        
        return Product::whereIn('id', $relatedProducts)->get()->toArray();
    }
    
    public function getTrendingProducts(int $limit = 10): array
    {
        return Cache::remember('trending_products', 3600, function () use ($limit) {
            return Product::where('status', 'published')
                ->where('created_at', '>=', now()->subDays(30))
                ->withCount('orders')
                ->orderByDesc('orders_count')
                ->limit($limit)
                ->get()
                ->toArray();
        });
    }
    
    public function getEditorsPicks(int $limit = 6): array
    {
        return Product::where('status', 'published')
            ->where('is_featured', true)
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
```

---

# Review System Details

## Review Structure

```php
class Review
{
    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'title',
        'content',
        'pros',
        'cons',
        'use_case',
        'verified_purchase',
    ];
    
    protected $casts = [
        'pros' => 'array',
        'cons' => 'array',
        'verified_purchase' => 'boolean',
    ];
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function responses(): HasMany
    {
        return $this->hasMany(ReviewResponse::class);
    }
    
    public function helpfulVotes(): HasMany
    {
        return $this->hasMany(HelpfulVote::class);
    }
    
    public function isHelpful(): bool
    {
        return $this->helpfulVotes()->where('is_helpful', true)->count() > 
               $this->helpfulVotes()->where('is_helpful', false)->count();
    }
}
```

## Review Moderation

```php
class ReviewModeration
{
    public function submitReview(Review $review): ModerationResult
    {
        // Automated checks
        $spamScore = $this->calculateSpamScore($review);
        $profanityCheck = $this->checkProfanity($review);
        $qualityScore = $this->calculateQualityScore($review);
        
        if ($spamScore > 0.8) {
            $review->update(['status' => 'spam']);
            return new ModerationResult(false, 'Review flagged as spam');
        }
        
        if ($profanityCheck->containsProfanity()) {
            $review->update(['status' => 'flagged']);
            return new ModerationResult(false, 'Review contains inappropriate content');
        }
        
        if ($qualityScore < 0.3) {
            $review->update(['status' => 'pending']);
            return new ModerationResult(true, null, 'low_quality');
        }
        
        $review->update(['status' => 'approved']);
        return new ModerationResult(true);
    }
    
    private function calculateSpamScore(Review $review): float
    {
        $score = 0;
        
        // Check for excessive links
        preg_match_all('/https?:\/\//', $review->content, $links);
        $score += count($links[0]) * 0.1;
        
        // Check for repeated characters
        if (preg_match('/(.)\1{4,}/', $review->content)) {
            $score += 0.3;
        }
        
        // Check for all caps
        if (strlen($review->content) > 20 && strtoupper($review->content) === $review->content) {
            $score += 0.4;
        }
        
        // Check user history
        $userReviewCount = Review::where('user_id', $review->user_id)->count();
        if ($userReviewCount > 10) {
            $score += 0.1;
        }
        
        return min($score, 1);
    }
}
```

---

# Technical Architecture Details

## Database Schema

```sql
-- Marketplace Products
CREATE TABLE marketplace_products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    creator_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    tagline VARCHAR(255),
    description TEXT,
    category_id BIGINT UNSIGNED NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    currency VARCHAR(3) NOT NULL DEFAULT 'USD',
    license_type ENUM('personal', 'professional', 'agency') NOT NULL,
    status ENUM('draft', 'pending', 'published', 'rejected', 'archived') NOT NULL DEFAULT 'draft',
    version VARCHAR(50) NOT NULL,
    demo_url VARCHAR(500),
    repository_url VARCHAR(500),
    features JSON,
    requirements JSON,
    download_count INT UNSIGNED NOT NULL DEFAULT 0,
    view_count INT UNSIGNED NOT NULL DEFAULT 0,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (creator_id) REFERENCES creators(id),
    FOREIGN KEY (category_id) REFERENCES marketplace_categories(id),
    INDEX idx_status (status),
    INDEX idx_category (category_id),
    INDEX idx_creator (creator_id),
    FULLTEXT INDEX ft_search (name, description)
);

-- Marketplace Orders
CREATE TABLE marketplace_orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    license_type ENUM('personal', 'professional', 'agency') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) NOT NULL DEFAULT 'USD',
    coupon_code VARCHAR(50),
    discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL,
    stripe_charge_id VARCHAR(255),
    stripe_payment_intent_id VARCHAR(255),
    status ENUM('pending', 'completed', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
    paid_at TIMESTAMP NULL,
    refunded_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES marketplace_products(id),
    INDEX idx_user (user_id),
    INDEX idx_product (product_id),
    INDEX idx_status (status)
);

-- Marketplace Licenses
CREATE TABLE marketplace_licenses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    license_key VARCHAR(255) NOT NULL UNIQUE,
    type ENUM('personal', 'professional', 'agency') NOT NULL,
    status ENUM('active', 'expired', 'revoked') NOT NULL DEFAULT 'active',
    expires_at TIMESTAMP NULL,
    activations INT UNSIGNED NOT NULL DEFAULT 0,
    max_activations INT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (order_id) REFERENCES marketplace_orders(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES marketplace_products(id),
    INDEX idx_license_key (license_key),
    INDEX idx_user (user_id),
    INDEX idx_product (product_id)
);

-- Marketplace Reviews
CREATE TABLE marketplace_reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    order_id BIGINT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL,
    title VARCHAR(255),
    content TEXT,
    pros JSON,
    cons JSON,
    use_case VARCHAR(255),
    verified_purchase BOOLEAN NOT NULL DEFAULT FALSE,
    status ENUM('pending', 'approved', 'flagged', 'spam') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES marketplace_products(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES marketplace_orders(id),
    INDEX idx_product (product_id),
    INDEX idx_user (user_id),
    INDEX idx_rating (rating)
);

-- Marketplace Payouts
CREATE TABLE marketplace_payouts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    creator_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) NOT NULL DEFAULT 'USD',
    stripe_transfer_id VARCHAR(255),
    status ENUM('pending', 'processing', 'completed', 'failed') NOT NULL DEFAULT 'pending',
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (creator_id) REFERENCES creators(id),
    INDEX idx_creator (creator_id),
    INDEX idx_status (status)
);
```

## API Endpoints

```php
// Products
Route::get('/api/marketplace/products', [ProductController::class, 'index']);
Route::get('/api/marketplace/products/{slug}', [ProductController::class, 'show']);
Route::post('/api/marketplace/products', [ProductController::class, 'store']);
Route::put('/api/marketplace/products/{id}', [ProductController::class, 'update']);
Route::delete('/api/marketplace/products/{id}', [ProductController::class, 'destroy']);

// Orders
Route::post('/api/marketplace/orders', [OrderController::class, 'store']);
Route::get('/api/marketplace/orders/{id}', [OrderController::class, 'show']);
Route::post('/api/marketplace/orders/{id}/refund', [OrderController::class, 'refund']);

// Licenses
Route::get('/api/marketplace/licenses', [LicenseController::class, 'index']);
Route::post('/api/marketplace/licenses/activate', [LicenseController::class, 'activate']);
Route::post('/api/marketplace/licenses/deactivate', [LicenseController::class, 'deactivate']);
Route::get('/api/marketplace/licenses/verify', [LicenseController::class, 'verify']);

// Reviews
Route::get('/api/marketplace/products/{id}/reviews', [ReviewController::class, 'index']);
Route::post('/api/marketplace/products/{id}/reviews', [ReviewController::class, 'store']);
Route::put('/api/marketplace/reviews/{id}', [ReviewController::class, 'update']);
Route::delete('/api/marketplace/reviews/{id}', [ReviewController::class, 'destroy']);

// Creator
Route::get('/api/creator/dashboard', [CreatorDashboardController::class, 'index']);
Route::get('/api/creator/products', [CreatorProductController::class, 'index']);
Route::post('/api/creator/products', [CreatorProductController::class, 'store']);
Route::get('/api/creator/payouts', [CreatorPayoutController::class, 'index']);
Route::post('/api/creator/payouts/request', [CreatorPayoutController::class, 'request']);
```

---

# User Flows

## Buyer Purchase Flow

```text
Buyer discovers template
    ↓
Views template details
    ├── Screenshots
    ├── Live demo
    ├── Description
    ├── Features
    ├── Requirements
    ├── Reviews
    └── Changelog
    ↓
Adds to cart / Buy now
    ↓
Checkout
    ├── Select license type
    ├── Enter coupon code
    ├── Choose payment method
    └── Review order
    ↓
Enter payment details
    ↓
Complete purchase
    ↓
Download template
    ↓
View installation guide
    ↓
Install template
    ↓
Leave review
```

## Creator Submission Flow

```text
Creator logs in
    ↓
Navigates to creator dashboard
    ↓
Clicks "Submit Template"
    ↓
Fills submission form
    ├── Basic information
    ├── Features and requirements
    ├── Pricing
    ├── Screenshots
    └── Documentation
    ↓
Uploads template package
    ↓
Previews submission
    ↓
Submits for review
    ↓
Waits for review (1-5 days)
    ↓
Receives approval/rejection
    ↓
If approved:
    ├── Template published
    ├── Listed in marketplace
    └── Starts receiving sales
If rejected:
    ├── Receives feedback
    ├── Makes corrections
    └── Resubmits
```

---

# Success Metrics Details

## Key Performance Indicators

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Total Templates | 500 | 1,000+ | Database count |
| Active Creators | 200 | 500+ | Database count |
| Monthly Sales | 5,000 | 10,000+ | Order count |
| Average Rating | 4.3 | 4.5+ | Review average |
| Refund Rate | 3% | <2% | Refund count / Order count |
| Submission Approval Rate | 70% | 80% | Approved / Submitted |
| Time to First Sale | 7 days | <3 days | Product creation to first order |
| Creator Retention | 60% | 75% | Monthly active creators |

## Revenue Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Gross Revenue | $50,000/month | $100,000+ | Sum of orders |
| Net Revenue | $35,000/month | $70,000+ | After commissions |
| Average Order Value | $45 | $55+ | Revenue / Orders |
| Creator Earnings | $35,000/month | $70,000+ | After platform fee |
| Payout Success Rate | 98% | 99.5% | Successful payouts / Total |

## User Satisfaction Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Buyer Satisfaction | 4.2/5 | 4.5/5 | Post-purchase survey |
| Creator Satisfaction | 4.0/5 | 4.5/5 | Creator survey |
| Support Response Time | 24 hours | <12 hours | Ticket system |
| Support Resolution Time | 48 hours | <24 hours | Ticket system |

---

# Admin Features Details

## Content Moderation Dashboard

```php
class ModerationDashboard
{
    public function getPendingSubmissions(): Collection
    {
        return Product::where('status', 'pending')
            ->with('creator')
            ->orderBy('created_at')
            ->get();
    }
    
    public function getFlaggedReviews(): Collection
    {
        return Review::where('status', 'flagged')
            ->with(['product', 'user'])
            ->orderBy('created_at')
            ->get();
    }
    
    public function getDisputeQueue(): Collection
    {
        return Dispute::where('status', 'open')
            ->with(['order', 'buyer', 'creator'])
            ->orderBy('created_at')
            ->get();
    }
    
    public function approveSubmission(Product $product, User $moderator): void
    {
        $product->update([
            'status' => 'published',
            'published_at' => now(),
            'approved_by' => $moderator->id,
        ]);
        
        Notification::send($product->creator, new ProductApprovedNotification($product));
    }
    
    public function rejectSubmission(Product $product, string $reason, User $moderator): void
    {
        $product->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'rejected_by' => $moderator->id,
        ]);
        
        Notification::send($product->creator, new ProductRejectedNotification($product, $reason));
    }
}
```

## Revenue Management

```php
class RevenueManagement
{
    public function getRevenueReport(string $period = 'monthly'): array
    {
        $startDate = $this->getStartDate($period);
        
        return [
            'gross_revenue' => $this->getGrossRevenue($startDate),
            'net_revenue' => $this->getNetRevenue($startDate),
            'platform_fees' => $this->getPlatformFees($startDate),
            'creator_payouts' => $this->getCreatorPayouts($startDate),
            'refunds' => $this->getRefunds($startDate),
            'outstanding_payouts' => $this->getOutstandingPayouts(),
        ];
    }
    
    public function getCreatorEarnings(Creator $creator, string $period = 'monthly'): array
    {
        $startDate = $this->getStartDate($period);
        
        $sales = Order::whereHas('product', fn ($q) => $q->where('creator_id', $creator->id))
            ->where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->get();
        
        $grossEarnings = $sales->sum('amount');
        $platformFee = $grossEarnings * ($creator->commission_rate / 100);
        $netEarnings = $grossEarnings - $platformFee;
        
        return [
            'gross_earnings' => $grossEarnings,
            'platform_fee' => $platformFee,
            'net_earnings' => $netEarnings,
            'total_sales' => $sales->count(),
            'average_sale' => $sales->avg('amount'),
        ];
    }
    
    public function processMonthlyPayouts(): void
    {
        $creators = Creator::where('balance', '>=', 50)->get();
        
        foreach ($creators as $creator) {
            $payout = new PayoutService();
            $result = $payout->processPayout($creator);
            
            if ($result->success) {
                Notification::send($creator, new PayoutProcessedNotification($result->amount));
            } else {
                Notification::send($creator, new PayoutFailedNotification($result->error));
            }
        }
    }
}
```

## Featured Content Management

```php
class FeaturedContentManager
{
    public function setFeaturedProducts(array $productIds): void
    {
        Product::query()->update(['is_featured' => false]);
        
        Product::whereIn('id', $productIds)->update(['is_featured' => true]);
        
        Cache::forget('featured_products');
    }
    
    public function getFeaturedProducts(): array
    {
        return Cache::remember('featured_products', 3600, function () {
            return Product::where('is_featured', true)
                ->where('status', 'published')
                ->with(['creator', 'reviews'])
                ->withAvg('reviews', 'rating')
                ->orderByDesc('reviews_avg_rating')
                ->limit(10)
                ->get()
                ->toArray();
        });
    }
    
    public function setCategorySpotlight(string $categoryId, Product $product): void
    {
        DB::table('marketplace_category_spotlights')->updateOrInsert(
            ['category_id' => $categoryId],
            [
                'product_id' => $product->id,
                'starts_at' => now(),
                'ends_at' => now()->addWeek(),
            ]
        );
        
        Cache::forget("category_spotlight_{$categoryId}");
    }
    
    public function createBundle(string $name, array $productIds, float $discountPercent): Bundle
    {
        $products = Product::whereIn('id', $productIds)->get();
        $originalPrice = $products->sum('price');
        $bundlePrice = $originalPrice * (1 - $discountPercent / 100);
        
        return Bundle::create([
            'name' => $name,
            'price' => $bundlePrice,
            'original_price' => $originalPrice,
            'discount_percent' => $discountPercent,
            'products' => $productIds,
        ]);
    }
}
```

---

# Marketing Features Details

## Email Campaign System

```php
class EmailCampaignService
{
    public function sendNewTemplateAlert(Product $product): void
    {
        $subscribers = Subscriber::where('preferences->categories', 'contains', $product->category)
            ->get();
        
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewTemplateMail($product));
        }
    }
    
    public function sendWeeklyDigest(): void
    {
        $subscribers = Subscriber::where('preferences->frequency', 'weekly')->get();
        
        $topProducts = Product::where('status', 'published')
            ->where('created_at', '>=', now()->subWeek())
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->limit(10)
            ->get();
        
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new WeeklyDigestMail($topProducts));
        }
    }
    
    public function sendSeasonalPromotion(Promotion $promotion): void
    {
        $subscribers = Subscriber::where('preferences->promotions', true)->get();
        
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new PromotionMail($promotion));
        }
    }
}
```

## Social Sharing

```php
class SocialSharingService
{
    public function getShareUrls(Product $product): array
    {
        $url = route('marketplace.product', $product->slug);
        $title = urlencode($product->name);
        $description = urlencode($product->tagline);
        
        return [
            'twitter' => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
            'reddit' => "https://reddit.com/submit?url={$url}&title={$title}",
            'hacker_news' => "https://news.ycombinator.com/submitlink?u={$url}&t={$title}",
        ];
    }
    
    public function generateEmbedCode(Product $product): string
    {
        $url = route('marketplace.product', $product->slug);
        
        return <<<HTML
        <div class="gsmui-marketplace-embed">
            <a href="{$url}" target="_blank" rel="noopener">
                <img src="{$product->getOGImage()}" alt="{$product->name}">
                <h3>{$product->name}</h3>
                <p>{$product->tagline}</p>
            </a>
        </div>
        HTML;
    }
    
    public function generateQrCode(Product $product): string
    {
        $url = route('marketplace.product', $product->slug);
        
        return QrCode::size(200)->generate($url);
    }
}
```

---

# API Contracts Details

## Marketplace API Specification

```yaml
openapi: 3.0.0
info:
  title: GsmUi Marketplace API
  version: 1.0.0
  description: API for the GsmUi Template Marketplace

paths:
  /api/marketplace/products:
    get:
      summary: List marketplace products
      tags: [Products]
      parameters:
        - name: category
          in: query
          schema:
            type: string
        - name: search
          in: query
          schema:
            type: string
        - name: min_price
          in: query
          schema:
            type: number
        - name: max_price
          in: query
          schema:
            type: number
        - name: min_rating
          in: query
          schema:
            type: number
        - name: sort
          in: query
          schema:
            type: string
            enum: [relevance, newest, price_low, price_high, rating, popular]
        - name: page
          in: query
          schema:
            type: integer
        - name: per_page
          in: query
          schema:
            type: integer
      responses:
        '200':
          description: Successful response
          content:
            application/json:
              schema:
                type: object
                properties:
                  data:
                    type: array
                    items:
                      $ref: '#/components/schemas/Product'
                  meta:
                    $ref: '#/components/schemas/PaginationMeta'
                  facets:
                    type: object
                    properties:
                      categories:
                        type: array
                        items:
                          type: object
                      price_range:
                        type: object
                      ratings:
                        type: array

  /api/marketplace/products/{slug}:
    get:
      summary: Get product details
      tags: [Products]
      parameters:
        - name: slug
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Successful response
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ProductDetail'
        '404':
          description: Product not found

  /api/marketplace/orders:
    post:
      summary: Create order
      tags: [Orders]
      security:
        - bearerAuth: []
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - product_id
                - license_type
                - payment_method_id
              properties:
                product_id:
                  type: integer
                license_type:
                  type: string
                  enum: [personal, professional, agency]
                payment_method_id:
                  type: string
                coupon_code:
                  type: string
      responses:
        '201':
          description: Order created
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Order'
        '422':
          description: Validation error

  /api/marketplace/licenses/verify:
    post:
      summary: Verify license
      tags: [Licenses]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - license_key
                - domain
              properties:
                license_key:
                  type: string
                domain:
                  type: string
      responses:
        '200':
          description: License valid
        '401':
          description: License invalid

components:
  schemas:
    Product:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        slug:
          type: string
        tagline:
          type: string
        description:
          type: string
        category:
          type: string
        price:
          type: number
        currency:
          type: string
        license_type:
          type: string
        rating:
          type: number
        review_count:
          type: integer
        download_count:
          type: integer
        preview_url:
          type: string
        created_at:
          type: string
          format: date-time

    ProductDetail:
      allOf:
        - $ref: '#/components/schemas/Product'
        - type: object
          properties:
            features:
              type: array
              items:
                type: string
            requirements:
              type: object
            screenshots:
              type: array
              items:
                type: object
                properties:
                  url:
                    type: string
                  caption:
                    type: string
            creator:
              $ref: '#/components/schemas/Creator'
            reviews:
              type: array
              items:
                $ref: '#/components/schemas/Review'
            related_products:
              type: array
              items:
                $ref: '#/components/schemas/Product'

    Order:
      type: object
      properties:
        id:
          type: integer
        product:
          $ref: '#/components/schemas/Product'
        license_type:
          type: string
        amount:
          type: number
        currency:
          type: string
        status:
          type: string
        download_url:
          type: string
        created_at:
          type: string
          format: date-time

    License:
      type: object
      properties:
        id:
          type: integer
        license_key:
          type: string
        type:
          type: string
        status:
          type: string
        expires_at:
          type: string
          format: date-time
        activations:
          type: integer
        max_activations:
          type: integer

    Creator:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        avatar:
          type: string
        bio:
          type: string
        product_count:
          type: integer
        average_rating:
          type: number

    Review:
      type: object
      properties:
        id:
          type: integer
        user:
          type: object
          properties:
            name:
              type: string
            avatar:
              type: string
        rating:
          type: integer
        title:
          type: string
        content:
          type: string
        pros:
          type: array
          items:
            type: string
        cons:
          type: array
          items:
            type: string
        verified_purchase:
          type: boolean
        helpful_count:
          type: integer
        created_at:
          type: string
          format: date-time

    PaginationMeta:
      type: object
      properties:
        current_page:
          type: integer
        last_page:
          type: integer
        per_page:
          type: integer
        total:
          type: integer

  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
```

---

# Next Document

**16 - Showcase** — Community project gallery and portfolio platform.
