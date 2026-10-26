---
title: Chart Components
description: Chart components — line, bar, pie, area, scatter, sparkline, gauge, heatmap — with configuration and customization.
order: 13.6
group: Charts
---

# Chart Components

GsmUi provides responsive, themeable chart components powered by a lightweight charting engine. Charts integrate with Livewire for real-time data updates and support CSS variable theming.

## Chart Catalog

| Chart Type | Component | Best For |
|---|---|---|
| Line | `<x-gsmui:chart type="line">` | Trends over time |
| Bar | `<x-gsmui:chart type="bar">` | Comparisons |
| Pie | `<x-gsmui:chart type="pie">` | Proportions |
| Area | `<x-gsmui:chart type="area">` | Cumulative data |
| Scatter | `<x-gsmui:chart type="scatter">` | Correlations |
| Sparkline | `<x-gsmui:sparkline>` | Inline trends |
| Gauge | `<x-gsmui:gauge>` | Single metrics |
| Heatmap | `<x-gsmui:heatmap>` | Density/intensity |

## Line Chart

```blade
<x-gsmui:chart
    type="line"
    :data="$lineData"
    :options="[
        'xAxis' => ['type' => 'category', 'data' => $months],
        'yAxis' => ['type' => 'value'],
        'smooth' => true,
    ]"
    height="400"
    wire:model="chartData"
/>
```

### Line Chart Options

| Option | Type | Default | Description |
|---|---|---|---|
| `smooth` | bool | `true` | Curved lines |
| `showDots` | bool | `true` | Data point dots |
| `showGrid` | bool | `true` | Grid lines |
| `areaFill` | bool | `false` | Fill area under line |
| `stacked` | bool | `false` | Stack multiple series |
| `tension` | float | `0.4` | Line curvature |

## Bar Chart

```blade
<x-gsmui:chart
    type="bar"
    :data="$barData"
    :options="[
        'horizontal' => false,
        'barWidth' => '60%',
        'colorByCategory' => true,
    ]"
    height="300"
/>
```

| Option | Type | Default | Description |
|---|---|---|---|
| `horizontal` | bool | `false` | Horizontal bars |
| `barWidth` | string | `auto` | Bar width |
| `stacked` | bool | `false` | Stack bars |
| `rounded` | bool | `true` | Rounded bar ends |
| `colorByCategory` | bool | `false` | Color each bar differently |

## Pie Chart

```blade
<x-gsmui:chart
    type="pie"
    :data="[
        ['name' => 'Desktop', 'value' => 580],
        ['name' => 'Mobile', 'value' => 320],
        ['name' => 'Tablet', 'value' => 100],
    ]"
    :options="[
        'donut' => false,
        'showLabels' => true,
        'showLegend' => true,
    ]"
    height="400"
/>
```

| Option | Type | Default | Description |
|---|---|---|---|
| `donut` | bool | `false` | Donut style |
| `donutWidth` | int | `60` | Inner radius % |
| `showLabels` | bool | `true` | Show value labels |
| `showLegend` | bool | `true` | Show legend |
| `startAngle` | int | `0` | Rotation start |

## Area Chart

```blade
<x-gsmui:chart
    type="area"
    :data="$areaData"
    :options="[
        'stacked' => true,
        'showGrid' => true,
        'opacity' => 0.3,
    ]"
    height="350"
/>
```

| Option | Type | Default | Description |
|---|---|---|---|
| `stacked` | bool | `false` | Stack areas |
| `opacity` | float | `0.3` | Fill opacity |
| `smooth` | bool | `true` | Curved edges |
| `showGrid` | bool | `true` | Grid lines |

## Scatter Chart

```blade
<x-gsmui:chart
    type="scatter"
    :data="$scatterData"
    :options="[
        'xAxisLabel' => 'Revenue',
        'yAxisLabel' => 'Users',
        'pointSize' => 8,
    ]"
    height="400"
/>
```

| Option | Type | Default | Description |
|---|---|---|---|
| `pointSize` | int | `6` | Dot size |
| `pointShape` | string | `circle` | `circle`, `rect`, `triangle` |
| `showTrendLine` | bool | `false` | Regression line |

## Sparkline

```blade
<gsmui:sparkline :data="[10, 15, 13, 18, 22, 19, 25]" type="line" height="40" />
<gsmui:sparkline :data="[10, 15, 13, 18, 22, 19, 25]" type="bar" height="40" color="#10b981" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `data` | array | — | Data points |
| `type` | string | `line` | `line`, `bar`, `area` |
| `height` | int | `30` | Height in px |
| `color` | string | `null` | Custom color |
| `showLastValue` | bool | `false` | Show last value |

## Gauge

```blade
<gsmui:gauge :value="75" :min="0" :max="100" label="Progress" color="#2563eb" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `value` | int | — | Current value |
| `min` | int | `0` | Minimum |
| `max` | int | `100` | Maximum |
| `label` | string | `null` | Center label |
| `color` | string | `primary` | Fill color |
| `size` | string | `md` | `sm`, `md`, `lg` |
| `thickness` | int | `8` | Arc thickness |

## Heatmap

```blade
<gsmui:heatmap
    :data="$heatmapData"
    :x-labels="$weekdays"
    :y-labels="$hours"
    color-range="#dbeafe,#2563eb"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `data` | array | — | 2D value matrix |
| `x-labels` | array | — | Column labels |
| `y-labels` | array | — | Row labels |
| `color-range` | string | `#dbeafe,#2563eb` | Min/max colors |

## Chart Configuration

### Data Format

```php
// Line / Area / Scatter
$lineData = [
    ['name' => 'Revenue', 'data' => [10, 15, 13, 18, 22, 19, 25]],
    ['name' => 'Expenses', 'data' => [5, 8, 6, 10, 12, 11, 14]],
];

// Bar / Pie
$barData = [
    ['name' => 'Product A', 'value' => 50],
    ['name' => 'Product B', 'value' => 30],
    ['name' => 'Product C', 'value' => 20],
];
```

### Theme Integration

| Token | Maps To |
|---|---|
| `--gsmui-chart-color-1` | Primary series color |
| `--gsmui-chart-color-2` | Secondary series color |
| `--gsmui-chart-grid` | Grid line color |
| `--gsmui-chart-text` | Axis label color |
| `--gsmui-chart-tooltip-bg` | Tooltip background |

### Responsive Sizing

| Breakpoint | Default Height | Legend Position |
|---|---|---|
| Mobile | `250px` | Bottom |
| Tablet | `350px` | Right |
| Desktop | `400px` | Right |
