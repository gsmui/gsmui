@props([
    'roles' => [],
    'permissions' => [],
    'users' => [],
    'class' => '',
])

<?php
$id = 'roles-permissions-' . uniqid();
$roles = $roles ?: [
    ['id' => 1, 'name' => 'Admin', 'description' => 'Full system access', 'users' => 3, 'permissions' => ['all']],
    ['id' => 2, 'name' => 'Editor', 'description' => 'Content management access', 'users' => 12, 'permissions' => ['content.read', 'content.write', 'media.manage']],
    ['id' => 3, 'name' => 'Viewer', 'description' => 'Read-only access', 'users' => 45, 'permissions' => ['content.read']],
];
$permissions = $permissions ?: [
    ['group' => 'Content', 'perms' => ['content.read', 'content.write', 'content.delete', 'content.publish']],
    ['group' => 'Users', 'perms' => ['users.read', 'users.write', 'users.delete', 'users.manage-roles']],
    ['group' => 'Settings', 'perms' => ['settings.read', 'settings.write']],
    ['group' => 'Media', 'perms' => ['media.upload', 'media.delete']],
    ['group' => 'System', 'perms' => ['system.backup', 'system.logs', 'system.maintenance']],
];
?>

<div 
    class="gsmui-roles-permissions {{ $class }}"
    x-data="gsmuiRolesPermissions({
        roles: @js($roles),
        permissions: @js($permissions),
    })"
    id="{{ $id }}"
>
    <div x-data="{ tab: 'roles' }" class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Roles & Permissions</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage access control for your application.</p></div>
            <button x-show="tab === 'roles'" @click="showRoleModal = true" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ New Role</button>
        </div>

        <div class="flex gap-2">
            <button @click="tab = 'roles'" class="px-4 py-2 text-sm rounded-lg font-medium transition-colors" :class="tab === 'roles' ? 'bg-primary text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200'">Roles</button>
            <button @click="tab = 'permissions'" class="px-4 py-2 text-sm rounded-lg font-medium transition-colors" :class="tab === 'permissions' ? 'bg-primary text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200'">Permissions Matrix</button>
        </div>

        <!-- Roles Tab -->
        <template x-if="tab === 'roles'">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <template x-for="role in roles" :key="role.id">
                    <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div><h3 class="font-semibold text-zinc-900 dark:text-white" x-text="role.name"></h3><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5" x-text="role.description"></p></div>
                            <div class="flex items-center gap-1">
                                <button @click="editRole(role)" class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-500 hover:text-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <button @click="deleteRole(role)" class="p-1.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 text-zinc-500 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400 mb-3">
                            <span x-text="role.users + ' users'"></span>
                            <span x-text="'· ' + role.permissions.length + ' permissions'"></span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <template x-for="perm in role.permissions.slice(0, 4)" :key="perm">
                                <span class="text-xs px-2 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded text-zinc-600 dark:text-zinc-400" x-text="perm === 'all' ? 'Full Access' : perm.split('.').pop()"></span>
                            </template>
                            <template x-if="role.permissions.length > 4">
                                <span class="text-xs px-2 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded text-zinc-400">+@{{role.permissions.length - 4}}</span>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <!-- Permissions Matrix Tab -->
        <template x-if="tab === 'permissions'">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr>
                                <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Permission</th>
                                <template x-for="role in roles" :key="role.id">
                                    <th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider" x-text="role.name"></th>
                                </template>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <template x-for="group in permissions" :key="group.group">
                                <template x-for="(perm, pi) in group.perms" :key="perm">
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" :class="{ 'bg-zinc-50/50 dark:bg-zinc-800/30': pi === 0 }">
                                        <td class="px-4 py-2.5 text-sm">
                                            <template x-if="pi === 0">
                                                <div class="font-medium text-zinc-900 dark:text-white text-xs uppercase tracking-wider text-zinc-500" x-text="group.group"></div>
                                            </template>
                                            <div class="text-sm text-zinc-700 dark:text-zinc-300 font-mono text-xs" x-text="perm"></div>
                                        </td>
                                        <template x-for="role in roles" :key="role.id">
                                            <td class="px-4 py-2.5 text-center">
                                                <input type="checkbox" 
                                                    :checked="role.permissions.includes('all') || role.permissions.includes(perm)"
                                                    @change="togglePermission(role, perm)"
                                                    class="w-4 h-4 text-primary rounded border-zinc-300 focus:ring-primary"
                                                    :disabled="role.permissions.includes('all')">
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>

        <!-- Role Modal -->
        <template x-if="showRoleModal">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="showRoleModal = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4" x-text="editingRole ? 'Edit Role' : 'New Role'"></h3>
                    <div class="space-y-4">
                        <div><label class="block text-sm font-medium mb-1">Name</label><input type="text" x-model="form.name" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                        <div><label class="block text-sm font-medium mb-1">Description</label><textarea x-model="form.description" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" rows="2"></textarea></div>
                        <div><label class="block text-sm font-medium mb-2">Permissions</label>
                            <div class="space-y-3 max-h-60 overflow-y-auto">
                                <template x-for="group in permissions" :key="group.group">
                                    <div>
                                        <div class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-1" x-text="group.group"></div>
                                        <template x-for="perm in group.perms" :key="perm">
                                            <label class="flex items-center gap-2 py-0.5 text-sm"><input type="checkbox" :value="perm" x-model="form.permissions" class="w-4 h-4 text-primary rounded border-zinc-300" /><span class="font-mono text-xs" x-text="perm"></span></label>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showRoleModal = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="saveRole" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Save</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiRolesPermissions', (config) => ({
        roles: config.roles, permissions: config.permissions,
        showRoleModal: false, editingRole: null,
        form: { name: '', description: '', permissions: [] },

        editRole(role) { this.editingRole = role; this.form = { name: role.name, description: role.description, permissions: [...role.permissions] }; this.showRoleModal = true; },
        deleteRole(role) { this.roles = this.roles.filter(r => r.id !== role.id); },
        togglePermission(role, perm) { const idx = role.permissions.indexOf(perm); if (idx >= 0) role.permissions.splice(idx, 1); else role.permissions.push(perm); },
        saveRole() {
            if (this.editingRole) { Object.assign(this.editingRole, this.form); }
            else { this.roles.push({ id: Date.now(), ...this.form, users: 0 }); }
            this.showRoleModal = false; this.editingRole = null;
            this.form = { name: '', description: '', permissions: [] };
        },
    }));
});
</script>
