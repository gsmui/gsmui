<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Themes\Models\Theme;
use App\Domains\Themes\Models\ThemeVariation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ThemeService
{
    public function __construct(
        protected \App\Domains\Themes\Contracts\ThemeRepositoryInterface $repository
    ) {}

    public function create(array $data): Theme
    {
        return $this->repository->create($data);
    }

    public function update(Theme $theme, array $data): Theme
    {
        return $this->repository->update($theme, $data);
    }

    public function delete(Theme $theme): bool
    {
        return $this->repository->delete($theme);
    }

    public function publish(Theme $theme): Theme
    {
        return $this->repository->update($theme, ['status' => 'published']);
    }

    public function getById(int $id): ?Theme
    {
        return $this->repository->findById($id);
    }

    public function getBySlug(string $slug): ?Theme
    {
        return $this->repository->findBySlug($slug);
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->list($filters, $perPage);
    }

    public function getFree(): LengthAwarePaginator
    {
        return $this->repository->getFree();
    }

    public function getPremium(): LengthAwarePaginator
    {
        return $this->repository->getPremium();
    }

    public function getFeatured(): LengthAwarePaginator
    {
        return $this->repository->getFeatured();
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->repository->search($query);
    }

    public function addVariation(Theme $theme, array $data): ThemeVariation
    {
        return $theme->variations()->create($data);
    }

    public function generateCss(Theme $theme): string
    {
        $tokens = $theme->tokens;
        $css = ':root {';
        foreach ($tokens as $key => $value) {
            $css .= "--gsmui-{$key}: {$value};";
        }
        $css .= '}';
        return $css;
    }

    public function recordDownload(Theme $theme): void
    {
        $this->repository->incrementDownloads($theme);
    }
}
