@props([
    'steps' => [],
    'showProgress' => true,
    'dismissible' => true,
    'class' => '',
])

<?php
$id = 'onboarding-' . uniqid();
$steps = $steps ?: [
    ['title' => 'Welcome!', 'description' => 'Let\'s get you started with your new workspace.', 'icon' => 'wave', 'target' => ''],
    ['title' => 'Create a project', 'description' => 'Click the "New Project" button to create your first project.', 'icon' => 'folder-plus', 'target' => ''],
    ['title' => 'Invite your team', 'description' => 'Add team members to collaborate in real time.', 'icon' => 'users', 'target' => ''],
    ['title' => 'Explore settings', 'description' => 'Customize your workspace in the Settings panel.', 'icon' => 'cog', 'target' => ''],
    ['title' => 'You\'re all set!', 'description' => 'Start building something amazing.', 'icon' => 'check-badge', 'target' => ''],
];
?>

<div 
    class="gsmui-onboarding {{ $class }}"
    x-data="gsmuiOnboarding({
        steps: @js($steps),
        showProgress: @js($showProgress),
        dismissible: @js($dismissible),
    })"
    x-show="!dismissed"
    id="{{ $id }}"
>
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="dismiss">
        <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center">
                        <template x-if="currentStep.icon === 'wave'">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </template>
                        <template x-if="currentStep.icon === 'folder-plus'">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-5 5h10a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/></svg>
                        </template>
                        <template x-if="currentStep.icon === 'users'">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                        </template>
                        <template x-if="currentStep.icon === 'cog'">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </template>
                        <template x-if="currentStep.icon === 'check-badge'">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </template>
                    </div>
                    <template x-if="dismissible">
                        <button @click="dismiss" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </template>
                </div>

                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2" x-text="currentStep.title"></h2>
                <p class="text-zinc-600 dark:text-zinc-400" x-text="currentStep.description"></p>

                <template x-if="showProgress">
                    <div class="flex items-center gap-2 mt-8">
                        <template x-for="(step, i) in steps" :key="i">
                            <div class="flex-1 h-1.5 rounded-full transition-all"
                                :class="i <= currentIndex ? 'bg-primary' : 'bg-zinc-200 dark:bg-zinc-700'">
                            </div>
                        </template>
                    </div>
                </template>

                <div class="flex items-center justify-between mt-6">
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                        Step <span x-text="currentIndex + 1"></span> of <span x-text="steps.length"></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button @click="prev" x-show="currentIndex > 0" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Back</button>
                        <button @click="next" class="px-6 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90 transition-colors"
                            x-text="currentIndex === steps.length - 1 ? 'Get Started' : 'Continue'">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiOnboarding', (config) => ({
        steps: config.steps,
        showProgress: config.showProgress,
        dismissible: config.dismissible,
        dismissed: false,
        currentIndex: 0,

        get currentStep() {
            return this.steps[this.currentIndex];
        },

        next() {
            if (this.currentIndex < this.steps.length - 1) {
                this.currentIndex++;
            } else {
                this.dismiss();
            }
        },

        prev() {
            if (this.currentIndex > 0) this.currentIndex--;
        },

        dismiss() {
            this.dismissed = true;
            this.$dispatch('onboarding:dismissed');
        },
    }));
});
</script>
