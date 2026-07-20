<div class="form-card mt-4">
    <div class="form-card-header bg-warning-subtle text-warning-emphasis">
        <div class="section-dot" style="background-color: #f58220;"></div>
        <h6>Proposal Customization (PDF Settings)</h6>
    </div>
    <div class="form-card-body">
        <p class="text-muted small mb-4">
            Customize the details that will be rendered on the 9-page proposal PDF. Defaults matching the Delicate Solar sample are pre-filled.
        </p>

        <!-- Tab headers -->
        <ul class="nav nav-tabs mb-4" id="proposalTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="cover-tab" data-bs-toggle="tab" data-bs-target="#cover-pane" type="button" role="tab">Cover &amp; Agent</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial-pane" type="button" role="tab">Financials &amp; Bank</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="bom-tab" data-bs-toggle="tab" data-bs-target="#bom-pane" type="button" role="tab">BOM (Panel, Inverter, Cables, Structure)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="bos-tab" data-bs-toggle="tab" data-bs-target="#bos-pane" type="button" role="tab">Balance of System &amp; Warranty</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="savings-tab" data-bs-toggle="tab" data-bs-target="#savings-pane" type="button" role="tab">Savings Spec</button>
            </li>
        </ul>

        <!-- Tab contents -->
        <div class="tab-content" id="proposalTabContent">
            
            <!-- Tab 1: Cover & Agent -->
            <div class="tab-pane fade show active" id="cover-pane" role="tabpanel" aria-labelledby="cover-tab">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="field-label">System Size</label>
                        <input type="text" name="system_size" class="form-field" value="{{ old('system_size', $quotation->system_size ?? '1.77 KW') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Proposal Prepared By</label>
                        <input type="text" name="created_by_name" class="form-field" value="{{ old('created_by_name', $quotation->created_by_name ?? 'GAYATRI KATARIYA') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Prepared By Phone</label>
                        <input type="text" name="created_by_phone" class="form-field" value="{{ old('created_by_phone', $quotation->created_by_phone ?? '8238340836') }}">
                    </div>
                </div>
            </div>

            <!-- Tab 2: Financials & Bank -->
            <div class="tab-pane fade" id="financial-pane" role="tabpanel" aria-labelledby="financial-tab">
                <div class="row g-3">
                    <div class="col-12 col-md-3">
                        <label class="field-label">Per kW Rate (₹)</label>
                        <input type="text" name="per_kw_rate" class="form-field" value="{{ old('per_kw_rate', $quotation->per_kw_rate ?? '51,231') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Rooftop Plant Cost (₹)</label>
                        <input type="text" name="rooftop_amount" class="form-field" value="{{ old('rooftop_amount', $quotation->rooftop_amount ?? '90,679.00') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Net Metering Cost (₹)</label>
                        <input type="text" name="net_metering_cost" class="form-field" value="{{ old('net_metering_cost', $quotation->net_metering_cost ?? '0.00') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">MNRE Subsidy (₹)</label>
                        <input type="text" name="mnre_subsidy" class="form-field" value="{{ old('mnre_subsidy', $quotation->mnre_subsidy ?? '53,100.00') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Final Effective Cost (₹)</label>
                        <input type="text" name="final_effective_cost" class="form-field" value="{{ old('final_effective_cost', $quotation->final_effective_cost ?? '37,579') }}">
                    </div>
                    
                    <div class="col-12 mt-3"><hr><h6>Bank Details</h6></div>
                    
                    <div class="col-12 col-md-4">
                        <label class="field-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-field" value="{{ old('bank_name', $quotation->bank_name ?? 'ICICI BANK LTD') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Account Name</label>
                        <input type="text" name="bank_account_name" class="form-field" value="{{ old('bank_account_name', $quotation->bank_account_name ?? 'DELICATE SOLAR PVT.LTD') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Account Number</label>
                        <input type="text" name="bank_account_no" class="form-field" value="{{ old('bank_account_no', $quotation->bank_account_no ?? '213105010871') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">IFSC Code</label>
                        <input type="text" name="bank_ifsc" class="form-field" value="{{ old('bank_ifsc', $quotation->bank_ifsc ?? 'ICIC0002131') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Branch</label>
                        <input type="text" name="bank_branch" class="form-field" value="{{ old('bank_branch', $quotation->bank_branch ?? 'KARJAN (391240)') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">GST No.</label>
                        <input type="text" name="bank_gst_no" class="form-field" value="{{ old('bank_gst_no', $quotation->bank_gst_no ?? '24AAGCD4220Q1ZK') }}">
                    </div>
                </div>
            </div>

            <!-- Tab 3: BOM -->
            <div class="tab-pane fade" id="bom-pane" role="tabpanel" aria-labelledby="bom-tab">
                <div class="row g-3">
                    <div class="col-12"><h6>Solar Panel Specification</h6></div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Watt Peak</label>
                        <input type="text" name="panel_watt_peak" class="form-field" value="{{ old('panel_watt_peak', $quotation->panel_watt_peak ?? '590 Wp') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Panel Qty</label>
                        <input type="text" name="panel_qty" class="form-field" value="{{ old('panel_qty', $quotation->panel_qty ?? '3 Nos') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Panel Type</label>
                        <input type="text" name="panel_type" class="form-field" value="{{ old('panel_type', $quotation->panel_type ?? 'MonoBifacial') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Panel Make</label>
                        <input type="text" name="panel_make" class="form-field" value="{{ old('panel_make', $quotation->panel_make ?? 'TATA') }}">
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="field-label">Open Circuit Voltage (V)</label>
                        <input type="text" name="panel_open_circuit_voltage" class="form-field" value="{{ old('panel_open_circuit_voltage', $quotation->panel_open_circuit_voltage ?? '52.31') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Maximum Voltage (V)</label>
                        <input type="text" name="panel_max_voltage" class="form-field" value="{{ old('panel_max_voltage', $quotation->panel_max_voltage ?? '43.71') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Short Circuit Current (A)</label>
                        <input type="text" name="panel_short_circuit_current" class="form-field" value="{{ old('panel_short_circuit_current', $quotation->panel_short_circuit_current ?? '14.11') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Maximum Current (A)</label>
                        <input type="text" name="panel_max_current" class="form-field" value="{{ old('panel_max_current', $quotation->panel_max_current ?? '13.27') }}">
                    </div>

                    <div class="col-12 mt-3"><hr><h6>Inverter Specification</h6></div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Inverter Size</label>
                        <input type="text" name="inverter_size" class="form-field" value="{{ old('inverter_size', $quotation->inverter_size ?? '1.00 kW') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Inverter Qty</label>
                        <input type="text" name="inverter_qty" class="form-field" value="{{ old('inverter_qty', $quotation->inverter_qty ?? '1 Nos') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Inverter Make</label>
                        <input type="text" name="inverter_make" class="form-field" value="{{ old('inverter_make', $quotation->inverter_make ?? 'TATA') }}">
                    </div>

                    <div class="col-12 mt-3"><hr><h6>Cables Specification</h6></div>
                    <div class="col-12 col-md-9">
                        <label class="field-label">AC Cable Specification</label>
                        <input type="text" name="cable_ac" class="form-field" value="{{ old('cable_ac', $quotation->cable_ac ?? '1C x 2.5Sq.mm FR PVC COPPER FLEXIBLE 1100V IS7098 part 1/1998') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">AC Qty</label>
                        <input type="text" name="cable_ac_qty" class="form-field" value="{{ old('cable_ac_qty', $quotation->cable_ac_qty ?? '1') }}">
                    </div>
                    
                    <div class="col-12 col-md-9">
                        <label class="field-label">DC Cable Specification</label>
                        <input type="text" name="cable_dc" class="form-field" value="{{ old('cable_dc', $quotation->cable_dc ?? '1Cx 4Sq.mm SOLAR FLEXIBLE TINNED COPPER EN-TYP (EN50618)') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">DC Qty</label>
                        <input type="text" name="cable_dc_qty" class="form-field" value="{{ old('cable_dc_qty', $quotation->cable_dc_qty ?? '1') }}">
                    </div>

                    <div class="col-12 col-md-9">
                        <label class="field-label">Earthing Cable Specification</label>
                        <input type="text" name="cable_earthing" class="form-field" value="{{ old('cable_earthing', $quotation->cable_earthing ?? '1C x 2.5Sq.mm FR PVC COPPER FLEXIBLE 1100V') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Earthing Qty</label>
                        <input type="text" name="cable_earthing_qty" class="form-field" value="{{ old('cable_earthing_qty', $quotation->cable_earthing_qty ?? '2') }}">
                    </div>

                    <div class="col-12 col-md-9">
                        <label class="field-label">LA Cable Specification</label>
                        <input type="text" name="cable_la" class="form-field" value="{{ old('cable_la', $quotation->cable_la ?? '1C x 16Sq.mm Flexible Alu. Cable') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">LA Qty</label>
                        <input type="text" name="cable_la_qty" class="form-field" value="{{ old('cable_la_qty', $quotation->cable_la_qty ?? '1') }}">
                    </div>

                    <div class="col-12 mt-3"><hr><h6>Structure</h6></div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Structure Height Label</label>
                        <input type="text" name="structure_height" class="form-field" value="{{ old('structure_height', $quotation->structure_height ?? 'Height Of Structure:') }}">
                    </div>
                    <div class="col-12 col-md-8">
                        <label class="field-label">Structure Material &amp; Details</label>
                        <textarea name="structure_material" class="form-field form-field-textarea" rows="2">{{ old('structure_material', $quotation->structure_material ?? "Hot Dip Galvanized(ISO 9001:2008 ,IS 1239):- (1) Rafter:60mm x 40mm x 2mm thickness Pipe = 130/- per ft, (2) Purlin:40mm x 40mm x 2mm thickness Pipe = 105/- per ft") }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Balance of System & Warranty -->
            <div class="tab-pane fade" id="bos-pane" role="tabpanel" aria-labelledby="bos-tab">
                <div class="row g-3">
                    <div class="col-12"><h6>Balance of System</h6></div>
                    <div class="col-12">
                        <label class="field-label">ACDB Details</label>
                        <textarea name="bos_acdb" class="form-field form-field-textarea" rows="2">{{ old('bos_acdb', $quotation->bos_acdb ?? "AC SPD:- ELMEX / FINDER T1+T2 TYPE 2 230 VAC; AC MCB:- SCHNEIDER/L&T 1Ph 32 AMP 2 POLE; BOX:- 225185100 ABS (4 NOS.) PC Enclosure IP65 / Aproved by Tata- 1") }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="field-label">DCDB Details</label>
                        <textarea name="bos_dcdb" class="form-field form-field-textarea" rows="2">{{ old('bos_dcdb', $quotation->bos_dcdb ?? "DC SPD:- ELMEX / FINDER 600 VDC TYPE 2; DC FUSE:- ELMEX 1000 VDC/ Aproved by Tata- 1") }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="field-label">Earthing Details</label>
                        <textarea name="bos_earthing" class="form-field form-field-textarea" rows="1">{{ old('bos_earthing', $quotation->bos_earthing ?? "CBR-14MM/1MTR/MOLE TYPE - (As per IS 3043 - 2018)") }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="field-label">Lightning Arrestor Details</label>
                        <textarea name="bos_la" class="form-field form-field-textarea" rows="1">{{ old('bos_la', $quotation->bos_la ?? "SINGLE SPIKE - 14MM/1MTR, (As per NFC-17-102:2011/IEC 62305 Standards)") }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="field-label">Protection System Details</label>
                        <textarea name="bos_protection_system" class="form-field form-field-textarea" rows="2">{{ old('bos_protection_system', $quotation->bos_protection_system ?? "Schneider + Elmex | Surge Protecting Devices, MCCBs, Relays etc.") }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="field-label">LT/ HT Panels Details</label>
                        <textarea name="bos_lt_ht_panels" class="form-field form-field-textarea" rows="2">{{ old('bos_lt_ht_panels', $quotation->bos_lt_ht_panels ?? "Tata Power Approved | Air Circuit Breakers, Switching Devices, Bus Bars etc. RPR Not considered- if required that will be in client scope") }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="field-label">Metering Details</label>
                        <textarea name="bos_metering" class="form-field form-field-textarea" rows="2">{{ old('bos_metering', $quotation->bos_metering ?? "SECURE/HPL/L&T | As per Solar Policy") }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="field-label">Miscellaneous Item Details</label>
                        <textarea name="bos_misc" class="form-field form-field-textarea" rows="3">{{ old('bos_misc', $quotation->bos_misc ?? "1. PV-M Fitting Accessories:-(1)ALUMINIUM MID CLAMP 25/35 MM CUTTING LENGTH X75 MM & ALUMINIUM END CLAMP 30/35/40 MM LENGTH X 75 MM (2)SS 304 U BOLT 5/16 X 60 X 40 X 60 BOLT & 2 FLANGE NUT 70 X 40 X 70 (3)uPVC Ele. Conduit Pipe & Fittings:-25 MM LMS WHITE (IS 9537 P3 AND IS 3419) (4)Saddle:-25 mm GI") }}</textarea>
                    </div>

                    <div class="col-12 mt-3"><hr><h6>Warranty Details</h6></div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Panel Warranty</label>
                        <input type="text" name="warranty_panel" class="form-field" value="{{ old('warranty_panel', $quotation->warranty_panel ?? '12 Year') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Performance Warranty</label>
                        <input type="text" name="warranty_performance" class="form-field" value="{{ old('warranty_performance', $quotation->warranty_performance ?? '30 Year') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">Inverter Warranty</label>
                        <input type="text" name="warranty_inverter" class="form-field" value="{{ old('warranty_inverter', $quotation->warranty_inverter ?? '10 Year') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="field-label">System Warranty</label>
                        <input type="text" name="warranty_system" class="form-field" value="{{ old('warranty_system', $quotation->warranty_system ?? '5 Year') }}">
                    </div>
                </div>
            </div>

            <!-- Tab 5: Savings Spec -->
            <div class="tab-pane fade" id="savings-pane" role="tabpanel" aria-labelledby="savings-tab">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="field-label">Payback Period</label>
                        <input type="text" name="savings_payback" class="form-field" value="{{ old('savings_payback', $quotation->savings_payback ?? '1.83 Years') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Average Yearly Generation</label>
                        <input type="text" name="savings_yearly_generation" class="form-field" value="{{ old('savings_yearly_generation', $quotation->savings_yearly_generation ?? '2584.2 Units') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Average Annual Savings</label>
                        <input type="text" name="savings_annual_savings" class="form-field" value="{{ old('savings_annual_savings', $quotation->savings_annual_savings ?? 'Rs. 20,673.6') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Project Cost (on Savings page)</label>
                        <input type="text" name="savings_project_cost" class="form-field" value="{{ old('savings_project_cost', $quotation->savings_project_cost ?? 'Rs. 90,679') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">Trees Saved</label>
                        <input type="text" name="savings_trees_saved" class="form-field" value="{{ old('savings_trees_saved', $quotation->savings_trees_saved ?? '88') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="field-label">CO2 Reduction</label>
                        <input type="text" name="savings_co2_reduction" class="form-field" value="{{ old('savings_co2_reduction', $quotation->savings_co2_reduction ?? '2 Tonnes') }}">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
