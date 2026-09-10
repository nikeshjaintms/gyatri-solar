@php
    $categories = \App\Helpers\PermissionHelper::getPermissionGroups();
    $assignedPermissions = old('permissions', isset($user) ? $user->permissions->pluck('name')->toArray() : []);
@endphp

<div class="permission-matrix-section mt-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 p-3 rounded-3" style="background: linear-gradient(135deg, rgba(245, 130, 32, 0.08) 0%, rgba(245, 130, 32, 0.02) 100%); border: 1px solid rgba(245, 130, 32, 0.2);">
        <div>
            <h6 class="mb-1 text-dark fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-shield-lock-fill text-warning" style="color: #f58220 !important;"></i>
                Module &amp; Action Permissions
            </h6>
            <small class="text-muted">Select the specific modules and operations this user / employee is authorized to access.</small>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary px-3" id="btnSelectAllPerms" style="font-size: 0.82rem; border-radius: 6px;">
                <i class="bi bi-check-all me-1"></i> Select All
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger px-3" id="btnClearAllPerms" style="font-size: 0.82rem; border-radius: 6px;">
                <i class="bi bi-x me-1"></i> Clear All
            </button>
        </div>
    </div>

    <div class="row g-3">
        @foreach($categories as $categoryName => $modules)
            <div class="col-12">
                <div class="text-uppercase fw-bold text-muted small letter-spacing-1 mt-2 mb-2 pb-1 border-bottom" style="letter-spacing: 0.06em; font-size: 0.78rem;">
                    {{ $categoryName }}
                </div>
            </div>

            @foreach($modules as $moduleName => $moduleData)
                @php
                    $modulePermKeys = array_keys($moduleData['permissions']);
                    $allChecked = count(array_intersect($modulePermKeys, $assignedPermissions)) === count($modulePermKeys);
                @endphp
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card h-100 border shadow-sm rounded-3 permission-module-card" style="transition: all 0.2s ease; border-color: #e5e7eb !important;">
                        <div class="card-header bg-white d-flex align-items-center justify-content-between py-2 px-3 border-bottom" style="border-color: #f3f4f6 !important;">
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-2" style="width: 28px; height: 28px; background: rgba(245, 130, 32, 0.12); color: #f58220;">
                                    <i class="bi {{ $moduleData['icon'] ?? 'bi-app' }} fs-6"></i>
                                </span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $moduleName }}</span>
                            </div>
                            <div class="form-check m-0">
                                <input class="form-check-input module-select-all" type="checkbox" id="mod_{{ \Illuminate\Support\Str::slug($moduleName) }}" title="Toggle all in this module" {{ $allChecked ? 'checked' : '' }} style="cursor: pointer; accent-color: #f58220;">
                            </div>
                        </div>
                        <div class="card-body p-3 bg-light-subtle">
                            <div class="d-flex flex-column gap-2">
                                @foreach($moduleData['permissions'] as $permKey => $permLabel)
                                    @php
                                        $isChecked = in_array($permKey, $assignedPermissions);
                                    @endphp
                                    <label class="d-flex align-items-center justify-content-between p-2 rounded-2 bg-white border border-light-subtle m-0 perm-checkbox-label" style="cursor: pointer; transition: background 0.15s ease;" for="perm_{{ $permKey }}">
                                        <span class="small fw-medium text-secondary" style="font-size: 0.82rem;">{{ $permLabel }}</span>
                                        <input class="form-check-input perm-checkbox m-0" type="checkbox" name="permissions[]" value="{{ $permKey }}" id="perm_{{ $permKey }}" {{ $isChecked ? 'checked' : '' }} style="cursor: pointer; accent-color: #f58220;">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Master Select All
    const btnSelectAll = document.getElementById('btnSelectAllPerms');
    const btnClearAll = document.getElementById('btnClearAllPerms');
    const allPermCheckboxes = document.querySelectorAll('.perm-checkbox');
    const allModuleCheckboxes = document.querySelectorAll('.module-select-all');

    if (btnSelectAll) {
        btnSelectAll.addEventListener('click', function () {
            allPermCheckboxes.forEach(cb => cb.checked = true);
            allModuleCheckboxes.forEach(cb => cb.checked = true);
        });
    }

    if (btnClearAll) {
        btnClearAll.addEventListener('click', function () {
            allPermCheckboxes.forEach(cb => cb.checked = false);
            allModuleCheckboxes.forEach(cb => cb.checked = false);
        });
    }

    // Module Select All
    document.querySelectorAll('.permission-module-card').forEach(card => {
        const modToggle = card.querySelector('.module-select-all');
        const perms = card.querySelectorAll('.perm-checkbox');

        if (modToggle) {
            modToggle.addEventListener('change', function () {
                perms.forEach(p => p.checked = modToggle.checked);
            });
        }

        perms.forEach(p => {
            p.addEventListener('change', function () {
                const total = perms.length;
                const checked = card.querySelectorAll('.perm-checkbox:checked').length;
                if (modToggle) {
                    modToggle.checked = (total === checked);
                }
            });
        });
    });

    // Auto-select permissions based on role if creating new user
    const roleSelect = document.querySelector('select[name="role"]');
    if (roleSelect) {
        roleSelect.addEventListener('change', function () {
            const role = this.value;
            if (role === 'Super Admin' || role === 'Admin') {
                allPermCheckboxes.forEach(cb => cb.checked = true);
                allModuleCheckboxes.forEach(cb => cb.checked = true);
            }
        });
    }
});
</script>
