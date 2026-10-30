<?php

declare(strict_types=1);

namespace App\Domains\CMS\Actions;

use App\Domains\CMS\Models\Menu;
use App\Domains\CMS\Models\MenuItem;
use App\Infrastructure\Cache\CacheService;

class ManageMenuAction
{
    public function __construct(
        protected CacheService $cache
    ) {}

    public function createMenu(array $data): Menu
    {
        $menu = Menu::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? \Str::slug($data['name']),
            'location' => $data['location'] ?? null,
        ]);

        $this->cache->invalidate('menus');

        return $menu;
    }

    public function updateMenu(Menu $menu, array $data): Menu
    {
        $menu->update($data);

        $this->cache->invalidate('menus');

        return $menu;
    }

    public function deleteMenu(Menu $menu): bool
    {
        $menu->items()->delete();
        $deleted = $menu->delete();

        $this->cache->invalidate('menus');

        return $deleted;
    }

    public function addItem(Menu $menu, array $data): MenuItem
    {
        $item = $menu->items()->create([
            'label' => $data['label'],
            'url' => $data['url'] ?? null,
            'route' => $data['route'] ?? null,
            'route_params' => $data['route_params'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $data['is_active'] ?? true,
            'target' => $data['target'] ?? null,
        ]);

        $this->cache->invalidate('menus');

        return $item;
    }

    public function updateItem(MenuItem $item, array $data): MenuItem
    {
        $item->update($data);

        $this->cache->invalidate('menus');

        return $item;
    }

    public function deleteItem(MenuItem $item): bool
    {
        $item->children()->delete();
        $deleted = $item->delete();

        $this->cache->invalidate('menus');

        return $deleted;
    }

    public function reorderItems(Menu $menu, array $itemOrders): void
    {
        foreach ($itemOrders as $orderId => $order) {
            MenuItem::where('id', $orderId)
                ->where('menu_id', $menu->id)
                ->update(['sort_order' => $order]);
        }

        $this->cache->invalidate('menus');
    }
}
