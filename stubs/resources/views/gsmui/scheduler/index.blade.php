@props([
    'events' => [],
    'resources' => [],
    'view' => 'week',
    'views' => ['day', 'week', 'month', 'timeline', 'agenda'],
    'timezone' => 'UTC',
    'businessHours' => ['09:00', '17:00'],
    'slotDuration' => 30,
    'snapDuration' => 15,
    'nowIndicator' => true,
    'height' => '600px',
    'class' => '',
])

<?php
$viewClasses = match($view) {
    'day' => 'scheduler-day',
    'week' => 'scheduler-week',
    'month' => 'scheduler-month',
    'timeline' => 'scheduler-timeline',
    'agenda' => 'scheduler-agenda',
    default => 'scheduler-week',
};
?>

<div 
    class="gsmui-scheduler {{ $viewClasses }} {{ $class }}"
    style="height: {{ $height }};"
    x-data="gsmuiScheduler({
        view: '{{ $view }}',
        events: @js($events),
        resources: @js($resources),
        businessHours: @js($businessHours),
        slotDuration: @js($slotDuration),
        snapDuration: @js($snapDuration),
        timezone: '{{ $timezone }}',
        nowIndicator: @js($nowIndicator)
    })"
    role="application"
    aria-label="Event scheduler"
>

    <!-- Toolbar -->
    <div class="scheduler-toolbar flex flex-col sm:flex-row gap-3 p-3 bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
        <div class="flex items-center gap-2">
            <x-gsmui:button variant="ghost" size="sm" icon="chevron-left" @click="prev()" aria-label="Previous" />
            <x-gsmui:button variant="ghost" size="sm" icon="chevron-right" @click="next()" aria-label="Next" />
            <x-gsmui:button variant="ghost" size="sm" icon="calendar-day" @click="today()" aria-label="Today">Today</x-gsmui:button>
        </div>
        
        <div class="flex-1 flex justify-center">
            <span x-text="title" class="font-semibold text-zinc-900 dark:text-white"></span>
        </div>
        
        <div class="flex items-center gap-2">
            <template x-for="v in views" :key="v">
                <x-gsmui:button 
                    variant="ghost" 
                    size="sm" 
                    :class="{ 'bg-primary/10 text-primary': view === v }"
                    @click="setView(v)"
                    x-text="v.charAt(0).toUpperCase() + v.slice(1)"
                />
            </template>
        </div>
    </div>

    <!-- Main Content -->
    <div class="scheduler-content flex-1 overflow-auto relative">
        
        <!-- Day/Week View -->
        <template x-if="view === 'day' || view === 'week'">
            <div class="scheduler-grid" :style="{ gridTemplateColumns: timeColumnWidth + 'fr ' + (resources.length ? resources.length : 1) + 'fr' }">
                
                <!-- Time Column -->
                <div class="scheduler-time-column sticky left-0 bg-white dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700 z-10">
                    <div class="scheduler-time-header h-10 border-b border-zinc-200 dark:border-zinc-700"></div>
                    <template x-for="slot in timeSlots" :key="slot">
                        <div 
                            class="scheduler-time-slot"
                            :style="{ height: slotHeight + 'px', minHeight: slotHeight + 'px' }"
                            :class="{ 'scheduler-business-hours': isBusinessHour(slot) }"
                        >
                            <span class="scheduler-time-label" x-text="formatTime(slot)"></span>
                        </div>
                    </template>
                </div>
                
                <!-- Resource/Day Columns -->
                <template x-for="(resource, rIndex) in getResources()" :key="resource.id">
                    <div 
                        class="scheduler-resource-column relative border-r border-zinc-200 dark:border-zinc-700 last:border-r-0"
                        :style="{ minWidth: '150px' }"
                    >
                        <div class="scheduler-resource-header sticky top-0 h-10 bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 flex items-center px-2 z-10">
                            <span x-text="resource.name" class="font-medium text-sm truncate"></span>
                        </div>
                        
                        <div class="scheduler-resource-body relative" @click="createEventAt($event, resource)" @dragover.prevent @drop="dropEvent($event, resource)">
                            <!-- Now indicator -->
                            <template x-if="nowIndicator && isCurrentTimeVisible()">
                                <div class="scheduler-now-indicator absolute left-0 right-0 border-t-2 border-red-500" :style="{ top: nowIndicatorTop + 'px' }">
                                    <div class="scheduler-now-indicator-dot absolute -left-1 -top-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></div>
                                </div>
                            </template>
                            
                            <!-- Events -->
                            <template x-for="event in getEventsForResource(resource)" :key="event.id">
                                <div 
                                    class="scheduler-event absolute cursor-pointer rounded border-l-4 overflow-hidden shadow-sm transition-transform duration-100"
                                    :style="getEventStyle(event)"
                                    :class="{
                                        'scheduler-event-selected': selectedEventId === event.id,
                                        'scheduler-event-dragging': draggingEventId === event.id
                                    }"
                                    draggable="true"
                                    @click.stop="selectEvent(event)"
                                    @dragstart="dragStart($event, event)"
                                    @dragend="dragEnd"
                                    @dblclick.stop="editEvent(event)"
                                    role="button"
                                    tabindex="0"
                                    :aria-label="event.title"
                                >
                                    <div class="p-1.5 bg-white dark:bg-zinc-800" :style="{ backgroundColor: event.color + '20', borderLeftColor: event.color }">
                                        <div class="text-xs font-medium truncate" x-text="event.title"></div>
                                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400" x-text="formatEventTime(event)"></div>
                                    </div>
                                    
                                    <template x-if="event.resizable">
                                        <div class="scheduler-event-resize-handle bottom-0 h-1.5 cursor-row-resize bg-transparent hover:bg-primary/50" @mousedown.stop="startResize($event, event)"></div>
                                    </template>
                                </div>
                            </template>
                            
                            <!-- Drop zone indicator -->
                            <template x-if="dragOverResource === resource.id">
                                <div class="scheduler-drop-zone absolute inset-0 border-2 border-dashed border-primary/50 bg-primary/5 rounded-lg pointer-events-none"></div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </template>
        
        <!-- Month View -->
        <template x-if="view === 'month'">
            <div class="scheduler-month-grid">
                <div class="grid grid-cols-7 border border-zinc-200 dark:border-zinc-700">
                    <template x-for="day in monthDays" :key="day.date">
                        <div class="scheduler-month-day relative min-h-[100px] border-r border-zinc-200 dark:border-zinc-700 last:border-r-0 p-1" 
                             :class="{ 'scheduler-month-day-today': day.isToday, 'scheduler-month-day-other': day.isOtherMonth }"
                             @click="createEventAtDay(day)"
                             @dragover.prevent @drop="dropEventAtDay($event, day)">
                            <div class="scheduler-month-day-header text-xs font-medium" :class="{ 'text-primary': day.isToday }" x-text="day.day"></div>
                            <div class="scheduler-month-day-events mt-1 space-y-1 overflow-hidden">
                                <template x-for="event in getEventsForDay(day)" :key="event.id">
                                    <div class="scheduler-event text-xs px-1 py-0.5 rounded truncate cursor-pointer hover:opacity-90"
                                         :style="{ backgroundColor: event.color + '20', borderLeftColor: event.color }"
                                         @click.stop="selectEvent(event)"
                                         @dblclick.stop="editEvent(event)"
                                         draggable="true"
                                         @dragstart="dragStart($event, event)"
                                         @dragend="dragEnd"
                                         x-text="event.title"></div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
        
        <!-- Timeline View -->
        <template x-if="view === 'timeline'">
            <div class="scheduler-timeline">
                <div class="flex">
                    <div class="scheduler-timeline-resources w-48 border-r border-zinc-200 dark:border-zinc-700 overflow-y-auto">
                        <div class="h-10 border-b border-zinc-200 dark:border-zinc-700 px-2 flex items-center font-medium">Resources</div>
                        <template x-for="resource in resources" :key="resource.id">
                            <div class="h-16 border-b border-zinc-200 dark:border-zinc-700 px-2 flex items-center" x-text="resource.name"></div>
                        </template>
                    </div>
                    <div class="flex-1 overflow-auto relative">
                        <div class="scheduler-timeline-times sticky top-0 bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 flex z-10">
                            <template x-for="slot in timelineSlots" :key="slot">
                                <div class="scheduler-timeline-time-slot w-24 border-r border-zinc-200 dark:border-zinc-700 text-xs text-center py-1" x-text="slot"></div>
                            </template>
                        </div>
                        <div class="scheduler-timeline-body relative" style="height: 400px;">
                            <template x-for="resource in resources" :key="resource.id">
                                <div class="scheduler-timeline-resource-row absolute left-0 right-0 h-16 border-b border-zinc-200 dark:border-zinc-700" :style="{ top: resourceIndex * 64 + 'px' }">
                                    <template x-for="event in getEventsForResource(resource)" :key="event.id">
                                        <div class="scheduler-event absolute rounded border-l-4 shadow-sm"
                                             :style="getTimelineEventStyle(event)"
                                             :class="{ 'scheduler-event-selected': selectedEventId === event.id }"
                                             @click.stop="selectEvent(event)"
                                             @dblclick.stop="editEvent(event)"
                                             draggable="true"
                                             @dragstart="dragStart($event, event)"
                                             @dragend="dragEnd">
                                            <div class="p-1.5 bg-white dark:bg-zinc-800" :style="{ backgroundColor: event.color + '20', borderLeftColor: event.color }">
                                                <div class="text-xs font-medium truncate" x-text="event.title"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        
        <!-- Agenda View -->
        <template x-if="view === 'agenda'">
            <div class="scheduler-agenda p-4 space-y-4">
                <template x-for="group in agendaGroups" :key="group.date">
                    <div class="scheduler-agenda-group">
                        <h3 class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-2 flex items-center gap-2">
                            <span x-text="group.label"></span>
                            <span class="text-xs text-zinc-400" x-text="group.count + ' events'"></span>
                        </h3>
                        <div class="space-y-2">
                            <template x-for="event in group.events" :key="event.id">
                                <div class="scheduler-agenda-event flex items-start gap-3 p-3 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm"
                                     :style="{ borderLeftColor: event.color, borderLeftWidth: '4px' }"
                                     @click="selectEvent(event)"
                                     @dblclick="editEvent(event)">
                                    <div class="flex-1 min-w-0">
                                        <div class="font-medium" x-text="event.title"></div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400" x-text="event.timeRange"></div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <x-gsmui:badge :variant="event.colorVariant" size="sm" x-text="event.resourceName" />
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <!-- Event Modal -->
    <template x-if="showEventModal">
        <x-gsmui:modal wire:model="showEventModal" :title="editingEvent ? 'Edit Event' : 'New Event'" size="lg">
            <form @submit.prevent="saveEvent">
                <x-gsmui:stack space="4">
                    <x-gsmui:input label="Title" wire:model="eventForm.title" required />
                    <x-gsmui:textarea label="Description" wire:model="eventForm.description" rows="3" />
                    
                    <x-gsmui:grid :cols="{ sm: 2 }" gap="4">
                        <x-gsmui:select label="Resource" wire:model="eventForm.resourceId" :options="resourceOptions" />
                        <x-gsmui:select label="Color" wire:model="eventForm.color" :options="colorOptions" />
                    </x-gsmui:grid>
                    
                    <x-gsmui:grid :cols="{ sm: 2 }" gap="4">
                        <x-gsmui:input type="datetime-local" label="Start" wire:model="eventForm.start" required />
                        <x-gsmui:input type="datetime-local" label="End" wire:model="eventForm.end" required />
                    </x-gsmui:grid>
                    
                    <x-gsmui:checkbox label="All day" wire:model="eventForm.allDay" />
                    <x-gsmui:checkbox label="Recurring" wire:model="eventForm.recurring" />
                    
                    <template x-if="eventForm.recurring">
                        <x-gsmui:select label="Frequency" wire:model="eventForm.frequency" :options="[
                            { value: 'daily', label: 'Daily' },
                            { value: 'weekly', label: 'Weekly' },
                            { value: 'monthly', label: 'Monthly' },
                            { value: 'yearly', label: 'Yearly' }
                        ]" />
                        <x-gsmui:input type="date" label="Until" wire:model="eventForm.until" />
                    </template>
                </x-gsmui:stack>
                
                <x-slot name="footer">
                    <x-gsmui:flex justify="end" gap="3">
                        <x-gsmui:button variant="ghost" @click="closeEventModal">Cancel</x-gsmui:button>
                        <x-gsmui:button type="submit" variant="primary">Save</x-gsmui:button>
                    </x-gsmui:flex>
                </x-slot>
            </form>
        </x-gsmui:modal>
    </template>
</div>

<style>
.gsmui-scheduler {
    @apply flex flex-col bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden;
}

.scheduler-grid {
    @apply flex-1 overflow-auto;
    display: grid;
}

.scheduler-time-column {
    @apply flex flex-col;
    width: 60px;
    flex-shrink: 0;
}

.scheduler-time-header {
    @apply flex-shrink-0;
}

.scheduler-time-slot {
    @apply relative flex-shrink-0 border-b border-zinc-100 dark:border-zinc-800;
    position: relative;
}

.scheduler-time-slot.scheduler-business-hours {
    @apply bg-primary/5;
}

.scheduler-time-label {
    @apply absolute right-1 top-0 text-[10px] text-zinc-400 dark:text-zinc-500 -translate-y-1/2;
}

.scheduler-resource-column {
    @apply flex flex-col flex-1 min-w-0;
}

.scheduler-resource-header {
    @apply flex-shrink-0;
}

.scheduler-resource-body {
    @apply flex-1 relative overflow-hidden;
    position: relative;
}

.scheduler-event {
    @apply left-1 right-1;
    position: absolute;
    z-index: 5;
}

.scheduler-event-selected {
    @apply shadow-lg ring-2 ring-primary/50;
}

.scheduler-event-dragging {
    @apply opacity-80 rotate-1 scale-105;
    z-index: 50;
}

.scheduler-event-resize-handle {
    @apply left-0 right-0;
}

.scheduler-now-indicator {
    @apply left-0 right-0;
    z-index: 10;
}

.scheduler-now-indicator-dot {
    @apply w-3 h-3;
}

.scheduler-drop-zone {
    @apply animate-pulse;
}

.scheduler-month-grid {
    @apply overflow-auto;
}

.scheduler-month-day {
    @apply relative flex flex-col;
}

.scheduler-month-day-header {
    @apply text-right pr-1;
}

.scheduler-month-day-today {
    @apply bg-primary/5;
}

.scheduler-month-day-other {
    @apply text-zinc-400 dark:text-zinc-500;
}

.scheduler-month-day-events {
    @apply flex-1 overflow-hidden;
}

.scheduler-timeline {
    @apply flex-1 overflow-auto;
}

.scheduler-timeline-resources {
    @apply flex-shrink-0 overflow-y-auto;
}

.scheduler-timeline-times {
    @apply flex overflow-x-auto;
}

.scheduler-timeline-time-slot {
    @apply flex-shrink-0 text-center;
    width: 100px;
}

.scheduler-timeline-body {
    @apply relative;
}

.scheduler-timeline-resource-row {
    @apply flex items-start gap-1 px-2;
}

.scheduler-agenda {
    @apply flex-1 overflow-auto;
}

.scheduler-agenda-group {
    @apply border-b border-zinc-200 dark:border-zinc-700 pb-4;
}

.scheduler-agenda-event {
    @apply transition-shadow hover:shadow-md;
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiScheduler', (config) => ({
        view: config.view,
        events: config.events,
        resources: config.resources,
        businessHours: config.businessHours,
        slotDuration: config.slotDuration,
        snapDuration: config.snapDuration,
        timezone: config.timezone,
        nowIndicator: config.nowIndicator,
        
        currentDate: new Date(),
        selectedEventId: null,
        draggingEventId: null,
        dragOverResource: null,
        resizingEventId: null,
        resizeStartY: 0,
        resizeStartHeight: 0,
        showEventModal: false,
        editingEvent: null,
        
        eventForm: {
            title: '',
            description: '',
            resourceId: '',
            color: '#3b82f6',
            start: '',
            end: '',
            allDay: false,
            recurring: false,
            frequency: 'weekly',
            until: '',
        },
        
        colorOptions: [
            { value: '#3b82f6', label: 'Blue' },
            { value: '#22c55e', label: 'Green' },
            { value: '#f59e0b', label: 'Amber' },
            { value: '#ef4444', label: 'Red' },
            { value: '#8b5cf6', label: 'Violet' },
            { value: '#ec4899', label: 'Pink' },
            { value: '#06b6d4', label: 'Cyan' },
            { value: '#84cc16', label: 'Lime' },
        ],
        
        init() {
            this.generateTimeSlots();
            this.$watch('currentDate', () => this.generateTimeSlots());
            this.$watch('view', () => this.generateTimeSlots());
        },
        
        get resourceOptions() {
            return this.resources.map(r => ({ value: r.id, label: r.name }));
        },
        
        get timeSlots() {
            const slots = [];
            const start = 0;
            const end = 24 * 60;
            for (let m = start; m < end; m += this.slotDuration) {
                slots.push(m);
            }
            return slots;
        },
        
        get slotHeight() {
            return 40; // px per 30 min
        },
        
        get timeColumnWidth() {
            return '60px';
        },
        
        getResources() {
            if (this.resources.length > 0) return this.resources;
            return [{ id: 'default', name: 'Calendar' }];
        },
        
        getEventsForResource(resource) {
            return this.events.filter(e => e.resourceId === resource.id || (!e.resourceId && resource.id === 'default'));
        },
        
        getEventsForDay(day) {
            const dayStart = new Date(day.date);
            dayStart.setHours(0,0,0,0);
            const dayEnd = new Date(day.date);
            dayEnd.setHours(23,59,59,999);
            
            return this.events.filter(e => {
                const start = new Date(e.start);
                const end = new Date(e.end);
                return start <= dayEnd && end >= dayStart;
            });
        },
        
        formatTime(minutes) {
            const h = Math.floor(minutes / 60);
            const m = minutes % 60;
            return `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}`;
        },
        
        formatEventTime(event) {
            const start = new Date(event.start);
            const end = new Date(event.end);
            return `${start.getHours().toString().padStart(2,'0')}:${start.getMinutes().toString().padStart(2,'0')} - ${end.getHours().toString().padStart(2,'0')}:${end.getMinutes().toString().padStart(2,'0')}`;
        },
        
        isBusinessHour(minutes) {
            const [bhStart, bhEnd] = this.businessHours;
            const startMin = this.timeToMinutes(bhStart);
            const endMin = this.timeToMinutes(bhEnd);
            return minutes >= startMin && minutes < endMin;
        },
        
        timeToMinutes(time) {
            const [h, m] = time.split(':').map(Number);
            return h * 60 + m;
        },
        
        getEventStyle(event) {
            const start = new Date(event.start);
            const end = new Date(event.end);
            const startMin = start.getHours() * 60 + start.getMinutes();
            const endMin = end.getHours() * 60 + end.getMinutes();
            const top = (startMin / this.slotDuration) * this.slotHeight;
            const height = ((endMin - startMin) / this.slotDuration) * this.slotHeight;
            
            return `top: ${top}px; height: ${Math.max(height, 20)}px; background-color: ${event.color}20; border-left-color: ${event.color};`;
        },
        
        getTimelineEventStyle(event) {
            const start = new Date(event.start);
            const end = new Date(event.end);
            const dayStart = new Date(this.currentDate);
            dayStart.setHours(0,0,0,0);
            const startMin = (start - dayStart) / 60000;
            const endMin = (end - dayStart) / 60000;
            const dayMinutes = 24 * 60;
            const left = (startMin / dayMinutes) * 100;
            const width = ((endMin - startMin) / dayMinutes) * 100;
            
            return `left: ${left}%; width: ${width}%; background-color: ${event.color}20; border-left-color: ${event.color};`;
        },
        
        isCurrentTimeVisible() {
            const now = new Date();
            return now.toDateString() === this.currentDate.toDateString();
        },
        
        get nowIndicatorTop() {
            const now = new Date();
            const minutes = now.getHours() * 60 + now.getMinutes();
            return (minutes / this.slotDuration) * this.slotHeight;
        },
        
        get monthDays() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDay = firstDay.getDay();
            const daysInMonth = lastDay.getDate();
            const days = [];
            
            // Previous month days
            const prevMonth = new Date(year, month, 0);
            for (let i = startDay - 1; i >= 0; i--) {
                const date = new Date(year, month, -i);
                days.push({ date, day: date.getDate(), isOtherMonth: true, isToday: false });
            }
            
            // Current month
            const today = new Date();
            for (let d = 1; d <= daysInMonth; d++) {
                const date = new Date(year, month, d);
                days.push({ date, day: d, isOtherMonth: false, isToday: date.toDateString() === today.toDateString() });
            }
            
            // Next month days
            const remaining = 42 - days.length;
            for (let d = 1; d <= remaining; d++) {
                const date = new Date(year, month + 1, d);
                days.push({ date, day: d, isOtherMonth: true, isToday: false });
            }
            
            return days;
        },
        
        get timelineSlots() {
            const slots = [];
            for (let h = 0; h < 24; h++) {
                slots.push(`${h.toString().padStart(2,'0')}:00`);
            }
            return slots;
        },
        
        get agendaGroups() {
            const groups = {};
            const sortedEvents = [...this.events].sort((a,b) => new Date(a.start) - new Date(b.start));
            
            sortedEvents.forEach(event => {
                const date = new Date(event.start).toDateString();
                if (!groups[date]) {
                    groups[date] = { date, label: this.formatDateLabel(date), events: [], count: 0 };
                }
                const resource = this.resources.find(r => r.id === event.resourceId);
                groups[date].events.push({
                    ...event,
                    timeRange: this.formatEventTime(event),
                    resourceName: resource?.name || 'Default',
                    colorVariant: this.getColorVariant(event.color)
                });
                groups[date].count++;
            });
            
            return Object.values(groups);
        },
        
        formatDateLabel(dateStr) {
            const date = new Date(dateStr);
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            if (date.toDateString() === today.toDateString()) return 'Today';
            if (date.toDateString() === tomorrow.toDateString()) return 'Tomorrow';
            return date.toLocaleDateString(undefined, { weekday: 'long', month: 'short', day: 'numeric' });
        },
        
        getColorVariant(color) {
            const variants = { '#3b82f6': 'primary', '#22c55e': 'success', '#f59e0b': 'warning', '#ef4444': 'danger' };
            return variants[color] || 'primary';
        },
        
        prev() {
            switch(this.view) {
                case 'day': this.currentDate.setDate(this.currentDate.getDate() - 1); break;
                case 'week': this.currentDate.setDate(this.currentDate.getDate() - 7); break;
                case 'month': this.currentDate.setMonth(this.currentDate.getMonth() - 1); break;
            }
        },
        
        next() {
            switch(this.view) {
                case 'day': this.currentDate.setDate(this.currentDate.getDate() + 1); break;
                case 'week': this.currentDate.setDate(this.currentDate.getDate() + 7); break;
                case 'month': this.currentDate.setMonth(this.currentDate.getMonth() + 1); break;
            }
        },
        
        today() {
            this.currentDate = new Date();
        },
        
        setView(v) {
            this.view = v;
        },
        
        get title() {
            switch(this.view) {
                case 'day': return this.currentDate.toLocaleDateString(undefined, { weekday: 'long', month: 'long', day: 'numeric' });
                case 'week': {
                    const start = new Date(this.currentDate);
                    start.setDate(start.getDate() - start.getDay());
                    const end = new Date(start);
                    end.setDate(end.getDate() + 6);
                    return `${start.toLocaleDateString(undefined, { month: 'short', day: 'numeric' })} - ${end.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })}`;
                }
                case 'month': return this.currentDate.toLocaleDateString(undefined, { month: 'long', year: 'numeric' });
                default: return '';
            }
        },
        
        createEventAt(event, resource) {
            if (this.draggingEventId) return;
            const rect = event.currentTarget.getBoundingClientRect();
            const y = event.clientY - rect.top;
            const minutes = Math.round(y / this.slotHeight) * this.slotDuration;
            
            const date = new Date(this.currentDate);
            date.setHours(Math.floor(minutes / 60), minutes % 60, 0, 0);
            
            this.openEventModal({
                start: date.toISOString(),
                end: new Date(date.getTime() + 60*60*1000).toISOString(),
                resourceId: resource.id
            });
        },
        
        createEventAtDay(day) {
            this.openEventModal({
                start: day.date.toISOString(),
                end: new Date(day.date.getTime() + 60*60*1000).toISOString(),
                allDay: true
            });
        },
        
        dropEvent(event, resource) {
            this.dragOverResource = null;
            if (!this.draggingEventId) return;
            
            const draggedEvent = this.events.find(e => e.id === this.draggingEventId);
            if (!draggedEvent) return;
            
            const rect = event.currentTarget.getBoundingClientRect();
            const y = event.clientY - rect.top;
            const minutes = Math.round(y / this.slotHeight) * this.slotDuration;
            
            const date = new Date(this.currentDate);
            date.setHours(Math.floor(minutes / 60), minutes % 60, 0, 0);
            
            const duration = new Date(draggedEvent.end) - new Date(draggedEvent.start);
            draggedEvent.start = date.toISOString();
            draggedEvent.end = new Date(date.getTime() + duration).toISOString();
            draggedEvent.resourceId = resource.id;
            
            this.$dispatch('scheduler:event-moved', { event: draggedEvent });
        },
        
        dropEventAtDay(event, day) {
            if (!this.draggingEventId) return;
            const draggedEvent = this.events.find(e => e.id === this.draggingEventId);
            if (!draggedEvent) return;
            
            const duration = new Date(draggedEvent.end) - new Date(draggedEvent.start);
            draggedEvent.start = day.date.toISOString();
            draggedEvent.end = new Date(day.date.getTime() + duration).toISOString();
            
            this.$dispatch('scheduler:event-moved', { event: draggedEvent });
        },
        
        dragStart(event, draggedEvent) {
            this.draggingEventId = draggedEvent.id;
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', draggedEvent.id);
        },
        
        dragEnd() {
            this.draggingEventId = null;
            this.dragOverResource = null;
        },
        
        selectEvent(event) {
            this.selectedEventId = event.id;
            this.$dispatch('scheduler:event-selected', { event });
        },
        
        editEvent(event) {
            this.openEventModal(event);
        },
        
        openEventModal(event) {
            this.editingEvent = event;
            this.eventForm = {
                title: event.title || '',
                description: event.description || '',
                resourceId: event.resourceId || '',
                color: event.color || '#3b82f6',
                start: event.start ? new Date(event.start).toISOString().slice(0,16) : '',
                end: event.end ? new Date(event.end).toISOString().slice(0,16) : '',
                allDay: event.allDay || false,
                recurring: event.recurring || false,
                frequency: event.frequency || 'weekly',
                until: event.until || '',
            };
            this.showEventModal = true;
        },
        
        closeEventModal() {
            this.showEventModal = false;
            this.editingEvent = null;
            this.resetForm();
        },
        
        resetForm() {
            this.eventForm = {
                title: '', description: '', resourceId: '', color: '#3b82f6',
                start: '', end: '', allDay: false, recurring: false,
                frequency: 'weekly', until: ''
            };
        },
        
        saveEvent() {
            const eventData = { ...this.eventForm };
            eventData.start = new Date(eventData.start).toISOString();
            eventData.end = new Date(eventData.end).toISOString();
            
            if (this.editingEvent) {
                Object.assign(this.editingEvent, eventData);
                this.$dispatch('scheduler:event-updated', { event: this.editingEvent });
            } else {
                eventData.id = 'evt-' + Date.now();
                this.events.push(eventData);
                this.$dispatch('scheduler:event-created', { event: eventData });
            }
            
            this.closeEventModal();
        },
        
        startResize(event, resizingEvent) {
            event.preventDefault();
            event.stopPropagation();
            this.resizingEventId = resizingEvent.id;
            this.resizeStartY = event.clientY;
            this.resizeStartHeight = parseFloat(resizingEvent.style.height) || 20;
            
            document.addEventListener('mousemove', this.handleResize);
            document.addEventListener('mouseup', this.stopResize);
        },
        
        handleResize(event) {
            if (!this.resizingEventId) return;
            const deltaY = event.clientY - this.resizeStartY;
            const newHeight = Math.max(20, this.resizeStartHeight + deltaY);
            const eventEl = document.querySelector(`[data-event-id="${this.resizingEventId}"]`);
            if (eventEl) eventEl.style.height = newHeight + 'px';
        },
        
        stopResize() {
            document.removeEventListener('mousemove', this.handleResize);
            document.removeEventListener('mouseup', this.stopResize);
            this.resizingEventId = null;
        },
    }));
});
</script>