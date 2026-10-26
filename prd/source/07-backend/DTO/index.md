# Data Transfer Objects

> Immutable DTOs for clean data passing between layers.

## Immutable DTOs

```php
// app/DTOs/CreateProductDTO
readonly class CreateProductDTO
{
    public function __construct(
        public string $name,
        public string $sku,
        public int $price,
        public ?string $description = null,
        public ?int $categoryId = null,
        public array $tags = [],
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            sku: $request->validated('sku'),
            price: $request->validated('price'),
            description: $request->validated('description'),
            categoryId: $request->validated('category_id'),
            tags: $request->validated('tags', []),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'tags' => $this->tags,
        ];
    }
}
```

## DTO Casting

```php
class UpdateProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $price,
        public readonly ?string $description,
        public readonly ProductStatus $status,
        public readonly Money $displayPrice,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            price: $data['price'],
            description: $data['description'] ?? null,
            status: ProductStatus::from($data['status']),
            displayPrice: Money::USD($data['price']),
        );
    }
}

// Enum for status
enum ProductStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Archived = 'archived';
}

// Money value object
class Money
{
    private function __construct(
        private int $amount,
        private string $currency
    ) {}

    public static function USD(int $cents): self
    {
        return new self($cents, 'USD');
    }

    public function formatted(): string
    {
        return '$' . number_format($this->amount / 100, 2);
    }
}
```

## Nested DTOs

```php
readonly class CreateOrderDTO
{
    public function __construct(
        public int $customerId,
        public array $items,      // CreateOrderItemDTO[]
        public ?string $notes = null,
        public ?Money $discount = null,
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            customerId: $request->validated('customer_id'),
            items: collect($request->validated('items'))
                ->map(fn ($item) => new CreateOrderItemDTO(
                    productId: $item['product_id'],
                    quantity: $item['quantity'],
                    unitPrice: Money::USD($item['unit_price']),
                ))
                ->toArray(),
            notes: $request->validated('notes'),
            discount: $request->validated('discount')
                ? Money::USD($request->validated('discount'))
                : null,
        );
    }

    public function subtotal(): Money
    {
        return collect($this->items)
            ->reduce(
                fn ($total, $item) => $total->add($item->unitPrice->multiply($item->quantity)),
                Money::USD(0)
            );
    }

    public function total(): Money
    {
        return $this->subtotal()->subtract($this->discount ?? Money::USD(0));
    }
}

readonly class CreateOrderItemDTO
{
    public function __construct(
        public int $productId,
        public int $quantity,
        public Money $unitPrice,
    ) {}

    public function lineTotal(): Money
    {
        return $this->unitPrice->multiply($this->quantity);
    }
}
```

## Collection DTOs

```php
readonly class ProductListDTO
{
    public function __construct(
        public array $products,      // ProductDTO[]
        public int $total,
        public int $currentPage,
        public int $lastPage,
    ) {}

    public static function fromPaginator(LengthAwarePaginator $paginator): self
    {
        return new self(
            products: collect($paginator->items())
                ->map(fn ($product) => ProductDTO::fromModel($product))
                ->toArray(),
            total: $paginator->total(),
            currentPage: $paginator->currentPage(),
            lastPage: $paginator->lastPage(),
        );
    }

    public function toArray(): array
    {
        return [
            'data' => array_map(fn ($p) => $p->toArray(), $this->products),
            'meta' => [
                'total' => $this->total,
                'current_page' => $this->currentPage,
                'last_page' => $this->lastPage,
            ],
        ];
    }
}

readonly class ProductDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $sku,
        public Money $price,
        public string $status,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            sku: $product->sku,
            price: Money::USD($product->price),
            status: $product->status,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price->formatted(),
            'status' => $this->status,
        ];
    }
}
```

## Validation

```php
class CreateProductDTO
{
    public static function validate(array $data): array
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:50'],
        ])->validated();
    }
}
```

## DTO Usage in Actions

```php
class CreateProductAction
{
    public function execute(CreateProductDTO $dto): Product
    {
        $product = Product::create($dto->toArray());

        ProductCreated::dispatch($product);

        return $product;
    }
}

// Controller
class StoreProductController extends Controller
{
    public function __invoke(StoreProductRequest $request): Product
    {
        $dto = new CreateProductDTO(...$request->validated());

        return app(CreateProductAction::class)->execute($dto);
    }
}
```

## DTO Comparison

| Feature | Array | Object | DTO |
|---|---|---|---|
| Immutability | No | Optional | Yes |
| Type safety | No | Partial | Full |
| IDE support | Minimal | Full | Full |
| Validation | Manual | Manual | Built-in |
| Serialization | Manual | Manual | Built-in |
