# 19 - Chart Builder

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The Chart Builder is a visual tool for creating, configuring, and exporting data visualizations using GsmUi's chart components. It supports multiple chart libraries and generates production-ready code.

---

# Vision

Enable developers to create beautiful, interactive charts without writing configuration code — through an intuitive visual interface.

---

# Core Features

## Chart Types

* Line charts
* Area charts
* Bar charts
* Horizontal bar charts
* Pie charts
* Donut charts
* Radar charts
* Scatter plots
* Bubble charts
* Heatmaps
* Treemaps
* Funnel charts
* Gauge charts

## Visual Editors

* Data editor
* Style editor
* Axis editor
* Legend editor
* Tooltip editor
* Animation editor

## Live Preview

* Real-time rendering
* Responsive preview
* Dark/light mode
* Export preview

## Export Options

* Blade component code
* Livewire component
* JavaScript configuration
* Image (PNG/SVG)
* Data (CSV/JSON)

---

# Chart Builder Layout

```text
┌─────────────────────────────────────────────────────┐
│ GsmUi Chart Builder                      [Export ▼] │
├───────────┬─────────────────────────────────────────┤
│           │                                         │
│ Chart     │        Preview Area                     │
│ Types     │                                         │
│           │  ┌─────────────────────────────────┐   │
│ 📈 Line   │  │                                 │   │
│ 📊 Bar    │  │        Chart Preview             │   │
│ 🥧 Pie    │  │                                 │   │
│ 📡 Radar  │  │     [Interactive Chart]          │   │
│ 🔵 Scatter│  │                                 │   │
│ 🔥 Heat   │  │                                 │   │
│ 🌳 Tree   │  └─────────────────────────────────┘   │
│           │                                         │
│ Data      │        Configuration                    │
│ ─────────│  ┌─────────────────────────────────┐   │
│ Labels    │  │ Dataset 1: [Edit] [Delete]      │   │
│ Dataset 1 │  │ Color: [#3b82f6 ▼]              │   │
│ Dataset 2 │  │ Data: [10, 20, 30, 40, 50]      │   │
│           │  └─────────────────────────────────┘   │
│ Style     │                                         │
│ ─────────│        Generated Code                    │
│ Colors    │  ┌─────────────────────────────────┐   │
│ Grid      │  │ <x-gsm-chart                     │   │
│ Legend     │  │   type="line"                    │   │
│ Tooltip   │  │   :data="[10, 20, 30]"          │   │
│ Animate   │  │ />                               │   │
│           │  └─────────────────────────────────┘   │
│ Axes      │                                         │
│ ─────────│                                         │
│ X-Axis    │                                         │
│ Y-Axis    │                                         │
└───────────┴─────────────────────────────────────────┘
```

---

# Data Editor

## Table Editor

```text
Labels    │ Dataset 1 │ Dataset 2 │ Dataset 3
──────────┼───────────┼───────────┼──────────
January   │    10     │    20     │    15
February  │    25     │    35     │    30
March     │    15     │    25     │    20
April     │    30     │    40     │    35
May       │    20     │    30     │    25
June      │    35     │    45     │    40
```

## Data Input Methods

* Manual table entry
* CSV paste
* JSON paste
* URL fetch (future)
* API connection (future)

## Data Operations

* Sort by column
* Filter rows
* Aggregate data
* Transform data
* Calculate statistics

---

# Style Configuration

## Colors

```text
Color Palette
─────────────
Primary:    [#3b82f6 ▼]
Secondary:  [#8b5cf6 ▼]
Accent:     [#06b6d4 ▼]
Success:    [#22c55e ▼]
Warning:    [#f59e0b ▼]
Error:      [#ef4444 ▼]

Auto-generate: [ ] Generate from palette
Color scheme:  [Default ▼]
```

## Typography

```text
Chart Typography
────────────────
Title Font:     [Inter ▼]
Title Size:     [18px]
Title Weight:   [Bold ▼]
Label Font:     [Inter ▼]
Label Size:     [12px]
Tooltip Font:   [Inter ▼]
```

## Grid & Axes

```text
Grid
────
Show Grid:      [✓] Show
Grid Color:     [#e5e7eb ▼]
Grid Style:     [Solid ▼]
Grid Width:     [1px]

X-Axis
──────
Show:           [✓] Show
Label:          [Date ▼]
Position:       [Bottom ▼]

Y-Axis
──────
Show:           [✓] Show
Label:          [Revenue ▼]
Position:       [Left ▼]
```

---

# Chart Library Support

## Supported Libraries

| Library | Status | Features |
|---------|--------|----------|
| Chart.js | ✅ Full | All chart types |
| ApexCharts | ✅ Full | Advanced interactions |
| ECharts | ✅ Full | Complex visualizations |
| D3.js | 🔜 Future | Custom visualizations |

## Library Selection

```text
Chart Library
─────────────
(●) Chart.js     — Lightweight, easy to use
( ) ApexCharts   — Interactive, responsive
( ) ECharts      — Feature-rich, powerful
```

---

# Code Generation

## Blade Component

```blade
<x-gsm-chart
    type="line"
    :data="[
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        'datasets' => [
            [
                'label' => 'Revenue',
                'data' => [10, 25, 15, 30, 20],
                'borderColor' => '#3b82f6',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
            ]
        ]
    ]"
    :options="[
        'responsive' => true,
        'plugins' => [
            'legend' => ['position' => 'top']
        ]
    ]"
/>
```

## Livewire Component

```php
<?php

namespace App\Livewire;

use Livewire\Component;

class RevenueChart extends Component
{
    public $chartData = [];
    
    public function mount()
    {
        $this->chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [10, 25, 15, 30, 20],
                    'borderColor' => '#3b82f6',
                ]
            ]
        ];
    }
    
    public function render()
    {
        return view('livewire.revenue-chart');
    }
}
```

---

# Responsive Configuration

```text
Responsive Breakpoints
──────────────────────
Mobile (<640px):
  └── Hide legend, reduce padding

Tablet (640-1024px):
  └── Compact legend, adjusted font sizes

Desktop (>1024px):
  └── Full layout, all features visible
```

---

# Animation Options

```text
Animation
─────────
Enabled:     [✓] Enable
Duration:    [750ms]
Easing:      [easeInOutQuart ▼]
Delay:       [0ms]
Stagger:     [50ms]
```

---

# Export Formats

## Image Export

* PNG (1x, 2x, 3x)
* SVG
* PDF (future)

## Code Export

* Blade component
* Livewire component
* Vue component (future)
* React component (future)
* Standalone HTML

## Data Export

* CSV
* JSON
* Excel (future)

---

# Technical Architecture

```text
Frontend
├── Chart Type Selector
├── Data Editor
├── Style Editors
├── Preview Renderer
├── Code Generator
└── Export Engine

Backend
├── Chart Service
├── Data Processor
├── Code Generator
├── Image Renderer
└── Storage Service

Libraries
├── Chart.js
├── ApexCharts
├── ECharts
└── Canvas API
```

---

# Database Schema

Key tables:

* `chart_configs` — Saved configurations
* `chart_templates` — Starter templates
* `chart_shares` — Shared charts
* `chart_analytics` — Usage data

---

# Admin Features

* Template management
* Featured charts
* Analytics dashboard
* Library management
* Performance monitoring

---

# Success Metrics

* 5,000+ charts created/month
* <500ms preview render
* 70%+ code export usage
* 50+ chart templates
* 4.5+ user satisfaction

---

# Detailed Data Editor Implementation

## Table Editor Component

```javascript
class DataTableEditor {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.data = {
            labels: [],
            datasets: [],
        };
        this.selectedCell = null;
        
        this.init();
    }
    
    init() {
        this.render();
        this.setupEventListeners();
    }
    
    render() {
        this.container.innerHTML = `
            <div class="data-table-editor">
                <div class="table-toolbar">
                    <button class="btn-add-row" data-action="addRow">+ Row</button>
                    <button class="btn-add-column" data-action="addColumn">+ Column</button>
                    <button class="btn-import-csv" data-action="importCsv">Import CSV</button>
                    <button class="btn-import-json" data-action="importJson">Import JSON</button>
                    <button class="btn-export" data-action="export">Export</button>
                </div>
                <div class="table-container" data-table-container>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="row-number">#</th>
                                ${this.data.datasets.map((ds, i) => `
                                    <th class="dataset-header" data-dataset="${i}">
                                        <input type="text" value="${ds.label}" data-dataset-name="${i}" />
                                        <button class="btn-remove-dataset" data-remove-dataset="${i}">×</button>
                                    </th>
                                `).join('')}
                                <th class="actions-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${this.data.labels.map((label, rowIndex) => `
                                <tr data-row="${rowIndex}">
                                    <td class="row-number">${rowIndex + 1}</td>
                                    <td class="label-cell">
                                        <input type="text" value="${label}" data-label="${rowIndex}" />
                                    </td>
                                    ${this.data.datasets.map((ds, colIndex) => `
                                        <td class="data-cell" data-row="${rowIndex}" data-col="${colIndex}">
                                            <input type="number" value="${ds.data[rowIndex] || 0}" 
                                                   data-value="${rowIndex}-${colIndex}" />
                                        </td>
                                    `).join('')}
                                    <td class="actions-cell">
                                        <button class="btn-remove-row" data-remove-row="${rowIndex}">×</button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
    
    setupEventListeners() {
        // Toolbar actions
        this.container.querySelectorAll('[data-action]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const action = e.target.dataset.action;
                this.handleAction(action);
            });
        });
        
        // Label changes
        this.container.querySelectorAll('[data-label]').forEach(input => {
            input.addEventListener('change', (e) => {
                const index = parseInt(e.target.dataset.label);
                this.data.labels[index] = e.target.value;
                this.onChange();
            });
        });
        
        // Dataset name changes
        this.container.querySelectorAll('[data-dataset-name]').forEach(input => {
            input.addEventListener('change', (e) => {
                const index = parseInt(e.target.dataset.datasetName);
                this.data.datasets[index].label = e.target.value;
                this.onChange();
            });
        });
        
        // Data value changes
        this.container.querySelectorAll('[data-value]').forEach(input => {
            input.addEventListener('change', (e) => {
                const [row, col] = e.target.dataset.value.split('-').map(Number);
                this.data.datasets[col].data[row] = parseFloat(e.target.value) || 0;
                this.onChange();
            });
        });
        
        // Remove row buttons
        this.container.querySelectorAll('[data-remove-row]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.target.dataset.removeRow);
                this.removeRow(index);
            });
        });
        
        // Remove dataset buttons
        this.container.querySelectorAll('[data-remove-dataset]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.target.dataset.removeDataset);
                this.removeDataset(index);
            });
        });
    }
    
    handleAction(action) {
        switch (action) {
            case 'addRow':
                this.addRow();
                break;
            case 'addColumn':
                this.addColumn();
                break;
            case 'importCsv':
                this.importCsv();
                break;
            case 'importJson':
                this.importJson();
                break;
            case 'export':
                this.export();
                break;
        }
    }
    
    addRow() {
        this.data.labels.push(`Row ${this.data.labels.length + 1}`);
        this.data.datasets.forEach(ds => ds.data.push(0));
        this.render();
        this.onChange();
    }
    
    addColumn() {
        const name = `Dataset ${this.data.datasets.length + 1}`;
        this.data.datasets.push({
            label: name,
            data: new Array(this.data.labels.length).fill(0),
            backgroundColor: this.getDefaultColor(this.data.datasets.length),
            borderColor: this.getDefaultColor(this.data.datasets.length),
        });
        this.render();
        this.onChange();
    }
    
    removeRow(index) {
        this.data.labels.splice(index, 1);
        this.data.datasets.forEach(ds => ds.data.splice(index, 1));
        this.render();
        this.onChange();
    }
    
    removeDataset(index) {
        this.data.datasets.splice(index, 1);
        this.render();
        this.onChange();
    }
    
    importCsv() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = '.csv';
        
        input.onchange = (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = (event) => {
                const csv = event.target.result;
                this.parseCsv(csv);
            };
            
            reader.readAsText(file);
        };
        
        input.click();
    }
    
    parseCsv(csv) {
        const lines = csv.split('\n');
        const headers = lines[0].split(',').map(h => h.trim());
        
        this.data.labels = [];
        this.data.datasets = headers.slice(1).map((header, i) => ({
            label: header,
            data: [],
            backgroundColor: this.getDefaultColor(i),
            borderColor: this.getDefaultColor(i),
        }));
        
        for (let i = 1; i < lines.length; i++) {
            const values = lines[i].split(',').map(v => v.trim());
            if (values.length >= 2) {
                this.data.labels.push(values[0]);
                for (let j = 1; j < values.length; j++) {
                    if (this.data.datasets[j - 1]) {
                        this.data.datasets[j - 1].data.push(parseFloat(values[j]) || 0);
                    }
                }
            }
        }
        
        this.render();
        this.onChange();
    }
    
    importJson() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = '.json';
        
        input.onchange = (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = (event) => {
                try {
                    const json = JSON.parse(event.target.result);
                    this.data = json;
                    this.render();
                    this.onChange();
                } catch (err) {
                    alert('Invalid JSON file');
                }
            };
            
            reader.readAsText(file);
        };
        
        input.click();
    }
    
    getDefaultColor(index) {
        const colors = [
            '#3b82f6', '#8b5cf6', '#06b6d4', '#22c55e',
            '#f59e0b', '#ef4444', '#ec4899', '#6366f1',
        ];
        return colors[index % colors.length];
    }
    
    onChange() {
        // Emit change event
        const event = new CustomEvent('dataChange', { detail: this.data });
        this.container.dispatchEvent(event);
    }
    
    getData() {
        return { ...this.data };
    }
    
    setData(data) {
        this.data = data;
        this.render();
    }
}
```

## Data Input Methods

```php
class DataInputHandler
{
    public function importCsv(string $csv): array
    {
        $lines = explode("\n", $csv);
        $headers = str_getcsv(array_shift($lines));
        
        $data = [
            'labels' => [],
            'datasets' => [],
        ];
        
        // Initialize datasets
        foreach (array_slice($headers, 1) as $header) {
            $data['datasets'][] = [
                'label' => trim($header),
                'data' => [],
            ];
        }
        
        // Parse rows
        foreach ($lines as $line) {
            if (empty(trim($line))) continue;
            
            $values = str_getcsv($line);
            $data['labels'][] = trim($values[0]);
            
            foreach (array_slice($values, 1) as $index => $value) {
                if (isset($data['datasets'][$index])) {
                    $data['datasets'][$index]['data'][] = (float) $value;
                }
            }
        }
        
        return $data;
    }
    
    public function importJson(string $json): array
    {
        $decoded = json_decode($json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON: ' . json_last_error_msg());
        }
        
        // Validate structure
        if (!isset($decoded['labels']) || !isset($decoded['datasets'])) {
            throw new \InvalidArgumentException('JSON must contain "labels" and "datasets" keys');
        }
        
        return $decoded;
    }
    
    public function importArray(array $data): array
    {
        // Handle different input formats
        if (isset($data['labels']) && isset($data['datasets'])) {
            return $data;
        }
        
        // Handle simple key-value format
        if (!isset($data[0])) {
            return [
                'labels' => array_keys($data),
                'datasets' => [
                    [
                        'label' => 'Data',
                        'data' => array_values($data),
                    ],
                ],
            ];
        }
        
        // Handle array of arrays
        return [
            'labels' => array_column($data, 0),
            'datasets' => [
                [
                    'label' => 'Data',
                    'data' => array_column($data, 1),
                ],
            ],
        ];
    }
    
    public function fetchDataFromUrl(string $url): array
    {
        $response = Http::timeout(10)->get($url);
        
        if ($response->failed()) {
            throw new \RuntimeException('Failed to fetch data from URL');
        }
        
        $content = $response->body();
        $contentType = $response->header('Content-Type');
        
        if (str_contains($contentType, 'application/json')) {
            return $this->importJson($content);
        }
        
        if (str_contains($contentType, 'text/csv') || str_ends_with($url, '.csv')) {
            return $this->importCsv($content);
        }
        
        throw new \InvalidArgumentException('Unsupported content type: ' . $contentType);
    }
}
```

## Data Operations

```php
class DataOperations
{
    public function sortByColumn(array $data, int $columnIndex, string $direction = 'asc'): array
    {
        $data['labels'] = array_values($data['labels']);
        
        // Create index array
        $indices = range(0, count($data['labels']) - 1);
        
        // Sort indices based on column value
        usort($indices, function ($a, $b) use ($data, $columnIndex, $direction) {
            $valA = $data['datasets'][$columnIndex]['data'][$a] ?? 0;
            $valB = $data['datasets'][$columnIndex]['data'][$b] ?? 0;
            
            return $direction === 'asc' ? $valA <=> $valB : $valB <=> $valA;
        });
        
        // Reorder data
        $sorted = [
            'labels' => [],
            'datasets' => [],
        ];
        
        foreach ($data['datasets'] as $dataset) {
            $sorted['datasets'][] = [
                'label' => $dataset['label'],
                'data' => [],
            ];
        }
        
        foreach ($indices as $index) {
            $sorted['labels'][] = $data['labels'][$index];
            foreach ($data['datasets'] as $dsIndex => $dataset) {
                $sorted['datasets'][$dsIndex]['data'][] = $dataset['data'][$index] ?? 0;
            }
        }
        
        return $sorted;
    }
    
    public function filterRows(array $data, callable $callback): array
    {
        $filtered = [
            'labels' => [],
            'datasets' => array_map(fn ($ds) => ['label' => $ds['label'], 'data' => []], $data['datasets']),
        ];
        
        foreach ($data['labels'] as $index => $label) {
            $rowData = array_column($data['datasets'], 'data');
            $rowData = array_map(fn ($ds) => $ds[$index] ?? 0, $rowData);
            
            if ($callback($label, $rowData)) {
                $filtered['labels'][] = $label;
                foreach ($data['datasets'] as $dsIndex => $dataset) {
                    $filtered['datasets'][$dsIndex]['data'][] = $dataset['data'][$index] ?? 0;
                }
            }
        }
        
        return $filtered;
    }
    
    public function aggregate(array $data, string $function): array
    {
        $aggregated = [
            'labels' => ['Total'],
            'datasets' => [],
        ];
        
        foreach ($data['datasets'] as $dataset) {
            $values = $dataset['data'];
            
            $result = match ($function) {
                'sum' => array_sum($values),
                'avg' => count($values) > 0 ? array_sum($values) / count($values) : 0,
                'min' => min($values),
                'max' => max($values),
                'count' => count($values),
                default => array_sum($values),
            };
            
            $aggregated['datasets'][] = [
                'label' => $dataset['label'],
                'data' => [$result],
            ];
        }
        
        return $aggregated;
    }
    
    public function calculateStatistics(array $data): array
    {
        $stats = [];
        
        foreach ($data['datasets'] as $dataset) {
            $values = $dataset['data'];
            $sorted = $values;
            sort($sorted);
            
            $stats[$dataset['label']] = [
                'sum' => array_sum($values),
                'avg' => count($values) > 0 ? array_sum($values) / count($values) : 0,
                'min' => min($values),
                'max' => max($values),
                'count' => count($values),
                'median' => $this->calculateMedian($sorted),
                'stddev' => $this->calculateStdDev($values),
            ];
        }
        
        return $stats;
    }
    
    private function calculateMedian(array $sorted): float
    {
        $count = count($sorted);
        
        if ($count === 0) return 0;
        
        $middle = floor($count / 2);
        
        if ($count % 2 === 0) {
            return ($sorted[$middle - 1] + $sorted[$middle]) / 2;
        }
        
        return $sorted[$middle];
    }
    
    private function calculateStdDev(array $values): float
    {
        $n = count($values);
        if ($n === 0) return 0;
        
        $mean = array_sum($values) / $n;
        $sumSquaredDiff = 0;
        
        foreach ($values as $value) {
            $sumSquaredDiff += pow($value - $mean, 2);
        }
        
        return sqrt($sumSquaredDiff / $n);
    }
}
```

---

# Style Configuration Details

## Color Palette Generator

```php
class ChartColorPalette
{
    private const DEFAULT_COLORS = [
        '#3b82f6', '#8b5cf6', '#06b6d4', '#22c55e',
        '#f59e0b', '#ef4444', '#ec4899', '#6366f1',
        '#14b8a6', '#f97316', '#84cc16', '#a855f7',
    ];
    
    public function generatePalette(string $baseColor, int $count): array
    {
        $hsl = $this->hexToHsl($baseColor);
        
        $palette = [];
        
        for ($i = 0; $i < $count; $i++) {
            $hue = ($hsl['h'] + ($i * 360 / $count)) % 360;
            $palette[] = $this->hslToHex($hue, $hsl['s'], $hsl['l']);
        }
        
        return $palette;
    }
    
    public function getSchemeColors(string $scheme): array
    {
        return match ($scheme) {
            'default' => self::DEFAULT_COLORS,
            'warm' => ['#f59e0b', '#ef4444', '#ec4899', '#f97316', '#eab308', '#dc2626'],
            'cool' => ['#3b82f6', '#8b5cf6', '#06b6d4', '#6366f1', '#2563eb', '#7c3aed'],
            'pastel' => ['#93c5fd', '#c4b5fd', '#67e8f9', '#86efac', '#fcd34d', '#fca5a5'],
            'vibrant' => ['#2563eb', '#7c3aed', '#0891b2', '#16a34a', '#ea580c', '#dc2626'],
            'monochrome' => ['#1f2937', '#374151', '#4b5563', '#6b7280', '#9ca3af', '#d1d5db'],
            default => self::DEFAULT_COLORS,
        };
    }
    
    public function getContrastColor(string $hex): string
    {
        $rgb = $this->hexToRgb($hex);
        
        $luminance = (0.299 * $rgb['r'] + 0.587 * $rgb['g'] + 0.114 * $rgb['b']) / 255;
        
        return $luminance > 0.5 ? '#000000' : '#ffffff';
    }
    
    public function generateGradient(string $color1, string $color2, int $steps): array
    {
        $rgb1 = $this->hexToRgb($color1);
        $rgb2 = $this->hexToRgb($color2);
        
        $gradient = [];
        
        for ($i = 0; $i < $steps; $i++) {
            $ratio = $i / ($steps - 1);
            
            $r = round($rgb1['r'] + ($rgb2['r'] - $rgb1['r']) * $ratio);
            $g = round($rgb1['g'] + ($rgb2['g'] - $rgb1['g']) * $ratio);
            $b = round($rgb1['b'] + ($rgb2['b'] - $rgb1['b']) * $ratio);
            
            $gradient[] = $this->rgbToHex($r, $g, $b);
        }
        
        return $gradient;
    }
}
```

## Typography Configuration

```php
class ChartTypography
{
    public function getFontOptions(): array
    {
        return [
            'sans' => [
                'name' => 'Inter',
                'url' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
            ],
            'serif' => [
                'name' => 'Merriweather',
                'url' => 'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap',
            ],
            'mono' => [
                'name' => 'JetBrains Mono',
                'url' => 'https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap',
            ],
        ];
    }
    
    public function generateTypographyCss(array $config): string
    {
        $css = <<<CSS
        .chart-title {
            font-family: '{$config['title_font']}', sans-serif;
            font-size: {$config['title_size']}px;
            font-weight: {$config['title_weight']};
        }
        
        .chart-label {
            font-family: '{$config['label_font']}', sans-serif;
            font-size: {$config['label_size']}px;
        }
        
        .chart-tooltip {
            font-family: '{$config['tooltip_font']}', sans-serif;
            font-size: {$config['tooltip_size']}px;
        }
        CSS;
        
        return $css;
    }
}
```

---

# Chart Library Integration Details

## Chart.js Integration

```javascript
class ChartJsAdapter {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        this.chart = null;
    }
    
    render(config) {
        if (this.chart) {
            this.chart.destroy();
        }
        
        const chartConfig = this.convertConfig(config);
        
        this.chart = new Chart(this.canvas, chartConfig);
    }
    
    convertConfig(config) {
        return {
            type: config.type,
            data: {
                labels: config.labels,
                datasets: config.datasets.map(ds => ({
                    label: ds.label,
                    data: ds.data,
                    backgroundColor: ds.backgroundColor || 'rgba(59, 130, 246, 0.5)',
                    borderColor: ds.borderColor || '#3b82f6',
                    borderWidth: ds.borderWidth || 2,
                    tension: ds.tension || 0.4,
                    fill: ds.fill || false,
                })),
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: config.showLegend !== false,
                        position: config.legendPosition || 'top',
                    },
                    tooltip: {
                        enabled: config.showTooltip !== false,
                        mode: config.tooltipMode || 'index',
                        intersect: false,
                    },
                },
                scales: {
                    x: {
                        display: config.showXAxis !== false,
                        title: {
                            display: !!config.xAxisLabel,
                            text: config.xAxisLabel || '',
                        },
                        grid: {
                            display: config.showGrid !== false,
                        },
                    },
                    y: {
                        display: config.showYAxis !== false,
                        title: {
                            display: !!config.yAxisLabel,
                            text: config.yAxisLabel || '',
                        },
                        grid: {
                            display: config.showGrid !== false,
                        },
                    },
                },
                animation: {
                    duration: config.animationDuration || 750,
                    easing: config.animationEasing || 'easeInOutQuart',
                },
            },
        };
    }
    
    exportAsImage(format = 'png', quality = 1) {
        return this.canvas.toDataURL(`image/${format}`, quality);
    }
    
    destroy() {
        if (this.chart) {
            this.chart.destroy();
            this.chart = null;
        }
    }
}
```

## ApexCharts Integration

```javascript
class ApexChartsAdapter {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.chart = null;
    }
    
    render(config) {
        if (this.chart) {
            this.chart.destroy();
        }
        
        const chartConfig = this.convertConfig(config);
        
        this.chart = new ApexCharts(this.container, chartConfig);
        this.chart.render();
    }
    
    convertConfig(config) {
        return {
            series: config.datasets.map(ds => ({
                name: ds.label,
                data: ds.data,
            })),
            chart: {
                type: config.type === 'area' ? 'area' : config.type,
                height: config.height || 350,
                toolbar: {
                    show: true,
                },
            },
            colors: config.datasets.map(ds => ds.borderColor || '#3b82f6'),
            xaxis: {
                categories: config.labels,
                title: {
                    text: config.xAxisLabel || '',
                },
            },
            yaxis: {
                title: {
                    text: config.yAxisLabel || '',
                },
            },
            legend: {
                show: config.showLegend !== false,
                position: config.legendPosition || 'top',
            },
            tooltip: {
                enabled: config.showTooltip !== false,
                shared: true,
                intersect: false,
            },
            grid: {
                show: config.showGrid !== false,
            },
            animation: {
                duration: config.animationDuration || 750,
            },
        };
    }
    
    exportAsImage() {
        return this.chart.exportToSVG();
    }
    
    destroy() {
        if (this.chart) {
            this.chart.destroy();
            this.chart = null;
        }
    }
}
```

## ECharts Integration

```javascript
class EChartsAdapter {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.chart = null;
    }
    
    init() {
        this.chart = echarts.init(this.container);
        
        window.addEventListener('resize', () => {
            this.chart.resize();
        });
    }
    
    render(config) {
        if (!this.chart) {
            this.init();
        }
        
        const chartConfig = this.convertConfig(config);
        
        this.chart.setOption(chartConfig);
    }
    
    convertConfig(config) {
        return {
            title: {
                text: config.title || '',
                left: 'center',
            },
            tooltip: {
                trigger: config.type === 'pie' ? 'item' : 'axis',
            },
            legend: {
                show: config.showLegend !== false,
                orient: 'horizontal',
                bottom: 10,
            },
            xAxis: config.type !== 'pie' ? {
                type: 'category',
                data: config.labels,
                axisLabel: {
                    show: config.showXLabels !== false,
                },
            } : undefined,
            yAxis: config.type !== 'pie' ? {
                type: 'value',
                axisLabel: {
                    show: config.showYLabels !== false,
                },
            } : undefined,
            series: config.type === 'pie' ? [{
                type: 'pie',
                radius: '50%',
                data: config.labels.map((label, i) => ({
                    value: config.datasets[0]?.data[i] || 0,
                    name: label,
                })),
            }] : config.datasets.map(ds => ({
                type: config.type,
                name: ds.label,
                data: ds.data,
                smooth: config.smooth || false,
                areaStyle: config.type === 'area' ? {} : undefined,
            })),
            animationDuration: config.animationDuration || 1000,
        };
    }
    
    exportAsImage() {
        return this.chart.getDataURL({
            type: 'png',
            pixelRatio: 2,
            backgroundColor: '#fff',
        });
    }
    
    dispose() {
        if (this.chart) {
            this.chart.dispose();
            this.chart = null;
        }
    }
}
```

---

# Code Generation Details

## Blade Component Generator

```php
class BladeChartGenerator
{
    public function generate(array $config): string
    {
        $type = $config['type'];
        $data = $this->formatData($config);
        $options = $this->formatOptions($config);
        
        return <<<BLADE
        <x-gsm-chart
            type="{$type}"
            :data="{$data}"
            :options="{$options}"
        />
        BLADE;
    }
    
    private function formatData(array $config): string
    {
        $data = [
            'labels' => $config['labels'],
            'datasets' => array_map(function ($ds) {
                return [
                    'label' => $ds['label'],
                    'data' => $ds['data'],
                    'borderColor' => $ds['borderColor'] ?? '#3b82f6',
                    'backgroundColor' => $ds['backgroundColor'] ?? 'rgba(59, 130, 246, 0.5)',
                ];
            }, $config['datasets']),
        ];
        
        return var_export($data, true);
    }
    
    private function formatOptions(array $config): string
    {
        $options = [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => $config['showLegend'] ?? true,
                    'position' => $config['legendPosition'] ?? 'top',
                ],
            ],
        ];
        
        return var_export($options, true);
    }
}
```

## Livewire Component Generator

```php
class LivewireChartGenerator
{
    public function generate(array $config, string $name): array
    {
        $className = Str::studly($name);
        
        $php = $this->generatePhpClass($className, $config);
        $blade = $this->generateBladeView($config);
        
        return [
            'php' => $php,
            'blade' => $blade,
            'wire' => "livewire:{$this->kebabCase($name)}",
        ];
    }
    
    private function generatePhpClass(string $className, array $config): string
    {
        $data = json_encode($config);
        
        return <<<PHP
        <?php
        
        namespace App\\Livewire;
        
        use Livewire\\Component;
        
        class {$className} extends Component
        {
            public \$chartData = {$data};
            
            public function mount()
            {
                // Initialize chart data from database or API
            }
            
            public function render()
            {
                return view('livewire.' . Str::kebab('{$className}'));
            }
        }
        PHP;
    }
    
    private function generateBladeView(array $config): string
    {
        $type = $config['type'];
        
        return <<<BLADE
        <div wire:poll>
            <x-gsm-chart
                type="{$type}"
                :data="\$chartData"
            />
        </div>
        BLADE;
    }
}
```

---

# Responsive Configuration Details

```php
class ResponsiveConfiguration
{
    private const BREAKPOINTS = [
        'mobile' => [
            'max_width' => 640,
            'settings' => [
                'show_legend' => false,
                'padding' => 10,
                'font_size' => 10,
            ],
        ],
        'tablet' => [
            'max_width' => 1024,
            'settings' => [
                'show_legend' => true,
                'legend_position' => 'bottom',
                'padding' => 15,
                'font_size' => 12,
            ],
        ],
        'desktop' => [
            'max_width' => null,
            'settings' => [
                'show_legend' => true,
                'legend_position' => 'top',
                'padding' => 20,
                'font_size' => 14,
            ],
        ],
    ];
    
    public function getResponsiveConfig(array $baseConfig): array
    {
        $responsive = [];
        
        foreach (self::BREAKPOINTS as $name => $breakpoint) {
            $responsive[$name] = array_merge($baseConfig, $breakpoint['settings']);
        }
        
        return $responsive;
    }
    
    public function generateResponsiveCss(array $config): string
    {
        $css = '';
        
        foreach (self::BREAKPOINTS as $name => $breakpoint) {
            if ($breakpoint['max_width']) {
                $css .= "@media (max-width: {$breakpoint['max_width']}px) {\n";
            }
            
            $css .= "    .chart-container {\n";
            $css .= "        padding: {$breakpoint['settings']['padding']}px;\n";
            $css .= "    }\n";
            
            if ($breakpoint['max_width']) {
                $css .= "}\n\n";
            }
        }
        
        return $css;
    }
}
```

---

# API Contracts Details

## Chart Builder API Specification

```yaml
openapi: 3.0.0
info:
  title: GsmUi Chart Builder API
  version: 1.0.0
  description: API for the GsmUi Chart Builder

paths:
  /api/charts:
    get:
      summary: List saved charts
      tags: [Charts]
      security:
        - bearerAuth: []
      responses:
        '200':
          description: Chart list

    post:
      summary: Save chart
      tags: [Charts]
      security:
        - bearerAuth: []
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/ChartConfig'
      responses:
        '201':
          description: Chart saved

  /api/charts/{id}:
    get:
      summary: Get chart
      tags: [Charts]
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Chart details

    put:
      summary: Update chart
      tags: [Charts]
      security:
        - bearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Chart updated

    delete:
      summary: Delete chart
      tags: [Charts]
      security:
        - bearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '204':
          description: Chart deleted

  /api/charts/render:
    post:
      summary: Render chart preview
      tags: [Preview]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/ChartConfig'
      responses:
        '200':
          description: Rendered chart HTML

  /api/charts/export:
    post:
      summary: Export chart
      tags: [Export]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - config
                - format
              properties:
                config:
                  $ref: '#/components/schemas/ChartConfig'
                format:
                  type: string
                  enum: [blade, livewire, image, svg, csv, json]
      responses:
        '200':
          description: Exported file

  /api/charts/templates:
    get:
      summary: List chart templates
      tags: [Templates]
      responses:
        '200':
          description: Template list

components:
  schemas:
    ChartConfig:
      type: object
      properties:
        type:
          type: string
          enum: [line, bar, pie, doughnut, radar, polarArea, scatter, bubble]
        labels:
          type: array
          items:
            type: string
        datasets:
          type: array
          items:
            type: object
            properties:
              label:
                type: string
              data:
                type: array
                items:
                  type: number
              backgroundColor:
                type: string
              borderColor:
                type: string
              borderWidth:
                type: number
        options:
          type: object
          properties:
            responsive:
              type: boolean
            maintainAspectRatio:
              type: boolean
            showLegend:
              type: boolean
            legendPosition:
              type: string
              enum: [top, bottom, left, right]
            showGrid:
              type: boolean
            xAxisLabel:
              type: string
            yAxisLabel:
              type: string
            animationDuration:
              type: integer

  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
```

---

# Animation Options Details

## Animation Configuration

```php
class ChartAnimation
{
    private const EASING_OPTIONS = [
        'linear' => 'Linear',
        'easeInQuad' => 'Ease In Quad',
        'easeOutQuad' => 'Ease Out Quad',
        'easeInOutQuad' => 'Ease In Out Quad',
        'easeInCubic' => 'Ease In Cubic',
        'easeOutCubic' => 'Ease Out Cubic',
        'easeInOutCubic' => 'Ease In Out Cubic',
        'easeInQuart' => 'Ease In Quart',
        'easeOutQuart' => 'Ease Out Quart',
        'easeInOutQuart' => 'Ease In Out Quart',
        'easeInQuint' => 'Ease In Quint',
        'easeOutQuint' => 'Ease Out Quint',
        'easeInOutQuint' => 'Ease In Out Quint',
        'easeInSine' => 'Ease In Sine',
        'easeOutSine' => 'Ease Out Sine',
        'easeInOutSine' => 'Ease In Out Sine',
        'easeInExpo' => 'Ease In Expo',
        'easeOutExpo' => 'Ease Out Expo',
        'easeInOutExpo' => 'Ease In Out Expo',
        'easeInCirc' => 'Ease In Circ',
        'easeOutCirc' => 'Ease Out Circ',
        'easeInOutCirc' => 'Ease In Out Circ',
        'easeInElastic' => 'Ease In Elastic',
        'easeOutElastic' => 'Ease Out Elastic',
        'easeInOutElastic' => 'Ease In Out Elastic',
        'easeInBack' => 'Ease In Back',
        'easeOutBack' => 'Ease Out Back',
        'easeInOutBack' => 'Ease In Out Back',
        'easeInBounce' => 'Ease In Bounce',
        'easeOutBounce' => 'Ease Out Bounce',
        'easeInOutBounce' => 'Ease In Out Bounce',
    ];
    
    public function getEasingOptions(): array
    {
        return self::EASING_OPTIONS;
    }
    
    public function generateAnimationConfig(array $config): array
    {
        return [
            'duration' => $config['duration'] ?? 750,
            'easing' => $config['easing'] ?? 'easeInOutQuart',
            'delay' => $config['delay'] ?? 0,
            'stagger' => $config['stagger'] ?? 50,
            'animateIn' => $config['animateIn'] ?? true,
            'animateOut' => $config['animateOut'] ?? true,
        ];
    }
    
    public function generateAnimationCss(array $config): string
    {
        $duration = $config['duration'] ?? 750;
        $easing = $config['easing'] ?? 'ease-in-out';
        
        return <<<CSS
        .chart-animate {
            animation: chartFadeIn {$duration}ms {$easing};
        }
        
        @keyframes chartFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .chart-bar-animate {
            animation: barGrow {$duration}ms {$easing};
        }
        
        @keyframes barGrow {
            from {
                transform: scaleY(0);
            }
            to {
                transform: scaleY(1);
            }
        }
        
        .chart-pie-animate {
            animation: pieRotate {$duration}ms {$easing};
        }
        
        @keyframes pieRotate {
            from {
                transform: rotate(-180deg);
                opacity: 0;
            }
            to {
                transform: rotate(0deg);
                opacity: 1;
            }
        }
        CSS;
    }
}
```

## Animation Presets

```php
class AnimationPresets
{
    public function getPresets(): array
    {
        return [
            'none' => [
                'name' => 'No Animation',
                'duration' => 0,
                'easing' => 'linear',
            ],
            'subtle' => [
                'name' => 'Subtle',
                'duration' => 500,
                'easing' => 'easeOutQuad',
                'stagger' => 20,
            ],
            'moderate' => [
                'name' => 'Moderate',
                'duration' => 750,
                'easing' => 'easeInOutQuad',
                'stagger' => 50,
            ],
            'dramatic' => [
                'name' => 'Dramatic',
                'duration' => 1000,
                'easing' => 'easeOutBounce',
                'stagger' => 100,
            ],
            'bounce' => [
                'name' => 'Bounce',
                'duration' => 1200,
                'easing' => 'easeOutBounce',
                'stagger' => 80,
            ],
            'elastic' => [
                'name' => 'Elastic',
                'duration' => 1500,
                'easing' => 'easeOutElastic',
                'stagger' => 60,
            ],
        ];
    }
    
    public function getPreset(string $name): array
    {
        return $this->getPresets()[$name] ?? $this->getPresets()['moderate'];
    }
}
```

---

# Export Formats Details

## Image Export

```php
class ImageExporter
{
    public function exportPng(string $canvasData, int $scale = 2): string
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $canvasData));
        
        $path = sys_get_temp_dir() . '/chart_' . Str::random(8) . '.png';
        file_put_contents($path, $imageData);
        
        return $path;
    }
    
    public function exportSvg(string $svgContent): string
    {
        $path = sys_get_temp_dir() . '/chart_' . Str::random(8) . '.svg';
        file_put_contents($path, $svgContent);
        
        return $path;
    }
    
    public function generateSvgFromConfig(array $config): string
    {
        $width = $config['width'] ?? 800;
        $height = $config['height'] ?? 400;
        
        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}" viewBox="0 0 {$width} {$height}">
            <style>
                .chart-title { font-family: Inter, sans-serif; font-size: 18px; font-weight: bold; }
                .chart-label { font-family: Inter, sans-serif; font-size: 12px; }
            </style>
        SVG;
        
        // Add chart elements based on type
        $svg .= $this->renderChartElements($config);
        
        $svg .= '</svg>';
        
        return $svg;
    }
    
    private function renderChartElements(array $config): string
    {
        $elements = '';
        
        switch ($config['type']) {
            case 'bar':
                $elements = $this->renderBarChart($config);
                break;
            case 'line':
                $elements = $this->renderLineChart($config);
                break;
            case 'pie':
                $elements = $this->renderPieChart($config);
                break;
        }
        
        return $elements;
    }
    
    private function renderBarChart(array $config): string
    {
        $bars = '';
        $barWidth = 40;
        $gap = 20;
        $startX = 100;
        
        foreach ($config['datasets'][0]['data'] as $index => $value) {
            $height = $value * 2; // Scale factor
            $x = $startX + ($index * ($barWidth + $gap));
            $y = 300 - $height;
            $color = $config['datasets'][0]['backgroundColor'] ?? '#3b82f6';
            
            $bars .= "<rect x=\"{$x}\" y=\"{$y}\" width=\"{$barWidth}\" height=\"{$height}\" fill=\"{$color}\" />";
            
            // Add label
            $label = $config['labels'][$index] ?? '';
            $bars .= "<text x=\"{$x}\" y=\"320\" class=\"chart-label\" text-anchor=\"middle\">{$label}</text>";
        }
        
        return $bars;
    }
}
```

## Data Export

```php
class DataExporter
{
    public function exportCsv(array $data): string
    {
        $csv = "Label," . implode(',', array_column($data['datasets'], 'label')) . "\n";
        
        foreach ($data['labels'] as $index => $label) {
            $row = [$label];
            
            foreach ($data['datasets'] as $dataset) {
                $row[] = $dataset['data'][$index] ?? 0;
            }
            
            $csv .= implode(',', $row) . "\n";
        }
        
        return $csv;
    }
    
    public function exportJson(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
    
    public function generateDownloadResponse(string $content, string $filename, string $mimeType): Response
    {
        return response($content)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
```

## Code Export Formats

```php
class CodeExporter
{
    public function exportBlade(array $config): string
    {
        $generator = new BladeChartGenerator();
        return $generator->generate($config);
    }
    
    public function exportLivewire(array $config, string $name): array
    {
        $generator = new LivewireChartGenerator();
        return $generator->generate($config, $name);
    }
    
    public function exportStandaloneHtml(array $config): string
    {
        $type = $config['type'];
        $labels = json_encode($config['labels']);
        $datasets = json_encode($config['datasets']);
        
        return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Chart</title>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <style>
                .chart-container { max-width: 800px; margin: 0 auto; }
            </style>
        </head>
        <body>
            <div class="chart-container">
                <canvas id="chart"></canvas>
            </div>
            <script>
                const ctx = document.getElementById('chart').getContext('2d');
                new Chart(ctx, {
                    type: '{$type}',
                    data: {
                        labels: {$labels},
                        datasets: {$datasets}
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true
                    }
                });
            </script>
        </body>
        </html>
        HTML;
    }
    
    public function exportVueComponent(array $config, string $name): string
    {
        $componentName = Str::studly($name);
        
        return <<<VUE
        <template>
            <div class="chart-wrapper">
                <canvas ref="chartCanvas"></canvas>
            </div>
        </template>
        
        <script>
        import { Chart } from 'chart.js';
        
        export default {
            name: '{$componentName}Chart',
            mounted() {
                this.initChart();
            },
            methods: {
                initChart() {
                    const ctx = this.$refs.chartCanvas.getContext('2d');
                    new Chart(ctx, {
                        type: '{$config['type']}',
                        data: {
                            labels: {$json_encode($config['labels'])},
                            datasets: {$json_encode($config['datasets'])}
                        },
                        options: {
                            responsive: true
                        }
                    });
                }
            }
        };
        </script>
        VUE;
    }
    
    public function exportReactComponent(array $config, string $name): string
    {
        $componentName = Str::studly($name);
        
        return <<<REACT
        import React, { useEffect, useRef } from 'react';
        import { Chart } from 'chart.js';
        
        export default function {$componentName}Chart() {
            const chartRef = useRef(null);
            
            useEffect(() => {
                const ctx = chartRef.current.getContext('2d');
                const chart = new Chart(ctx, {
                    type: '{$config['type']}',
                    data: {
                        labels: {$json_encode($config['labels'])},
                        datasets: {$json_encode($config['datasets'])}
                    },
                    options: {
                        responsive: true
                    }
                });
                
                return () => chart.destroy();
            }, []);
            
            return (
                <div className="chart-wrapper">
                    <canvas ref={chartRef}></canvas>
                </div>
            );
        }
        REACH;
    }
}
```

---

# Chart Templates Details

## Built-in Templates

```php
class ChartTemplateService
{
    public function getTemplates(): array
    {
        return [
            'revenue-line' => [
                'name' => 'Revenue Over Time',
                'type' => 'line',
                'description' => 'Monthly revenue tracking',
                'config' => [
                    'type' => 'line',
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'datasets' => [
                        [
                            'label' => 'Revenue',
                            'data' => [12000, 19000, 15000, 25000, 22000, 30000],
                            'borderColor' => '#3b82f6',
                            'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                            'fill' => true,
                        ],
                    ],
                ],
            ],
            'sales-bar' => [
                'name' => 'Sales by Category',
                'type' => 'bar',
                'description' => 'Product category sales',
                'config' => [
                    'type' => 'bar',
                    'labels' => ['Electronics', 'Clothing', 'Home', 'Sports', 'Books'],
                    'datasets' => [
                        [
                            'label' => 'Sales',
                            'data' => [4500, 3200, 2800, 1900, 1500],
                            'backgroundColor' => [
                                '#3b82f6', '#8b5cf6', '#06b6d4', '#22c55e', '#f59e0b'
                            ],
                        ],
                    ],
                ],
            ],
            'market-share-pie' => [
                'name' => 'Market Share',
                'type' => 'doughnut',
                'description' => 'Market distribution',
                'config' => [
                    'type' => 'doughnut',
                    'labels' => ['Our Company', 'Competitor A', 'Competitor B', 'Others'],
                    'datasets' => [
                        [
                            'label' => 'Market Share',
                            'data' => [35, 25, 20, 20],
                            'backgroundColor' => ['#3b82f6', '#8b5cf6', '#06b6d4', '#94a3b8'],
                        ],
                    ],
                ],
            ],
            'performance-radar' => [
                'name' => 'Performance Metrics',
                'type' => 'radar',
                'description' => 'Multi-axis performance',
                'config' => [
                    'type' => 'radar',
                    'labels' => ['Speed', 'Reliability', 'Security', 'Usability', 'Features', 'Support'],
                    'datasets' => [
                        [
                            'label' => 'Our Product',
                            'data' => [85, 90, 88, 75, 92, 80],
                            'borderColor' => '#3b82f6',
                            'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                        ],
                        [
                            'label' => 'Competitor',
                            'data' => [70, 75, 80, 85, 70, 65],
                            'borderColor' => '#ef4444',
                            'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function getTemplate(string $slug): ?array
    {
        return $this->getTemplates()[$slug] ?? null;
    }
    
    public function createTemplate(string $name, array $config, User $user): ChartTemplate
    {
        return ChartTemplate::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'config' => $config,
            'created_by' => $user->id,
            'is_public' => false,
        ]);
    }
}
```

---

# Success Metrics Details

## Key Performance Indicators

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Charts Created | 3,000/month | 5,000+ | Database count |
| Preview Render Time | 600ms | <500ms | Average render time |
| Code Export Usage | 65% | 70%+ | Exports / Charts |
| Chart Templates | 30 | 50+ | Template count |
| User Satisfaction | 4.2/5 | 4.5/5 | Survey score |
| Save Rate | 40% | 50%+ | Saves / Charts |
| Share Rate | 15% | 20%+ | Shares / Charts |

## Performance Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Editor Load Time | 1.5s | <1s | Initial load |
| Data Table Response | 50ms | <30ms | Input latency |
| Chart Render Time | 300ms | <200ms | Render time |
| Export Generation | 400ms | <300ms | Generation time |
| Image Export Time | 800ms | <600ms | Export time |

## User Engagement Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Return Users | 35% | 45%+ | Monthly retention |
| Template Usage | 30% | 40%+ | Templates / Charts |
| Data Import Usage | 25% | 35%+ | Imports / Charts |
| Advanced Features | 40% | 50%+ | Users using custom options |

---

# Next Document

**20 - MCP** — Model Context Protocol integration for AI assistants.
