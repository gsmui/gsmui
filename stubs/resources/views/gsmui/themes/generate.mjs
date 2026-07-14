import { readFileSync, writeFileSync, mkdirSync, existsSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname(fileURLToPath(import.meta.url));

// Parse the PHP config file - extract JSON-like data from PHP array
function parsePhpConfig(filepath) {
    const content = readFileSync(filepath, 'utf-8');
    // Extract the return array by evaluating as JavaScript
    // We'll manually parse the theme list since PHP arrays have a different format
    
    // Status colors
    const statusLight = {
        '--color-success': '#16a34a',
        '--color-success-hover': '#15803d',
        '--color-success-foreground': '#ffffff',
        '--color-success-content': '#166534',
        '--color-success-light': '#f0fdf4',
        '--color-success-border': '#bbf7d0',
        '--color-warning': '#d97706',
        '--color-warning-hover': '#b45309',
        '--color-warning-foreground': '#ffffff',
        '--color-warning-content': '#92400e',
        '--color-warning-light': '#fffbeb',
        '--color-warning-border': '#fde68a',
        '--color-danger': '#dc2626',
        '--color-danger-hover': '#b91c1c',
        '--color-danger-foreground': '#ffffff',
        '--color-danger-content': '#991b1b',
        '--color-danger-light': '#fef2f2',
        '--color-danger-border': '#fecaca',
        '--color-info': '#0284c7',
        '--color-info-hover': '#0369a1',
        '--color-info-foreground': '#ffffff',
        '--color-info-content': '#075985',
        '--color-info-light': '#f0f9ff',
        '--color-info-border': '#bae6fd',
    };

    const statusDark = {
        '--color-success': '#22c55e',
        '--color-success-hover': '#4ade80',
        '--color-success-foreground': '#000000',
        '--color-success-content': '#86efac',
        '--color-success-light': '#0d2818',
        '--color-success-border': '#166534',
        '--color-warning': '#f59e0b',
        '--color-warning-hover': '#fbbf24',
        '--color-warning-foreground': '#000000',
        '--color-warning-content': '#fcd34d',
        '--color-warning-light': '#3b2a08',
        '--color-warning-border': '#92400e',
        '--color-danger': '#ef4444',
        '--color-danger-hover': '#f87171',
        '--color-danger-foreground': '#ffffff',
        '--color-danger-content': '#fca5a5',
        '--color-danger-light': '#351520',
        '--color-danger-border': '#991b1b',
        '--color-info': '#0ea5e9',
        '--color-info-hover': '#38bdf8',
        '--color-info-foreground': '#000000',
        '--color-info-content': '#7dd3fc',
        '--color-info-light': '#0a2e4a',
        '--color-info-border': '#075985',
    };

    const utility = {
        '--color-radius': '.75rem',
        '--color-radius-sm': '.5rem',
        '--color-radius-lg': '1rem',
        '--color-shadow': '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
        '--color-shadow-lg': '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
        '--color-shadow-xl': '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
        '--color-shadow-dark': '0 1px 3px 0 rgb(0 0 0 / 0.3), 0 1px 2px -1px rgb(0 0 0 / 0.3)',
        '--color-shadow-lg-dark': '0 10px 15px -3px rgb(0 0 0 / 0.3), 0 4px 6px -4px rgb(0 0 0 / 0.3)',
        '--color-font-mono': 'ui-monospace, SFMono-Regular, "SF Mono", Menlo, Consolas, monospace',
        '--color-font-sans': 'ui-sans-serif, system-ui, -apple-system, sans-serif',
    };

    // Base color palettes (extracted from PHP config structure)
    const bases = {
        zinc: {
            label: 'Zinc',
            light: { bg: '#ffffff', 'bg-muted': '#f4f4f5', 'bg-surface': '#ffffff', 'bg-elevated': '#fafafa', text: '#18181b', 'text-muted': '#71717a', 'text-subtle': '#a1a1aa', border: '#e4e4e7', 'border-light': '#f4f4f5', ring: '#d4d4d8' },
            dark: { bg: '#09090b', 'bg-muted': '#18181b', 'bg-surface': '#18181b', 'bg-elevated': '#27272a', text: '#fafafa', 'text-muted': '#a1a1aa', 'text-subtle': '#71717a', border: '#27272a', 'border-light': '#18181b', ring: '#3f3f46' },
        },
        slate: {
            label: 'Slate',
            light: { bg: '#ffffff', 'bg-muted': '#f1f5f9', 'bg-surface': '#ffffff', 'bg-elevated': '#f8fafc', text: '#0f172a', 'text-muted': '#64748b', 'text-subtle': '#94a3b8', border: '#e2e8f0', 'border-light': '#f1f5f9', ring: '#cbd5e1' },
            dark: { bg: '#020617', 'bg-muted': '#0f172a', 'bg-surface': '#0f172a', 'bg-elevated': '#1e293b', text: '#f8fafc', 'text-muted': '#94a3b8', 'text-subtle': '#64748b', border: '#1e293b', 'border-light': '#0f172a', ring: '#334155' },
        },
        gray: {
            label: 'Gray',
            light: { bg: '#ffffff', 'bg-muted': '#f3f4f6', 'bg-surface': '#ffffff', 'bg-elevated': '#f9fafb', text: '#111827', 'text-muted': '#6b7280', 'text-subtle': '#9ca3af', border: '#e5e7eb', 'border-light': '#f3f4f6', ring: '#d1d5db' },
            dark: { bg: '#030712', 'bg-muted': '#111827', 'bg-surface': '#111827', 'bg-elevated': '#1f2937', text: '#f9fafb', 'text-muted': '#9ca3af', 'text-subtle': '#6b7280', border: '#1f2937', 'border-light': '#111827', ring: '#374151' },
        },
        neutral: {
            label: 'Neutral',
            light: { bg: '#ffffff', 'bg-muted': '#f5f5f5', 'bg-surface': '#ffffff', 'bg-elevated': '#fafafa', text: '#171717', 'text-muted': '#737373', 'text-subtle': '#a3a3a3', border: '#e5e5e5', 'border-light': '#f5f5f5', ring: '#d4d4d4' },
            dark: { bg: '#0a0a0a', 'bg-muted': '#171717', 'bg-surface': '#171717', 'bg-elevated': '#262626', text: '#fafafa', 'text-muted': '#a3a3a3', 'text-subtle': '#737373', border: '#262626', 'border-light': '#171717', ring: '#404040' },
        },
        stone: {
            label: 'Stone',
            light: { bg: '#ffffff', 'bg-muted': '#f5f4f1', 'bg-surface': '#ffffff', 'bg-elevated': '#fafaf9', text: '#1c1917', 'text-muted': '#78716c', 'text-subtle': '#a8a29e', border: '#e7e5e4', 'border-light': '#f5f4f1', ring: '#d6d3d1' },
            dark: { bg: '#0c0a09', 'bg-muted': '#1c1917', 'bg-surface': '#1c1917', 'bg-elevated': '#292524', text: '#fafaf9', 'text-muted': '#a8a29e', 'text-subtle': '#78716c', border: '#292524', 'border-light': '#1c1917', ring: '#44403c' },
        },
        mauve: {
            label: 'Mauve',
            light: { bg: '#ffffff', 'bg-muted': '#f5f3f7', 'bg-surface': '#ffffff', 'bg-elevated': '#faf9fb', text: '#1a1523', 'text-muted': '#756f86', 'text-subtle': '#a59fb7', border: '#e5e1eb', 'border-light': '#f5f3f7', ring: '#d4cddb' },
            dark: { bg: '#0c0912', 'bg-muted': '#1a1523', 'bg-surface': '#1a1523', 'bg-elevated': '#292234', text: '#faf9fb', 'text-muted': '#a59fb7', 'text-subtle': '#756f86', border: '#292234', 'border-light': '#1a1523', ring: '#3d3551' },
        },
        olive: {
            label: 'Olive',
            light: { bg: '#ffffff', 'bg-muted': '#f4f5f1', 'bg-surface': '#ffffff', 'bg-elevated': '#fafaf8', text: '#1a1e12', 'text-muted': '#757a64', 'text-subtle': '#a3a892', border: '#e4e7db', 'border-light': '#f4f5f1', ring: '#d3d7c7' },
            dark: { bg: '#0b0e06', 'bg-muted': '#1a1e12', 'bg-surface': '#1a1e12', 'bg-elevated': '#262d1f', text: '#fafaf8', 'text-muted': '#a3a892', 'text-subtle': '#757a64', border: '#262d1f', 'border-light': '#1a1e12', ring: '#3d452e' },
        },
        sand: {
            label: 'Sand',
            light: { bg: '#ffffff', 'bg-muted': '#f4f3ef', 'bg-surface': '#ffffff', 'bg-elevated': '#faf9f6', text: '#1c1a16', 'text-muted': '#76725b', 'text-subtle': '#a59f83', border: '#e4e2d9', 'border-light': '#f4f3ef', ring: '#d3cfc3' },
            dark: { bg: '#0c0b08', 'bg-muted': '#1c1a16', 'bg-surface': '#1c1a16', 'bg-elevated': '#28251e', text: '#faf9f6', 'text-muted': '#a59f83', 'text-subtle': '#76725b', border: '#28251e', 'border-light': '#1c1a16', ring: '#3b372d' },
        },
        snow: {
            label: 'Snow',
            light: { bg: '#ffffff', 'bg-muted': '#f8f8ff', 'bg-surface': '#ffffff', 'bg-elevated': '#fcfcff', text: '#0f0f1a', 'text-muted': '#6e6e80', 'text-subtle': '#9e9eb0', border: '#e8e8f0', 'border-light': '#f4f4f8', ring: '#d0d0e0' },
            dark: { bg: '#0a0a14', 'bg-muted': '#141420', 'bg-surface': '#141420', 'bg-elevated': '#1e1e30', text: '#f8f8ff', 'text-muted': '#9e9eb0', 'text-subtle': '#6e6e80', border: '#1e1e30', 'border-light': '#141420', ring: '#2e2e45' },
        },
        ivory: {
            label: 'Ivory',
            light: { bg: '#fefef5', 'bg-muted': '#f5f3e8', 'bg-surface': '#fefef5', 'bg-elevated': '#faf9ed', text: '#1a1814', 'text-muted': '#74705b', 'text-subtle': '#a39e87', border: '#e4e0cd', 'border-light': '#f2efe0', ring: '#d2ceb8' },
            dark: { bg: '#0f0e0a', 'bg-muted': '#1c1a14', 'bg-surface': '#1c1a14', 'bg-elevated': '#2a261d', text: '#faf9ed', 'text-muted': '#a39e87', 'text-subtle': '#74705b', border: '#2a261d', 'border-light': '#1c1a14', ring: '#3d382b' },
        },
    };

    const accents = {
        blue: { label: 'Blue', light: { accent: '#2563eb', 'accent-hover': '#1d4ed8', 'accent-foreground': '#ffffff', 'accent-content': '#1e40af', 'accent-light': '#eff6ff', 'accent-border': '#bfdbfe' }, dark: { accent: '#3b82f6', 'accent-hover': '#60a5fa', 'accent-foreground': '#ffffff', 'accent-content': '#93c5fd', 'accent-light': '#1e3a5f', 'accent-border': '#1e40af' } },
        red: { label: 'Red', light: { accent: '#dc2626', 'accent-hover': '#b91c1c', 'accent-foreground': '#ffffff', 'accent-content': '#991b1b', 'accent-light': '#fef2f2', 'accent-border': '#fecaca' }, dark: { accent: '#ef4444', 'accent-hover': '#f87171', 'accent-foreground': '#ffffff', 'accent-content': '#fca5a5', 'accent-light': '#3b1a1a', 'accent-border': '#991b1b' } },
        orange: { label: 'Orange', light: { accent: '#ea580c', 'accent-hover': '#c2410c', 'accent-foreground': '#ffffff', 'accent-content': '#9a3412', 'accent-light': '#fff7ed', 'accent-border': '#fed7aa' }, dark: { accent: '#f97316', 'accent-hover': '#fb923c', 'accent-foreground': '#ffffff', 'accent-content': '#fdba74', 'accent-light': '#3b1f0a', 'accent-border': '#9a3412' } },
        amber: { label: 'Amber', light: { accent: '#d97706', 'accent-hover': '#b45309', 'accent-foreground': '#ffffff', 'accent-content': '#92400e', 'accent-light': '#fffbeb', 'accent-border': '#fde68a' }, dark: { accent: '#f59e0b', 'accent-hover': '#fbbf24', 'accent-foreground': '#000000', 'accent-content': '#fcd34d', 'accent-light': '#3b2a08', 'accent-border': '#92400e' } },
        yellow: { label: 'Yellow', light: { accent: '#ca8a04', 'accent-hover': '#a16207', 'accent-foreground': '#ffffff', 'accent-content': '#854d0e', 'accent-light': '#fefce8', 'accent-border': '#fef08a' }, dark: { accent: '#eab308', 'accent-hover': '#facc15', 'accent-foreground': '#000000', 'accent-content': '#fde047', 'accent-light': '#3b3008', 'accent-border': '#854d0e' } },
        lime: { label: 'Lime', light: { accent: '#65a30d', 'accent-hover': '#4d7c0f', 'accent-foreground': '#ffffff', 'accent-content': '#3f6212', 'accent-light': '#f7fee7', 'accent-border': '#d9f99d' }, dark: { accent: '#84cc16', 'accent-hover': '#a3e635', 'accent-foreground': '#000000', 'accent-content': '#bef264', 'accent-light': '#1a2e08', 'accent-border': '#3f6212' } },
        green: { label: 'Green', light: { accent: '#16a34a', 'accent-hover': '#15803d', 'accent-foreground': '#ffffff', 'accent-content': '#166534', 'accent-light': '#f0fdf4', 'accent-border': '#bbf7d0' }, dark: { accent: '#22c55e', 'accent-hover': '#4ade80', 'accent-foreground': '#000000', 'accent-content': '#86efac', 'accent-light': '#0d2818', 'accent-border': '#166534' } },
        emerald: { label: 'Emerald', light: { accent: '#059669', 'accent-hover': '#047857', 'accent-foreground': '#ffffff', 'accent-content': '#065f46', 'accent-light': '#ecfdf5', 'accent-border': '#a7f3d0' }, dark: { accent: '#10b981', 'accent-hover': '#34d399', 'accent-foreground': '#000000', 'accent-content': '#6ee7b7', 'accent-light': '#0a2e1e', 'accent-border': '#065f46' } },
        teal: { label: 'Teal', light: { accent: '#0d9488', 'accent-hover': '#0f766e', 'accent-foreground': '#ffffff', 'accent-content': '#115e59', 'accent-light': '#f0fdfa', 'accent-border': '#99f6e4' }, dark: { accent: '#14b8a6', 'accent-hover': '#2dd4bf', 'accent-foreground': '#000000', 'accent-content': '#5eead4', 'accent-light': '#0a2c26', 'accent-border': '#115e59' } },
        cyan: { label: 'Cyan', light: { accent: '#0891b2', 'accent-hover': '#0e7490', 'accent-foreground': '#ffffff', 'accent-content': '#155e75', 'accent-light': '#ecfeff', 'accent-border': '#a5f3fc' }, dark: { accent: '#06b6d4', 'accent-hover': '#22d3ee', 'accent-foreground': '#000000', 'accent-content': '#67e8f9', 'accent-light': '#082c34', 'accent-border': '#155e75' } },
        sky: { label: 'Sky', light: { accent: '#0284c7', 'accent-hover': '#0369a1', 'accent-foreground': '#ffffff', 'accent-content': '#075985', 'accent-light': '#f0f9ff', 'accent-border': '#bae6fd' }, dark: { accent: '#0ea5e9', 'accent-hover': '#38bdf8', 'accent-foreground': '#000000', 'accent-content': '#7dd3fc', 'accent-light': '#0a2e4a', 'accent-border': '#075985' } },
        indigo: { label: 'Indigo', light: { accent: '#4f46e5', 'accent-hover': '#4338ca', 'accent-foreground': '#ffffff', 'accent-content': '#3730a3', 'accent-light': '#eef2ff', 'accent-border': '#c7d2fe' }, dark: { accent: '#6366f1', 'accent-hover': '#818cf8', 'accent-foreground': '#ffffff', 'accent-content': '#a5b4fc', 'accent-light': '#1a1a4e', 'accent-border': '#3730a3' } },
        violet: { label: 'Violet', light: { accent: '#7c3aed', 'accent-hover': '#6d28d9', 'accent-foreground': '#ffffff', 'accent-content': '#5b21b6', 'accent-light': '#f5f3ff', 'accent-border': '#ddd6fe' }, dark: { accent: '#8b5cf6', 'accent-hover': '#a78bfa', 'accent-foreground': '#ffffff', 'accent-content': '#c4b5fd', 'accent-light': '#221a4a', 'accent-border': '#5b21b6' } },
        purple: { label: 'Purple', light: { accent: '#9333ea', 'accent-hover': '#7e22ce', 'accent-foreground': '#ffffff', 'accent-content': '#6b21a8', 'accent-light': '#faf5ff', 'accent-border': '#e9d5ff' }, dark: { accent: '#a855f7', 'accent-hover': '#c084fc', 'accent-foreground': '#ffffff', 'accent-content': '#d8b4fe', 'accent-light': '#261a4a', 'accent-border': '#6b21a8' } },
        fuchsia: { label: 'Fuchsia', light: { accent: '#c026d3', 'accent-hover': '#a21caf', 'accent-foreground': '#ffffff', 'accent-content': '#86198f', 'accent-light': '#fdf4ff', 'accent-border': '#f5d0fe' }, dark: { accent: '#d946ef', 'accent-hover': '#e879f9', 'accent-foreground': '#ffffff', 'accent-content': '#f0abfc', 'accent-light': '#2e1a3e', 'accent-border': '#86198f' } },
        pink: { label: 'Pink', light: { accent: '#db2777', 'accent-hover': '#be185d', 'accent-foreground': '#ffffff', 'accent-content': '#9d174d', 'accent-light': '#fdf2f8', 'accent-border': '#fbcfe8' }, dark: { accent: '#ec4899', 'accent-hover': '#f472b6', 'accent-foreground': '#ffffff', 'accent-content': '#f9a8d4', 'accent-light': '#301a28', 'accent-border': '#9d174d' } },
        rose: { label: 'Rose', light: { accent: '#e11d48', 'accent-hover': '#be123c', 'accent-foreground': '#ffffff', 'accent-content': '#9f1239', 'accent-light': '#fff1f2', 'accent-border': '#fecdd3' }, dark: { accent: '#f43f5e', 'accent-hover': '#fb7185', 'accent-foreground': '#ffffff', 'accent-content': '#fda4af', 'accent-light': '#351520', 'accent-border': '#9f1239' } },
    };

    const themes = [
        // Classic
        { id: 'zinc-blue', base: 'zinc', accent: 'blue', cat: 'classic' },
        { id: 'zinc-red', base: 'zinc', accent: 'red', cat: 'classic' },
        { id: 'zinc-emerald', base: 'zinc', accent: 'emerald', cat: 'classic' },
        { id: 'zinc-violet', base: 'zinc', accent: 'violet', cat: 'classic' },
        { id: 'zinc-amber', base: 'zinc', accent: 'amber', cat: 'classic' },
        { id: 'zinc-rose', base: 'zinc', accent: 'rose', cat: 'classic' },
        { id: 'zinc-sky', base: 'zinc', accent: 'sky', cat: 'classic' },
        { id: 'zinc-teal', base: 'zinc', accent: 'teal', cat: 'classic' },
        { id: 'zinc-orange', base: 'zinc', accent: 'orange', cat: 'classic' },
        { id: 'zinc-pink', base: 'zinc', accent: 'pink', cat: 'classic' },
        { id: 'zinc-indigo', base: 'zinc', accent: 'indigo', cat: 'classic' },
        { id: 'zinc-lime', base: 'zinc', accent: 'lime', cat: 'classic' },
        { id: 'slate-blue', base: 'slate', accent: 'blue', cat: 'classic' },
        { id: 'slate-emerald', base: 'slate', accent: 'emerald', cat: 'classic' },
        { id: 'slate-violet', base: 'slate', accent: 'violet', cat: 'classic' },
        { id: 'slate-red', base: 'slate', accent: 'red', cat: 'classic' },
        { id: 'slate-cyan', base: 'slate', accent: 'cyan', cat: 'classic' },
        { id: 'slate-rose', base: 'slate', accent: 'rose', cat: 'classic' },
        { id: 'slate-amber', base: 'slate', accent: 'amber', cat: 'classic' },
        { id: 'slate-teal', base: 'slate', accent: 'teal', cat: 'classic' },
        { id: 'slate-orange', base: 'slate', accent: 'orange', cat: 'classic' },
        { id: 'slate-pink', base: 'slate', accent: 'pink', cat: 'classic' },
        { id: 'gray-blue', base: 'gray', accent: 'blue', cat: 'classic' },
        { id: 'gray-red', base: 'gray', accent: 'red', cat: 'classic' },
        { id: 'gray-green', base: 'gray', accent: 'green', cat: 'classic' },
        { id: 'gray-violet', base: 'gray', accent: 'violet', cat: 'classic' },
        { id: 'gray-amber', base: 'gray', accent: 'amber', cat: 'classic' },
        { id: 'gray-teal', base: 'gray', accent: 'teal', cat: 'classic' },
        { id: 'gray-sky', base: 'gray', accent: 'sky', cat: 'classic' },
        { id: 'gray-fuchsia', base: 'gray', accent: 'fuchsia', cat: 'classic' },
        { id: 'neutral-blue', base: 'neutral', accent: 'blue', cat: 'classic' },
        { id: 'neutral-emerald', base: 'neutral', accent: 'emerald', cat: 'classic' },
        { id: 'neutral-violet', base: 'neutral', accent: 'violet', cat: 'classic' },
        { id: 'neutral-amber', base: 'neutral', accent: 'amber', cat: 'classic' },
        { id: 'neutral-rose', base: 'neutral', accent: 'rose', cat: 'classic' },
        { id: 'neutral-cyan', base: 'neutral', accent: 'cyan', cat: 'classic' },
        { id: 'stone-emerald', base: 'stone', accent: 'emerald', cat: 'classic' },
        { id: 'stone-blue', base: 'stone', accent: 'blue', cat: 'classic' },
        { id: 'stone-amber', base: 'stone', accent: 'amber', cat: 'classic' },
        { id: 'stone-red', base: 'stone', accent: 'red', cat: 'classic' },
        { id: 'stone-rose', base: 'stone', accent: 'rose', cat: 'classic' },
        { id: 'mauve-violet', base: 'mauve', accent: 'violet', cat: 'classic' },
        { id: 'mauve-pink', base: 'mauve', accent: 'pink', cat: 'classic' },
        { id: 'mauve-purple', base: 'mauve', accent: 'purple', cat: 'classic' },
        { id: 'mauve-blue', base: 'mauve', accent: 'blue', cat: 'classic' },
        { id: 'mauve-rose', base: 'mauve', accent: 'rose', cat: 'classic' },
        { id: 'olive-green', base: 'olive', accent: 'green', cat: 'classic' },
        { id: 'olive-emerald', base: 'olive', accent: 'emerald', cat: 'classic' },
        { id: 'olive-teal', base: 'olive', accent: 'teal', cat: 'classic' },
        { id: 'olive-amber', base: 'olive', accent: 'amber', cat: 'classic' },
        { id: 'olive-lime', base: 'olive', accent: 'lime', cat: 'classic' },
        { id: 'sand-amber', base: 'sand', accent: 'amber', cat: 'classic' },
        { id: 'sand-orange', base: 'sand', accent: 'orange', cat: 'classic' },
        { id: 'sand-red', base: 'sand', accent: 'red', cat: 'classic' },
        { id: 'sand-teal', base: 'sand', accent: 'teal', cat: 'classic' },
        { id: 'sand-emerald', base: 'sand', accent: 'emerald', cat: 'classic' },
        { id: 'snow-blue', base: 'snow', accent: 'blue', cat: 'classic' },
        { id: 'snow-sky', base: 'snow', accent: 'sky', cat: 'classic' },
        { id: 'snow-cyan', base: 'snow', accent: 'cyan', cat: 'classic' },
        { id: 'snow-indigo', base: 'snow', accent: 'indigo', cat: 'classic' },
        { id: 'snow-rose', base: 'snow', accent: 'rose', cat: 'classic' },
        { id: 'ivory-amber', base: 'ivory', accent: 'amber', cat: 'classic' },
        { id: 'ivory-emerald', base: 'ivory', accent: 'emerald', cat: 'classic' },
        { id: 'ivory-rose', base: 'ivory', accent: 'rose', cat: 'classic' },
        { id: 'ivory-teal', base: 'ivory', accent: 'teal', cat: 'classic' },
        { id: 'ivory-orange', base: 'ivory', accent: 'orange', cat: 'classic' },
        // Dark
        { id: 'dark-midnight', base: 'slate', accent: 'blue', cat: 'dark' },
        { id: 'dark-noir', base: 'zinc', accent: 'red', cat: 'dark' },
        { id: 'dark-forest', base: 'olive', accent: 'emerald', cat: 'dark' },
        { id: 'dark-plum', base: 'mauve', accent: 'violet', cat: 'dark' },
        { id: 'dark-charcoal', base: 'neutral', accent: 'amber', cat: 'dark' },
        { id: 'dark-obsidian', base: 'slate', accent: 'teal', cat: 'dark' },
        { id: 'dark-raven', base: 'gray', accent: 'rose', cat: 'dark' },
        { id: 'dark-shadow', base: 'zinc', accent: 'violet', cat: 'dark' },
        { id: 'dark-cave', base: 'stone', accent: 'orange', cat: 'dark' },
        { id: 'dark-void', base: 'neutral', accent: 'cyan', cat: 'dark' },
        { id: 'dark-crimson', base: 'slate', accent: 'red', cat: 'dark' },
        { id: 'dark-sapphire', base: 'slate', accent: 'sky', cat: 'dark' },
        // Vibrant
        { id: 'vibrant-ocean', base: 'slate', accent: 'cyan', cat: 'vibrant' },
        { id: 'vibrant-sunset', base: 'zinc', accent: 'orange', cat: 'vibrant' },
        { id: 'vibrant-lush', base: 'neutral', accent: 'emerald', cat: 'vibrant' },
        { id: 'vibrant-candy', base: 'snow', accent: 'pink', cat: 'vibrant' },
        { id: 'vibrant-royal', base: 'slate', accent: 'purple', cat: 'vibrant' },
        { id: 'vibrant-tropic', base: 'sand', accent: 'teal', cat: 'vibrant' },
        { id: 'vibrant-aurora', base: 'slate', accent: 'green', cat: 'vibrant' },
        { id: 'vibrant-coral', base: 'zinc', accent: 'rose', cat: 'vibrant' },
        { id: 'vibrant-lavender', base: 'snow', accent: 'violet', cat: 'vibrant' },
        { id: 'vibrant-mango', base: 'sand', accent: 'amber', cat: 'vibrant' },
        { id: 'vibrant-berry', base: 'snow', accent: 'fuchsia', cat: 'vibrant' },
        { id: 'vibrant-limeade', base: 'olive', accent: 'lime', cat: 'vibrant' },
        // Nature
        { id: 'nature-forest', base: 'stone', accent: 'emerald', cat: 'nature' },
        { id: 'nature-desert', base: 'sand', accent: 'amber', cat: 'nature' },
        { id: 'nature-ocean', base: 'slate', accent: 'blue', cat: 'nature' },
        { id: 'nature-meadow', base: 'olive', accent: 'green', cat: 'nature' },
        { id: 'nature-sunrise', base: 'ivory', accent: 'orange', cat: 'nature' },
        { id: 'nature-pine', base: 'slate', accent: 'teal', cat: 'nature' },
        { id: 'nature-earthy', base: 'stone', accent: 'orange', cat: 'nature' },
        { id: 'nature-skyline', base: 'snow', accent: 'sky', cat: 'nature' },
        // Retro
        { id: 'retro-wash', base: 'ivory', accent: 'amber', cat: 'retro' },
        { id: 'retro-groove', base: 'sand', accent: 'orange', cat: 'retro' },
        { id: 'retro-synth', base: 'mauve', accent: 'pink', cat: 'retro' },
        { id: 'retro-vinyl', base: 'zinc', accent: 'red', cat: 'retro' },
        { id: 'retro-fade', base: 'stone', accent: 'rose', cat: 'retro' },
        { id: 'retro-arcade', base: 'neutral', accent: 'cyan', cat: 'retro' },
        { id: 'retro-vintage', base: 'ivory', accent: 'emerald', cat: 'retro' },
        { id: 'retro-chrome', base: 'slate', accent: 'red', cat: 'retro' },
        // Minimal
        { id: 'minimal-light', base: 'snow', accent: 'blue', cat: 'minimal' },
        { id: 'minimal-charcoal', base: 'zinc', accent: 'blue', cat: 'minimal' },
        { id: 'minimal-clean', base: 'neutral', accent: 'sky', cat: 'minimal' },
        { id: 'minimal-sage', base: 'olive', accent: 'emerald', cat: 'minimal' },
        { id: 'minimal-dust', base: 'stone', accent: 'amber', cat: 'minimal' },
        { id: 'minimal-ice', base: 'snow', accent: 'cyan', cat: 'minimal' },
        { id: 'minimal-warmth', base: 'ivory', accent: 'rose', cat: 'minimal' },
        { id: 'minimal-stone', base: 'gray', accent: 'sky', cat: 'minimal' },
        // Special
        { id: 'special-nord', base: 'slate', accent: 'blue', cat: 'special' },
        { id: 'special-dracula', base: 'mauve', accent: 'pink', cat: 'special' },
        { id: 'special-monokai', base: 'zinc', accent: 'green', cat: 'special' },
        { id: 'special-solarized', base: 'sand', accent: 'cyan', cat: 'special' },
        { id: 'special-github', base: 'gray', accent: 'blue', cat: 'special' },
        { id: 'special-notion', base: 'neutral', accent: 'red', cat: 'special' },
        { id: 'special-vercel', base: 'zinc', accent: 'amber', cat: 'special' },
        { id: 'special-tailwind', base: 'slate', accent: 'cyan', cat: 'special' },
        { id: 'special-ayu', base: 'sand', accent: 'teal', cat: 'special' },
        { id: 'special-rosepine', base: 'mauve', accent: 'rose', cat: 'special' },
        { id: 'special-catppuccin', base: 'mauve', accent: 'blue', cat: 'special' },
        { id: 'special-tokyo', base: 'slate', accent: 'indigo', cat: 'special' },
    ];

    return { bases, accents, themes, statusLight, statusDark, utility };
}

function generateThemeCSS(baseData, accentData, statusLight, statusDark, utility) {
    let css = '/* Gsmui Theme — CSS Variables */\n';
    css += '/* Auto-generated. Do not edit directly. */\n\n';

    // Light mode
    css += ':root {\n';
    for (const [key, value] of Object.entries(baseData.light)) {
        css += `    --color-${key}: ${value};\n`;
    }
    for (const [key, value] of Object.entries(accentData.light)) {
        css += `    --color-${key}: ${value};\n`;
    }
    for (const [varName, value] of Object.entries(statusLight)) {
        css += `    ${varName}: ${value};\n`;
    }
    for (const [varName, value] of Object.entries(utility)) {
        css += `    ${varName}: ${value};\n`;
    }
    css += '}\n\n';

    // Dark mode
    css += '.dark {\n';
    for (const [key, value] of Object.entries(baseData.dark)) {
        css += `    --color-${key}: ${value};\n`;
    }
    for (const [key, value] of Object.entries(accentData.dark)) {
        css += `    --color-${key}: ${value};\n`;
    }
    for (const [varName, value] of Object.entries(statusDark)) {
        css += `    ${varName}: ${value};\n`;
    }
    for (const [varName, value] of Object.entries(utility)) {
        css += `    ${varName.replace('-dark', '')}: ${value};\n`;
    }
    css += '}\n';

    return css;
}

// Generate
const { bases, accents, themes, statusLight, statusDark, utility } = parsePhpConfig(join(__dirname, 'themes.php'));
let count = 0;

for (const theme of themes) {
    const baseData = bases[theme.base];
    const accentData = accents[theme.accent];
    
    if (!baseData || !accentData) {
        console.log(`Skipping ${theme.id}: missing base '${theme.base}' or accent '${theme.accent}'`);
        continue;
    }
    
    const css = generateThemeCSS(baseData, accentData, statusLight, statusDark, utility);
    
    const catDir = join(__dirname, theme.cat);
    if (!existsSync(catDir)) {
        mkdirSync(catDir, { recursive: true });
    }
    
    const filename = join(catDir, `${theme.id}.css`);
    writeFileSync(filename, css);
    count++;
}

console.log(`Generated ${count} theme CSS files in ${__dirname}`);
