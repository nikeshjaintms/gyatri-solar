<div class="header-logo-right" style="display: flex; align-items: flex-end; justify-content: flex-end; height: 58px;">
    @if(!empty($quotation->partner_logo))
        <img src="{{ asset('storage/' . $quotation->partner_logo) }}" alt="Partner Logo" style="height: 58px; max-width: 220px; object-fit: contain;">
    @elseif(isset($panelMakeUpper) && str_contains($panelMakeUpper, 'TATA'))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 5px; line-height: 1;">
                <span style="font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 900; font-size: 1.35rem; color: #0266B3; letter-spacing: 0.8px;">TATA</span>
                <span style="font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 700; font-size: 1.35rem; color: #0266B3; letter-spacing: 0.5px;">POWER</span>
            </div>
            <div style="width: 100%; height: 2.5px; background: #F58220; margin: 4px 0 3px 0; border-radius: 1px;"></div>
            <div style="display: flex; align-items: center; justify-content: flex-end; line-height: 1;">
                <span style="font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 800; font-size: 1.08rem; color: #F58220; letter-spacing: 1.2px;">S</span>
                <svg width="16" height="16" viewBox="0 0 24 24" style="margin: 0 1px; vertical-align: middle;">
                    <path d="M12 1v3M12 20v3M1 12h3M20 12h3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12" stroke="#F58220" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="12" cy="12" r="5" fill="#0284c7"/>
                    <path d="M9 12c.5-.5 1.5-.5 2 0s1.5.5 2 0 1.5-.5 2 0" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" fill="none"/>
                </svg>
                <span style="font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 800; font-size: 1.08rem; color: #F58220; letter-spacing: 1.5px;">LAROOF</span>
            </div>
        </div>
    @elseif(isset($panelMakeUpper) && str_contains($panelMakeUpper, 'ADANI'))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="line-height: 1;"><span style="color: #003B73; font-weight: 900; font-size: 1.45rem;">adani</span> <span style="color: #43A047; font-weight: 800; font-size: 1.45rem;">Solar</span></div>
            <div style="font-size: 0.80rem; font-weight: 700; color: #003B73; letter-spacing: 1px; margin-top: 3px;">SHANTIGRAM</div>
        </div>
    @elseif(isset($panelMakeUpper) && str_contains($panelMakeUpper, 'WAAREE'))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="line-height: 1;"><span style="color: #D9381E; font-weight: 900; font-size: 1.5rem; letter-spacing: 1.5px;">WAAREE</span></div>
            <div style="font-size: 0.80rem; font-weight: 700; color: #0284c7; letter-spacing: 1px; margin-top: 3px;">One with the Sun</div>
        </div>
    @elseif(isset($panelMakeUpper) && str_contains($panelMakeUpper, 'RAYZON'))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="line-height: 1;"><span style="color: #0B2265; font-weight: 900; font-size: 1.4rem;">RAYZON</span> <span style="color: #F58220; font-weight: 800; font-size: 1.4rem;">SOLAR</span></div>
            <div style="font-size: 0.80rem; font-weight: 700; color: #0B2265; letter-spacing: 1px; margin-top: 3px;">ENERGY FOR LIFE</div>
        </div>
    @elseif(isset($panelMakeUpper) && (str_contains($panelMakeUpper, 'GOLDI') || str_contains($panelMakeUpper, 'GOLDY')))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="line-height: 1;"><span style="color: #F58220; font-weight: 900; font-size: 1.4rem;">GOLDI</span> <span style="color: #0B2265; font-weight: 800; font-size: 1.4rem;">SOLAR</span></div>
            <div style="font-size: 0.80rem; font-weight: 700; color: #F58220; letter-spacing: 1px; margin-top: 3px;">SOLAR EXCELLENCE</div>
        </div>
    @elseif(isset($panelMakeUpper) && str_contains($panelMakeUpper, 'VIKRAM'))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="line-height: 1;"><span style="color: #E65100; font-weight: 900; font-size: 1.4rem;">VIKRAM</span> <span style="color: #0B2265; font-weight: 800; font-size: 1.4rem;">SOLAR</span></div>
            <div style="font-size: 0.80rem; font-weight: 700; color: #E65100; letter-spacing: 1px; margin-top: 3px;">SOLAR POWER</div>
        </div>
    @elseif(isset($panelMakeUpper) && str_contains($panelMakeUpper, 'UTL'))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="line-height: 1;"><span style="color: #D32F2F; font-weight: 900; font-size: 1.4rem;">UTL</span> <span style="color: #0B2265; font-weight: 800; font-size: 1.4rem;">SOLAR</span></div>
            <div style="font-size: 0.80rem; font-weight: 700; color: #D32F2F; letter-spacing: 1px; margin-top: 3px;">SOLAR SOLUTIONS</div>
        </div>
    @elseif(isset($panelMakeUpper) && str_contains($panelMakeUpper, 'LUMINOUS'))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="line-height: 1;"><span style="color: #0284c7; font-weight: 900; font-size: 1.4rem;">LUMINOUS</span></div>
            <div style="font-size: 0.80rem; font-weight: 700; color: #F58220; letter-spacing: 1px; margin-top: 3px;">SOLAR ENERGY</div>
        </div>
    @elseif(!empty($panelMakeRaw))
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="line-height: 1;"><span style="color: #0B2265; font-weight: 900; font-size: 1.4rem;">{{ strtoupper($panelMakeRaw) }}</span></div>
            <div style="font-size: 0.80rem; font-weight: 700; color: #F58220; letter-spacing: 1px; margin-top: 3px;">SOLAR POWER</div>
        </div>
    @else
        <div style="text-align: right; display: inline-flex; flex-direction: column; align-items: flex-end; justify-content: flex-end;">
            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 5px; line-height: 1;">
                <span style="font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 900; font-size: 1.35rem; color: #0266B3; letter-spacing: 0.8px;">TATA</span>
                <span style="font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 700; font-size: 1.35rem; color: #0266B3; letter-spacing: 0.5px;">POWER</span>
            </div>
            <div style="width: 100%; height: 2.5px; background: #F58220; margin: 4px 0 3px 0; border-radius: 1px;"></div>
            <div style="display: flex; align-items: center; justify-content: flex-end; line-height: 1;">
                <span style="font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 800; font-size: 1.08rem; color: #F58220; letter-spacing: 1.2px;">S</span>
                <svg width="16" height="16" viewBox="0 0 24 24" style="margin: 0 1px; vertical-align: middle;">
                    <path d="M12 1v3M12 20v3M1 12h3M20 12h3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12" stroke="#F58220" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="12" cy="12" r="5" fill="#0284c7"/>
                    <path d="M9 12c.5-.5 1.5-.5 2 0s1.5.5 2 0 1.5-.5 2 0" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" fill="none"/>
                </svg>
                <span style="font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 800; font-size: 1.08rem; color: #F58220; letter-spacing: 1.5px;">LAROOF</span>
            </div>
        </div>
    @endif
</div>
