@php
/**
 * Status Component Index
 *
 * A comprehensive collection of 100 status indicator components.
 * Use individual variant files via: <x-gsmui:status.variant-name />
 *
 * Categories:
 * - Basic Indicators: basic, dot, badge, label, icon, pill, tag, chip
 * - State Indicators: online, offline, away, busy, dnd, invisible
 * - Progress States: pending, processing, completed, failed, error, warning, success, info
 * - Visual Styles: neutral, primary, secondary, accent, muted, subtle, bold, outlined, filled, ghost, flat, raised, elevated, gradient, shadow
 * - Glass Effects: glass, frosted
 * - Interactive: interactive, hoverable, clickable, selectable
 * - Theme Variants: dark, light, colored, striped
 * - Decorative Elements: with-dot, with-icon, with-avatar, with-progress, with-description, with-count, with-actions
 * - Enhanced Features: with-badge, with-timestamp, with-tooltip, with-link, with-spinner
 * - Layout Variants: stacked, inline, block, card, floating, timeline, notification
 * - Size Variants: mini, large, compact, expanded
 * - Functional Indicators: loading, progress, stepper, switch, checkbox, star
 * - Specialized: countdown, score, location, signal, battery, thermometer, level, dial, gauge, compass
 * - Live Status: livestream, connection, version, role, flag, alert-count
 * - Social: reaction, hashtag, verification, pricing
 * - Advanced: streak, uptime, availability, priority, security, currency, weather
 */
@endphp

<div class="space-y-8">
    <div>
        <h3 class="text-lg font-semibold mb-4">Basic Indicators</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.basic />
            <x-gsmui:status.dot />
            <x-gsmui:status.badge />
            <x-gsmui:status.label />
            <x-gsmui:status.icon />
            <x-gsmui:status.pill />
            <x-gsmui:status.tag />
            <x-gsmui:status.chip />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">State Indicators</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.online />
            <x-gsmui:status.offline />
            <x-gsmui:status.away />
            <x-gsmui:status.busy />
            <x-gsmui:status.dnd />
            <x-gsmui:status.invisible />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Progress States</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.pending />
            <x-gsmui:status.processing />
            <x-gsmui:status.completed />
            <x-gsmui:status.failed />
            <x-gsmui:status.error />
            <x-gsmui:status.warning />
            <x-gsmui:status.success />
            <x-gsmui:status.info />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Visual Styles</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.neutral />
            <x-gsmui:status.primary />
            <x-gsmui:status.secondary />
            <x-gsmui:status.accent />
            <x-gsmui:status.muted />
            <x-gsmui:status.subtle />
            <x-gsmui:status.bold />
            <x-gsmui:status.outlined />
            <x-gsmui:status.filled />
            <x-gsmui:status.ghost />
            <x-gsmui:status.flat />
            <x-gsmui:status.raised />
            <x-gsmui:status.elevated />
            <x-gsmui:status.gradient />
            <x-gsmui:status.shadow />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Glass Effects</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.glass />
            <x-gsmui:status.frosted />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Interactive</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.interactive />
            <x-gsmui:status.hoverable />
            <x-gsmui:status.clickable />
            <x-gsmui:status.selectable />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Theme Variants</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.dark />
            <x-gsmui:status.light />
            <x-gsmui:status.colored />
            <x-gsmui:status.striped />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Decorative Elements</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.with-dot />
            <x-gsmui:status.with-icon />
            <x-gsmui:status.with-avatar />
            <x-gsmui:status.with-progress />
            <x-gsmui:status.with-description />
            <x-gsmui:status.with-count />
            <x-gsmui:status.with-actions />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Enhanced Features</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.with-badge />
            <x-gsmui:status.with-timestamp />
            <x-gsmui:status.with-tooltip />
            <x-gsmui:status.with-link />
            <x-gsmui:status.with-spinner />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Layout Variants</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.stacked />
            <x-gsmui:status.inline />
            <x-gsmui:status.block />
            <x-gsmui:status.card />
            <x-gsmui:status.floating />
            <x-gsmui:status.timeline />
            <x-gsmui:status.notification />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Size Variants</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.mini />
            <x-gsmui:status.large />
            <x-gsmui:status.compact />
            <x-gsmui:status.expanded />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Functional Indicators</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.loading />
            <x-gsmui:status.progress />
            <x-gsmui:status.stepper />
            <x-gsmui:status.switch />
            <x-gsmui:status.checkbox />
            <x-gsmui:status.star />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Specialized Indicators</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.countdown />
            <x-gsmui:status.score />
            <x-gsmui:status.location />
            <x-gsmui:status.signal />
            <x-gsmui:status.battery />
            <x-gsmui:status.thermometer />
            <x-gsmui:status.level />
            <x-gsmui:status.dial />
            <x-gsmui:status.gauge />
            <x-gsmui:status.compass />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Live Status</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.livestream />
            <x-gsmui:status.connection />
            <x-gsmui:status.version />
            <x-gsmui:status.role />
            <x-gsmui:status.flag />
            <x-gsmui:status.alert-count />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Social</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.reaction />
            <x-gsmui:status.hashtag />
            <x-gsmui:status.verification />
            <x-gsmui:status.pricing />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Advanced Indicators</h3>
        <div class="flex flex-wrap gap-4">
            <x-gsmui:status.streak />
            <x-gsmui:status.uptime />
            <x-gsmui:status.availability />
            <x-gsmui:status.priority />
            <x-gsmui:status.security />
            <x-gsmui:status.currency />
            <x-gsmui:status.weather />
        </div>
    </div>
</div>
