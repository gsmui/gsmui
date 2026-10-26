@props([
    'steps' => [],
    'currentStep' => 1,
    'showStepNumbers' => true,
    'allowSkip' => false,
    'class' => '',
])

<?php
$id = 'form-wizard-' . uniqid();
$steps = $steps ?: [
    ['title' => 'Account', 'description' => 'Create your account', 'icon' => 'user', 'fields' => ['name', 'email', 'password']],
    ['title' => 'Profile', 'description' => 'Tell us about yourself', 'icon' => 'identification', 'fields' => ['bio', 'avatar', 'location']],
    ['title' => 'Preferences', 'description' => 'Set your preferences', 'icon' => 'cog', 'fields' => ['theme', 'notifications', 'language']],
    ['title' => 'Review', 'description' => 'Review your information', 'icon' => 'check', 'fields' => []],
];
?>

<div 
    class="gsmui-form-wizard {{ $class }}"
    x-data="gsmuiFormWizard({
        steps: @js($steps),
        currentStep: @js($currentStep),
        allowSkip: @js($allowSkip),
    })"
    id="{{ $id }}"
>
    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
        <!-- Steps Progress -->
        <div class="p-6 pb-0">
            <div class="flex items-center justify-between">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="flex items-center flex-1">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition-all"
                                :class="{
                                    'bg-primary text-white shadow-lg shadow-primary/30': i + 1 === currentStep,
                                    'bg-emerald-500 text-white': i + 1 < currentStep,
                                    'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400': i + 1 > currentStep
                                }">
                                <template x-if="i + 1 < currentStep">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </template>
                                <template x-if="i + 1 >= currentStep">
                                    <span x-text="showStepNumbers ? i + 1 : ''"></span>
                                </template>
                            </div>
                            <div class="mt-2 text-center">
                                <div class="text-sm font-medium" :class="i + 1 === currentStep ? 'text-primary' : 'text-zinc-600 dark:text-zinc-400'" x-text="step.title"></div>
                                <div class="text-xs text-zinc-400 hidden sm:block" x-text="step.description"></div>
                            </div>
                        </div>
                        <template x-if="i < steps.length - 1">
                            <div class="flex-1 h-0.5 mx-4 transition-colors"
                                :class="i + 1 < currentStep ? 'bg-emerald-500' : 'bg-zinc-200 dark:bg-zinc-700'">
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <template x-for="(step, i) in steps" :key="i">
                <div x-show="i + 1 === currentStep" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <template x-if="i + 1 === currentStep">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white" x-text="'Step ' + (i + 1) + ': ' + step.title"></h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1" x-text="step.description"></p>
                            </div>
                            <div class="space-y-4">
                                <template x-for="field in step.fields" :key="field">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1 capitalize" x-text="field"></label>
                                        <template x-if="field === 'password'">
                                            <input type="password" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary" :placeholder="'Enter your ' + field" />
                                        </template>
                                        <template x-if="field === 'notifications'">
                                            <select class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><option>All notifications</option><option>Important only</option><option>None</option></select>
                                        </template>
                                        <template x-if="field === 'language'">
                                            <select class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><option>English</option><option>Spanish</option><option>French</option></select>
                                        </template>
                                        <template x-if="field === 'theme'">
                                            <div class="flex gap-3">
                                                <label class="flex items-center gap-2 p-3 border border-zinc-200 dark:border-zinc-700 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700"><input type="radio" name="theme" class="w-4 h-4 text-primary" /><span class="text-sm">Light</span></label>
                                                <label class="flex items-center gap-2 p-3 border border-zinc-200 dark:border-zinc-700 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700"><input type="radio" name="theme" class="w-4 h-4 text-primary" /><span class="text-sm">Dark</span></label>
                                                <label class="flex items-center gap-2 p-3 border border-zinc-200 dark:border-zinc-700 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700"><input type="radio" name="theme" class="w-4 h-4 text-primary" /><span class="text-sm">System</span></label>
                                            </div>
                                        </template>
                                        <template x-if="!['password', 'notifications', 'language', 'theme'].includes(field)">
                                            <input type="text" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary" :placeholder="'Enter your ' + field" />
                                        </template>
                                    </div>
                                </template>
                                <template x-if="step.fields.length === 0">
                                    <div class="p-6 bg-zinc-50 dark:bg-zinc-900 rounded-lg text-center">
                                        <svg class="w-12 h-12 mx-auto text-emerald-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <h4 class="font-medium text-zinc-900 dark:text-white mb-1">Ready to finish!</h4>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Review your information and click Complete.</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="p-6 pt-0 flex items-center justify-between">
            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                Step <span x-text="currentStep"></span> of <span x-text="steps.length"></span>
            </div>
            <div class="flex items-center gap-3">
                <button @click="prevStep" x-show="currentStep > 1" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Back</button>
                <template x-if="allowSkip && currentStep < steps.length">
                    <button @click="nextStep" class="px-4 py-2 text-sm text-primary hover:underline">Skip</button>
                </template>
                <button @click="nextStep" class="px-6 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90 transition-colors"
                    x-text="currentStep === steps.length ? 'Complete' : 'Continue'">
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiFormWizard', (config) => ({
        steps: config.steps,
        currentStep: config.currentStep,
        allowSkip: config.allowSkip,
        showStepNumbers: @js($showStepNumbers),

        nextStep() {
            if (this.currentStep < this.steps.length) {
                this.currentStep++;
            } else {
                this.$dispatch('wizard:completed');
            }
        },

        prevStep() {
            if (this.currentStep > 1) this.currentStep--;
        },
    }));
});
</script>

<style>
.gsmui-form-wizard [x-cloak] { display: none !important; }
</style>
