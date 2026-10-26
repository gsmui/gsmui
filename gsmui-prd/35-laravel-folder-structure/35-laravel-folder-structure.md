# 35 — Laravel Folder Structure

## Purpose

Define the Laravel application folder structure for GsmUi, following DDD principles and Laravel conventions.

## Root Structure

```text
gsmui/
├── app/
│   ├── Actions/
│   ├── Console/
│   ├── Events/
│   ├── Exceptions/
│   ├── Helpers/
│   ├── Http/
│   ├── Jobs/
│   ├── Listeners/
│   ├── Mail/
│   ├── Models/
│   ├── Observers/
│   ├── Policies/
│   ├── Providers/
│   ├── Services/
│   └── View/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docs/
├── lang/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
├── storage/
├── stubs/
├── tests/
│   ├── Browser/
│   ├── Feature/
│   └── Unit/
└── vendor/
```

## App Structure

### Actions

```text
app/Actions/
├── Auth/
│   ├── AuthenticateUser.php
│   ├── CreateNewUser.php
│   ├── ResetUserPassword.php
│   └── UpdateUserPassword.php
├── Billing/
│   ├── CreateOrder.php
│   ├── ProcessPayment.php
│   └── HandleWebhook.php
├── Marketplace/
│   ├── CreateProduct.php
│   ├── PublishProduct.php
│   └── PurchaseProduct.php
└── Settings/
    ├── UpdateProfile.php
    ├── UpdatePassword.php
    └── DeleteAccount.php
```

### Models

```text
app/Models/
├── User.php
├── Theme.php
├── Component.php
├── Template.php
├── Order.php
├── Product.php
├── License.php
├── Subscription.php
├── Invoice.php
├── Payment.php
├── Review.php
├── BlogPost.php
├── Documentation.php
└── ...
```

### Services

```text
app/Services/
├── Auth/
│   ├── AuthService.php
│   └── SessionService.php
├── Billing/
│   ├── OrderService.php
│   ├── PaymentService.php
│   └── SubscriptionService.php
├── Marketplace/
│   ├── ProductService.php
│   ├── DownloadService.php
│   └── LicenseService.php
└── Search/
    └── SearchService.php
```

### Http

```text
app/Http/
├── Controllers/
│   ├── Auth/
│   ├── Admin/
│   ├── Api/
│   ├── Billing/
│   ├── Marketplace/
│   └── Profile/
├── Middleware/
│   ├── AdminMiddleware.php
│   ├── ApiMiddleware.php
│   ├── SecurityHeaders.php
│   └── ...
└── Requests/
    ├── Auth/
    ├── Billing/
    ├── Marketplace/
    └── ...
```

### Livewire

```text
app/Livewire/
├── Admin/
│   ├── Dashboard.php
│   ├── Users.php
│   └── Themes.php
├── Auth/
│   ├── Login.php
│   ├── Register.php
│   └── ForgotPassword.php
├── Billing/
│   ├── Checkout.php
│   ├── Invoices.php
│   └── Subscription.php
├── Marketplace/
│   ├── ProductList.php
│   ├── ProductDetail.php
│   └── Checkout.php
└── Profile/
    ├── Settings.php
    ├── Security.php
    └── Sessions.php
```

## Config Structure

```text
config/
├── app.php
├── auth.php
├── cache.php
├── database.php
├── filesystems.php
├── fortify.php
├── hashing.php
├── horizon.php
├── logging.php
├── mail.php
├── permission.php
├── queue.php
├── sanctum.php
├── services.php
├── session.php
└── ...
```

## Routes Structure

```text
routes/
├── admin.php
├── api.php
├── auth.php
├── billing.php
├── console.php
├── marketplace.php
├── profile.php
├── web.php
└── ...
```
