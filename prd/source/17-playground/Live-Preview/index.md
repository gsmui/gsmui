---
title: "Live Preview"
description: "Real-time rendering of component code with instant feedback"
volume: "17"
---

# Live Preview

The Live Preview system provides real-time rendering of component code with instant feedback, enabling rapid iteration and visual validation during development.

## Overview

Live Preview automatically compiles and renders component code as you type, showing exactly how components will appear and behave in production. It includes responsive testing, theme simulation, and accessibility auditing.

## Core Features

### Real-Time Rendering

| Feature | Description |
|---------|-------------|
| Instant updates | Changes reflected within 50ms of typing |
| Hot module replacement | No full reload on code changes |
| State preservation | Component state maintained across edits |
| Error overlay | Clear error messages with file/line references |
| Compilation status | Visual indicator of build progress |

### Preview Modes

```yaml
preview:
  modes:
    - desktop    # Full-width desktop view
    - tablet     # 768px viewport
    - mobile     # 375px viewport
    - custom     # User-defined dimensions
  orientation:
    - portrait
    - landscape
```

| Mode | Viewport | Use Case |
|------|----------|----------|
| Desktop | 100% width | Full component testing |
| Tablet | 768px × 1024px | Responsive breakpoint testing |
| Mobile | 375px × 812px | Mobile-first validation |
| Custom | User-defined | Specific device testing |

### Hot Reload

- **CSS changes**: Instant style updates without flicker
- **Template changes**: Partial DOM updates with state preservation
- **JavaScript changes**: Module hot replacement with state retention
- **Livewire updates**: Component re-render with wire:ignore respect

### iframe Sandboxing

| Security Layer | Implementation |
|----------------|----------------|
| Origin isolation | Separate origin for preview content |
| CSP enforcement | Strict Content Security Policy |
| Feature restrictions | Disabled clipboard, notifications, geolocation |
| Network isolation | No cross-origin requests to main app |
| Storage isolation | Separate localStorage/cookies per session |

## Responsive Preview

### Device Simulation

```yaml
devices:
  - name: "iPhone 14 Pro"
    width: 393
    height: 852
    pixelRatio: 3
    userAgent: "Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X)"
    
  - name: "Samsung Galaxy S23"
    width: 360
    height: 780
    pixelRatio: 3
    userAgent: "Mozilla/5.0 (Linux; Android 13; SM-S911B)"
    
  - name: "iPad Pro 12.9"
    width: 1024
    height: 1366
    pixelRatio: 2
    userAgent: "Mozilla/5.0 (iPad; CPU OS 16_0 like Mac OS X)"
```

### Breakpoint Indicators

Visual indicators show CSS breakpoint transitions:

| Breakpoint | Width | Color |
|------------|-------|-------|
| sm | 640px | Blue |
| md | 768px | Green |
| lg | 1024px | Yellow |
| xl | 1280px | Orange |
| 2xl | 1536px | Red |

### Orientation Support

- Portrait/landscape toggle
- Rotation animation preview
- Safe area inset simulation
- Notch/home indicator rendering

## Theme Simulation

### Theme Switching

```yaml
themes:
  - name: Light
    variables:
      --bg-primary: "#ffffff"
      --text-primary: "#1f2937"
      
  - name: Dark
    variables:
      --bg-primary: "#111827"
      --text-primary: "#f9fafb"
      
  - name: High Contrast
    variables:
      --bg-primary: "#000000"
      --text-primary: "#ffffff"
```

### Custom Theme Preview

- Import existing theme variables
- Override specific variables for testing
- Preview with user's custom themes
- Generate theme preview screenshots

## Accessibility Preview

### Built-in Tools

| Tool | Description |
|------|-------------|
| WCAG contrast checker | Validates text/background contrast ratios |
| Focus indicator | Highlights keyboard navigation paths |
| Screen reader preview | ARIA announcement simulation |
| Color blindness simulation | Protanopia, deuteranopia, tritanopia |
| Motion sensitivity | Reduced motion preference preview |

### Accessibility Reports

```
Contrast Issues:
- Warning: Button text ratio 3.2:1 (needs 4.5:1)
- Error: Placeholder text ratio 1.8:1 (needs 4.5:1)

Focus Issues:
- Warning: Interactive element missing visible focus
- Error: Modal trap not implemented

ARIA Issues:
- Warning: Icon button missing aria-label
- Error: Form input missing associated label
```

## Performance Monitoring

### Preview Performance Metrics

| Metric | Target | Description |
|--------|--------|-------------|
| First Paint | < 100ms | Time to first visual output |
| Interactive | < 500ms | Time to interactive preview |
| Memory Usage | < 50MB | Preview iframe memory |
| CPU Usage | < 30% | Preview CPU utilization |

### Performance Tools

- **Render timeline**: Visualize component render cycles
- **Memory profiler**: Track memory allocation patterns
- **Network monitor**: Preview request/responses
- **Frame rate**: Monitor animation smoothness (60fps target)

## Preview Controls

### Control Panel

| Control | Function |
|---------|----------|
| Refresh | Manual preview refresh |
| Pause | Pause automatic updates |
| Clear | Clear preview state |
| Export | Download preview as HTML |
| Screenshot | Capture current preview |
| Fullscreen | Expand preview to fill viewport |

### URL Bar

```
https://playground.gsmui.dev/preview?theme=dark&device=iphone14&viewport=375x812
```

Query parameters for direct linking to specific preview configurations.

## Integration Points

- **Code Editor**: Bidirectional sync between code and preview
- **AI Assistant**: Generate preview with AI-suggested code
- **Share**: Generate preview links for collaboration
- **Export**: Download preview as standalone HTML file
- **Templates**: Preview template implementations
- **Snippets**: Preview snippet code in isolation

## Browser Support

| Browser | Support Level |
|---------|---------------|
| Chrome 90+ | Full |
| Firefox 88+ | Full |
| Safari 14+ | Full |
| Edge 90+ | Full |
| Opera 76+ | Full |

## Limitations

- Web Worker preview requires secure context (HTTPS/localhost)
- Some browser APIs unavailable in sandboxed iframe
- Native browser dialogs blocked in preview
- Device sensors (accelerometer, gyroscope) simulated
- WebGL performance may vary by browser

## Security

| Measure | Description |
|---------|-------------|
| iframe sandboxing | Isolated preview environment |
| Content Security Policy | Strict CSP for preview content |
| Origin isolation | Separate origin for preview |
| Feature restrictions | Disabled clipboard, notifications |
| Network isolation | No cross-origin requests |
| Storage isolation | Separate localStorage per session |

## Testing

| Test Type | Description |
|-----------|-------------|
| Unit tests | Preview component logic |
| Integration tests | Preview with code editor |
| Performance tests | Rendering speed benchmarks |
| Accessibility tests | WCAG compliance verification |
| Cross-browser tests | Browser compatibility |

## Edge Cases

| Scenario | Handling |
|----------|----------|
| Infinite loops | Timeout and termination |
| Memory leaks | Resource cleanup |
| Large components | Virtual rendering |
| Complex animations | Frame rate optimization |
| External resources | Blocked with warning |
| Error recovery | Graceful degradation